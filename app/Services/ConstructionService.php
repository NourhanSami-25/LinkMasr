<?php

namespace App\Services;

use App\Models\ConstructionBoq;
use App\Models\ConstructionProgress;
use App\Models\finance\Expense;
use Carbon\Carbon;

class ConstructionService
{
    /**
     * Calculate EVM metrics for a specific BOQ Item.
     * 
     * @param ConstructionBoq $boqItem
     * @return array
     */
    public function calculateMetrics(ConstructionBoq $boqItem): array
    {
        // 1. Budget at Completion (BAC)
        $BAC = $boqItem->total_price;

        // 2. Planned Value (PV)
        // Formula: (Days Elapsed / Total Duration) * BAC
        $PV = 0;
        if ($boqItem->start_date && $boqItem->end_date) {
            $startDate = Carbon::parse($boqItem->start_date);
            $endDate = Carbon::parse($boqItem->end_date);
            $today = Carbon::now();

            if ($today->lt($startDate)) {
                $PV = 0;
            } elseif ($today->gt($endDate)) {
                $PV = $BAC;
            } else {
                $totalDays = $startDate->diffInDays($endDate) ?: 1;
                $elapsedDays = $startDate->diffInDays($today);
                $progressPercent = ($elapsedDays / $totalDays);
                $PV = $BAC * $progressPercent;
            }
        }

        // 3. Earned Value (EV)
        // Formula: Actual Quantity * Budget Unit Rate
        // Get cumulative actual quantity from progress logs
        $actualQty = $boqItem->progress()->where('status', 'approved')->sum('actual_quantity');
        $EV = $actualQty * $boqItem->unit_price;

        // 4. Actual Cost (AC)
        // Formula: Sum of expenses linked to this BOQ item
        $AC = Expense::where('boq_id', $boqItem->id)->sum('total');

        // 5. Variances
        $CV = $EV - $AC;
        $SV = $EV - $PV;

        // 6. Indices
        $CPI = $AC > 0 ? ($EV / $AC) : ($EV > 0 ? 1 : 0); // If EV>0 and AC=0, infinite efficiency? Cap at 1 or handle distinct.
        $SPI = $PV > 0 ? ($EV / $PV) : ($EV > 0 ? 1 : 0);

        return [
            'BAC' => $BAC,
            'PV' => round($PV, 2),
            'EV' => round($EV, 2),
            'AC' => round($AC, 2),
            'CV' => round($CV, 2),
            'SV' => round($SV, 2),
            'CPI' => round($CPI, 2),
            'SPI' => round($SPI, 2),
            'completion_percent' => $BAC > 0 ? round(($EV / $BAC) * 100, 2) : 0,
        ];
    }

    /**
     * Calculate Project-Level EVM Summary
     */
    public function getProjectSummary($projectId): array
    {
        $boqItems = ConstructionBoq::where('project_id', $projectId)->get();
        
        $totalBAC = $boqItems->sum('total_price');
        $totalPV = 0;
        $totalEV = 0;
        $totalAC = 0;
        
        foreach ($boqItems as $item) {
            $metrics = $this->calculateMetrics($item);
            $totalPV += $metrics['PV'];
            $totalEV += $metrics['EV'];
            $totalAC += $metrics['AC'];
        }
        
        $CV = $totalEV - $totalAC;
        $SV = $totalEV - $totalPV;
        $CPI = $totalAC > 0 ? ($totalEV / $totalAC) : 0;
        $SPI = $totalPV > 0 ? ($totalEV / $totalPV) : 0;
        
        return [
            'bac' => round($totalBAC, 2),
            'pv' => round($totalPV, 2),
            'ev' => round($totalEV, 2),
            'ac' => round($totalAC, 2),
            'cv' => round($CV, 2),
            'sv' => round($SV, 2),
            'cpi' => round($CPI, 2),
            'spi' => round($SPI, 2),
        ];
    }
    
    /**
     * Get Cost Control Table Data
     */
    public function getCostControlTable($projectId): array
    {
        $boqItems = ConstructionBoq::where('project_id', $projectId)->get();
        $data = [];
        
        foreach ($boqItems as $item) {
            $metrics = $this->calculateMetrics($item);
            $actualQty = $item->progress()->where('status', 'approved')->sum('actual_quantity');
            
            $data[] = [
                'item_name' => $item->item_name,
                'planned_qty' => $item->quantity,
                'actual_qty' => $actualQty,
                'unit' => $item->unit,
                'unit_price' => $item->unit_price,
                'pv' => $metrics['PV'],
                'ev' => $metrics['EV'],
                'ac' => $metrics['AC'],
                'cv' => $metrics['CV'],
                'sv' => $metrics['SV'],
                'cpi' => $metrics['CPI'],
                'spi' => $metrics['SPI'],
            ];
        }
        
        return $data;
    }

    /**
     * Get S-Curve Chart Data (Cumulative PV & EV over time)
     */
    public function getChartData($projectId)
    {
        $boqItems = ConstructionBoq::where('project_id', $projectId)->get();
        if ($boqItems->isEmpty()) return ['labels' => [], 'pv' => [], 'ev' => [], 'ac' => []];

        // 1. Determine Timeline range (Earliest Start to Latest End)
        $minDate = $boqItems->min('start_date');
        $maxDate = $boqItems->max('end_date');
        
        if (!$minDate || !$maxDate) return ['labels' => [], 'pv' => [], 'ev' => [], 'ac' => []];

        $start = Carbon::parse($minDate);
        $end = Carbon::parse($maxDate);
        $period = $start->daysUntil($end);

        $labels = [];
        $cumulativePV = [];
        $cumulativeEV = [];
        $cumulativeAC = [];

        // Pre-fetch progress logs
        // This is a simplified approach. Ideally we aggregate on DB side for performance.
        $allProgress = ConstructionProgress::whereIn('boq_id', $boqItems->pluck('id'))
                        ->where('status', 'approved')
                        ->orderBy('date')
                        ->get()
                        ->groupBy(function($item) {
                            return Carbon::parse($item->date)->format('Y-m-d');
                        });

        $runningPV = 0;
        $runningEV = 0;

        foreach ($period as $date) {
            $dateStr = $date->format('Y-m-d');
            $labels[] = $dateStr;
            
            // Calculate Daily PV increment for all active items
            $dailyPV = 0;
            foreach ($boqItems as $item) {
                if ($item->start_date && $item->end_date) {
                    $s = Carbon::parse($item->start_date);
                    $e = Carbon::parse($item->end_date);
                    if ($date->between($s, $e)) {
                        $totalDays = $s->diffInDays($e) + 1;
                        $dailyPV += ($item->total_price / $totalDays);
                    }
                }
            }
            $runningPV += $dailyPV;
            $cumulativePV[] = round($runningPV, 2);

            // Calculate Daily EV increment from logs
            if (isset($allProgress[$dateStr])) {
                foreach ($allProgress[$dateStr] as $log) {
                    $item = $boqItems->find($log->boq_id);
                    if ($item) {
                        $runningEV += ($log->actual_quantity * $item->unit_price);
                    }
                }
            }
            // EV only accumulates up to today? Or fill forward? 
            // Usually S-Curve shows EV up to current date.
            if ($date->lte(Carbon::now())) {
                $cumulativeEV[] = round($runningEV, 2);
                
                // Calculate cumulative AC up to this date
                $acUpToDate = Expense::whereIn('boq_id', $boqItems->pluck('id'))
                    ->whereDate('date', '<=', $dateStr)
                    ->sum('total');
                $cumulativeAC[] = round($acUpToDate, 2);
            }
        }

        return [
            'labels' => $labels,
            'pv' => $cumulativePV,
            'ev' => $cumulativeEV,
            'ac' => $cumulativeAC,
        ];
    }
}
