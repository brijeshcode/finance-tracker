<?php

namespace Database\Seeders\Admin;

use App\Models\Investors\InvestorPlatform;
use Illuminate\Database\Seeder;

class InvestorPlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        $x = [
            ['user_id' => 2, 'platform_id' => 1],
            ['user_id' => 2, 'platform_id' => 2],
            ['user_id' => 2, 'platform_id' => 3],
        ];

        foreach ($x as $y){
            InvestorPlatform::create($y);
        }
    }
}
