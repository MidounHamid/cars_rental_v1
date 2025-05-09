<?php

namespace App\Services;

use App\Models\Promotion;
use Carbon\Carbon;

class PromotionService
{
    /**
     * Calculate the discount amount for a booking based on the promotion period
     * 
     * @param float $dailyRate The daily rental rate
     * @param Carbon $startDate The booking start date
     * @param Carbon $endDate The booking end date
     * @param Promotion|null $promotion The promotion to apply
     * @return array Returns [discountAmount, discountedDays, discountPercent]
     */
    public function calculateBookingDiscount($dailyRate, Carbon $startDate, Carbon $endDate, ?Promotion $promotion)
    {
        if (!$promotion) {
            return [0, 0, 0];
        }

        // Convert dates to Carbon instances if they aren't already
        $promoStart = Carbon::parse($promotion->starts_at);
        $promoEnd = Carbon::parse($promotion->expires_at);
        
        // Initialize counters
        $discountedDays = 0;
        
        // The rental period is from startDate to the day before endDate
        $currentDate = $startDate->copy();
        while ($currentDate->lt($endDate)) {
            if ($currentDate->between($promoStart, $promoEnd)) {
                $discountedDays++;
            }
            $currentDate->addDay();
        }
        
        // Calculate discount only for the days that fall within the promotion period
        $discountAmount = ($dailyRate * $discountedDays * $promotion->discount_percent) / 100;
        
        return [
            $discountAmount,
            $discountedDays,
            $promotion->discount_percent
        ];
    }
}
