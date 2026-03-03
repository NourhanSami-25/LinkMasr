<?php

namespace App\Services;

use App\Models\real_estate\ConstructionMaterial;
use App\Models\real_estate\CostEstimate;
use Illuminate\Support\Facades\DB;

class ConstructionCostService
{
    /**
     * Get price of a material at a specific date
     */
    public function getMaterialPrice($materialId, $date = null)
    {
        $date = $date ?? now();
        $material = ConstructionMaterial::find($materialId);
        
        if (!$material) return 0;

        return $material->prices()
            ->whereDate('date', '<=', $date)
            ->orderBy('date', 'desc')
            ->first()
            ->price ?? 0;
    }

    /**
     * Create Cost Estimate from Form Data
     */
    public function createEstimate(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Calculate Items Total
            $materialsTotal = 0;
            $itemsToCreate = [];

            foreach ($data['items'] as $item) {
                $materialId = $item['material_id'];
                $qty = $item['quantity'];
                
                // Fetch latest price
                $unitPrice = $this->getMaterialPrice($materialId);
                $subtotal = $qty * $unitPrice;
                
                $materialsTotal += $subtotal;
                
                $itemsToCreate[] = [
                    'material_id' => $materialId,
                    'quantity' => $qty,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal
                ];
            }
            
            // 2. Calculate Final Total
            $totalCost = $materialsTotal + ($data['licensing_fees'] ?? 0) + ($data['other_fees'] ?? 0);

            // 3. Create Estimate Header
            $estimate = CostEstimate::create([
                'title' => $data['title'],
                'project_id' => $data['project_id'] ?? null,
                'unit_id' => $data['unit_id'] ?? null,
                'type' => $data['type'],
                'licensing_fees' => $data['licensing_fees'] ?? 0,
                'other_fees' => $data['other_fees'] ?? 0,
                'materials_total' => $materialsTotal,
                'total_cost' => $totalCost,
                'created_by' => auth()->id()
            ]);

            // 4. Create Items
            foreach ($itemsToCreate as $item) {
                $estimate->items()->create($item);
            }

            return $estimate;
        });
    }
}
