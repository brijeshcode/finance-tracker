<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\InvestmentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvestmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Stocks'],
            ['name' => 'Mutual fund'],
            ['name' => 'SGB'],
            ['name' => 'REIT'],
            ['name' => 'FD'],
            ['name' => 'ETF'],
            ['name' => 'PF'],
            ['name' => 'T-Bills'],
            
        ];

        foreach ($types as $type){
            InvestmentType::create($type);
        }
    }
}
