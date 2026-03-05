<?php

namespace App\Services;

use App\Models\construction\ConstructionBoq;
use App\Models\project\Project;

class ConstructionService
{
    /**
     * Get project summary for EVM calculations
     */
    public function getProjectSummary($projectId)
    {
        $project = Project::findOrFail($projectId);
        $boqItems = ConstructionBoq::where('project_id', $projectId)->get();

        if ($boqItems->isEmpty()) {
            return [
                'bac' => 0, // Budget at Completion
                'ac' => 0,  // Actual Cost
                'ev' => 0,  // Earned Value
                'pv' => 0,  // Planned Value
                'cv' => 0,  // Cost Variance
                'sv' => 0,  // Schedule Variance
                'cpi' => 1, // Cost Performance Index
                'spi' => 1, // Schedule Performance Index
                'eac' => 0, // Estimate at Completion
                'etc' => 0, // Estimate to Complete
            ];
        }

        // Calculate BAC (Budget at Completion)
        $bac = $boqItems->sum('total_price');

        // Calculate AC (Actual Cost) - using the calculated actual_cost attribute
        $ac = $boqItems->sum('actual_cost');

        // Calculate EV (Earned Value) based on progress
        $ev = $boqItems->sum(function ($item) {
            return ($item->total_price * $item->progress_percentage) / 100;
        });

        // For PV (Planned Value), we'll use a simple calculation
        // In a real scenario, this would be based on project schedule
        $totalProgress = $boqItems->avg('progress_percentage') ?? 0;
        $pv = ($bac * $totalProgress) / 100;

        // Calculate variances
        $cv = $ev - $ac; // Cost Variance
        $sv = $ev - $pv; // Schedule Variance

        // Calculate performance indices
        $cpi = $ac > 0 ? $ev / $ac : 1; // Cost Performance Index
        $spi = $pv > 0 ? $ev / $pv : 1; // Schedule Performance Index

        // Calculate estimates
        $eac = $cpi > 0 ? $bac / $cpi : $bac; // Estimate at Completion
        $etc = $eac - $ac; // Estimate to Complete

        return [
            'bac' => round($bac, 2),
            'ac' => round($ac, 2),
            'ev' => round($ev, 2),
            'pv' => round($pv, 2),
            'cv' => round($cv, 2),
            'sv' => round($sv, 2),
            'cpi' => round($cpi, 3),
            'spi' => round($spi, 3),
            'eac' => round($eac, 2),
            'etc' => round($etc, 2),
        ];
    }

    /**
     * Get project performance status
     */
    public function getProjectStatus($projectId)
    {
        $summary = $this->getProjectSummary($projectId);
        
        $cpi = $summary['cpi'];
        $spi = $summary['spi'];

        if ($cpi < 0.9 || $spi < 0.9) {
            return 'at_risk';
        } elseif ($cpi >= 1.1 && $spi >= 1.1) {
            return 'ahead';
        } else {
            return 'on_track';
        }
    }
}