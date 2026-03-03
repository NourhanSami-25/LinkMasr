<?php

namespace App\Services;

use App\Models\ConstructionBoq;
use App\Models\BoqBreakdownItem;
use App\Models\BoqBreakdownCategory;

class BoqBreakdownService
{
    /**
     * Get breakdown summary for a BOQ item.
     */
    public function getBreakdownSummary(ConstructionBoq $boq): array
    {
        $categories = BoqBreakdownCategory::orderBy('sort_order')->get();
        $items = $boq->breakdownItems()->with('category')->get();
        
        $summary = [];
        $grandTotal = 0;
        
        foreach ($categories as $category) {
            $categoryItems = $items->where('category_id', $category->id);
            $categoryTotal = $categoryItems->sum('total_price');
            $grandTotal += $categoryTotal;
            
            $summary[] = [
                'category' => $category,
                'items' => $categoryItems,
                'total' => round($categoryTotal, 2),
            ];
        }
        
        return [
            'boq' => $boq,
            'summary' => $summary,
            'grand_total' => round($grandTotal, 2),
            'boq_total' => round($boq->total_price, 2),
            'difference' => round($boq->total_price - $grandTotal, 2),
        ];
    }

    /**
     * Calculate breakdown percentages by category.
     */
    public function getCategoryPercentages(ConstructionBoq $boq): array
    {
        $items = $boq->breakdownItems()->with('category')->get();
        $grandTotal = $items->sum('total_price');
        
        if ($grandTotal == 0) {
            return [];
        }
        
        $categories = BoqBreakdownCategory::orderBy('sort_order')->get();
        $percentages = [];
        
        foreach ($categories as $category) {
            $categoryTotal = $items->where('category_id', $category->id)->sum('total_price');
            $percentages[$category->code] = [
                'name' => $category->name_ar,
                'total' => round($categoryTotal, 2),
                'percentage' => round(($categoryTotal / $grandTotal) * 100, 2),
            ];
        }
        
        return $percentages;
    }

    /**
     * Validate breakdown total matches BOQ total.
     */
    public function validateBreakdown(ConstructionBoq $boq, float $tolerance = 0.01): bool
    {
        $breakdownTotal = $boq->breakdownItems->sum('total_price');
        $difference = abs($boq->total_price - $breakdownTotal);
        
        return $difference <= ($boq->total_price * $tolerance);
    }

    /**
     * Get project-level breakdown summary.
     */
    public function getProjectBreakdownSummary(int $projectId): array
    {
        $boqs = ConstructionBoq::where('project_id', $projectId)
            ->with('breakdownItems.category')
            ->get();
        
        $categories = BoqBreakdownCategory::orderBy('sort_order')->get();
        $projectSummary = [];
        $grandTotal = 0;
        
        foreach ($categories as $category) {
            $categoryTotal = 0;
            foreach ($boqs as $boq) {
                $categoryTotal += $boq->breakdownItems
                    ->where('category_id', $category->id)
                    ->sum('total_price');
            }
            $grandTotal += $categoryTotal;
            
            $projectSummary[] = [
                'category' => $category,
                'total' => round($categoryTotal, 2),
            ];
        }
        
        // Add percentages
        foreach ($projectSummary as &$item) {
            $item['percentage'] = $grandTotal > 0 
                ? round(($item['total'] / $grandTotal) * 100, 2) 
                : 0;
        }
        
        return [
            'summary' => $projectSummary,
            'grand_total' => round($grandTotal, 2),
            'boq_total' => round($boqs->sum('total_price'), 2),
        ];
    }
}
