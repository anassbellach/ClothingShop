<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Discount;
use App\Models\Product;

class DiscountSeeder extends Seeder
{
    public function run(): void
    {
        // Create discounts
        $discounts = [
            [
                'code' => 'SAVE10',
                'type' => 'percentage',
                'value' => 10.00,
                'max_uses' => 100,
                'used_count' => 0,
                'starts_at' => now()->timestamp, // Unix timestamp
                'expires_at' => now()->addMonth()->timestamp, // Unix timestamp
                'created_at' => now()->timestamp, // Unix timestamp
                'updated_at' => now()->timestamp, // Unix timestamp
            ],
            [
                'code' => 'FREESHIP',
                'type' => 'fixed',
                'value' => 5.00,
                'max_uses' => 50,
                'used_count' => 0,
                'starts_at' => now()->timestamp, // Unix timestamp
                'expires_at' => now()->addWeek()->timestamp, // Unix timestamp
                'created_at' => now()->timestamp, // Unix timestamp
                'updated_at' => now()->timestamp, // Unix timestamp
            ],
        ];

        foreach ($discounts as $discountData) {
            Discount::create($discountData);
        }

        $this->command->info('Discounts seeded successfully!');
    }
}
