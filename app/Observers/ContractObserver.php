<?php

namespace App\Observers;

use App\Models\business\Contract;
use App\Models\common\File;
use App\Models\reminder\Reminder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Services\common\FileService;
use App\Services\utility\NotificationService;
use App\Models\user\User;


class ContractObserver
{
    protected $fileService;
    protected $notificationService;
    
    public function __construct(FileService $fileService, NotificationService $notificationService)
    {
        $this->fileService = $fileService;
        $this->notificationService = $notificationService;
    }

    public function deleting(Contract $contract)
    {
        try {
            Reminder::where('referable_type', Contract::class)
                ->where('referable_id', $contract->id)
                ->delete();

            $files = File::where('referable_type', Contract::class)
                ->where('referable_id', $contract->id)
                ->get();

            foreach ($files as $file) {
                if ($file->path) {
                    Storage::disk('public')->delete($file->path);
                }
                $file->delete();
            }

            // Delete the model's directory after all files are deleted
            $folderName = $this->fileService->getModelFolder($contract->id, $contract->created_at);
            $directoryPath = "lexpro/contract/{$folderName}";
            if (Storage::disk('public')->exists($directoryPath)) {
                Storage::disk('public')->deleteDirectory($directoryPath);
            }
        } catch (\Exception $e) {
            Log::error('Error cleaning up related records for deleted contract: ' . $e->getMessage());
        }
    }

    /**
     * Handle the Contract "created" event.
     * Update unit status when contract is created.
     */
    public function created(Contract $contract): void
    {
        $this->updateUnitStatus($contract);
    }

    /**
     * Handle the Contract "updated" event.
     * Update unit status when contract status changes.
     */
    public function updated(Contract $contract): void
    {
        if ($contract->isDirty('status') || $contract->isDirty('unit_id')) {
            $this->updateUnitStatus($contract);
        }
    }

    /**
     * Update property unit status based on contract
     */
    private function updateUnitStatus(Contract $contract): void
    {
        if (!$contract->unit_id) return;

        try {
            $unit = \App\Models\real_estate\PropertyUnit::find($contract->unit_id);
            if (!$unit) return;

            // Map contract status to unit status
            switch ($contract->status) {
                case 'signed':
                case 'active':
                    $unit->status = 'sold';
                    $unit->sold_date = $contract->date;
                    $unit->buyer_id = $contract->client_id;
                    break;
                case 'pending':
                case 'draft':
                    $unit->status = 'reserved';
                    break;
                case 'expired':
                case 'cancelled':
                    // Only reset if this contract was the one that reserved/sold it
                    if ($unit->buyer_id == $contract->client_id) {
                        $unit->status = 'available';
                        $unit->sold_date = null;
                        $unit->buyer_id = null;
                    }
                    break;
            }
            
            $unit->save();
            
            // Notify about unit status change
            $this->notifyUnitStatusChange($contract, $unit);
        } catch (\Exception $e) {
            Log::error('Error updating unit status from contract: ' . $e->getMessage());
        }
    }

    /**
     * Notify about unit status change from contract
     */
    private function notifyUnitStatusChange(Contract $contract, $unit): void
    {
        try {
            // Get admins and sales agents to notify
            $userIds = [];
            if ($contract->sale_agent) $userIds[] = $contract->sale_agent;
            if ($contract->created_by) $userIds[] = $contract->created_by;
            
            // Get admins with real_estate access
            $admins = User::whereHas('roles', function($q) {
                $q->where('subject', 'real_estate');
            })->pluck('id')->toArray();
            $userIds = array_merge($userIds, $admins);
            
            if (!empty($userIds)) {
                $users = User::whereIn('id', array_unique(array_filter($userIds)))->get();
                if ($users->isNotEmpty()) {
                    $statusText = __('general.' . $unit->status) ?? $unit->status;
                    $subject = __('general.unit_status_changed') ?? 'Unit Status Changed';
                    $message = __('general.unit_status_changed_to', [
                        'unit' => $unit->name,
                        'status' => $statusText
                    ]) ?? "Unit '{$unit->name}' status changed to '{$statusText}'";
                    
                    $this->notificationService->notify($subject, $message, '/real-estate/units/' . $unit->id, $users);
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to notify unit status change: ' . $e->getMessage());
        }
    }
}
