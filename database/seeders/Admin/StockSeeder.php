<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\Stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         
        $types = [
            ['name' => 'Indian Oil Corporation', 'symbol' => 'IOC', 'nse_code' => 'IOC', 'bse_code' => '530965'],
            ['name' => 'Vedanta Ltd', 'symbol' => 'VEDL', 'nse_code' => 'VEDL', 'bse_code' => '500295'],
            ['name' => 'Life insurance corporation of india', 'symbol' => 'LIC', 'nse_code' => 'LIC', 'bse_code' => '543526'],
            ['name' => 'Trident Ltd', 'symbol' => 'TRIDENT', 'nse_code' => 'TRIDENT', 'bse_code' => '521064'],
            ['name' => 'Central Depository Services (India) Ltd', 'symbol' => 'CDSL', 'nse_code' => 'CDSL', 'bse_code' => ''],
            ['name' => 'Infosys Ltd', 'symbol' => 'INFY', 'nse_code' => 'INFY', 'bse_code' => '500209'],
            ['name' => 'Godawari Power & Ispat Ltd', 'symbol' => 'GPIL', 'nse_code' => 'GPIL', 'bse_code' => '532734'],
            ['name' => 'Wipro Ltd', 'symbol' => 'WIPRO', 'nse_code' => 'WIPRO', 'bse_code' => '507685'],
            
        ];

        foreach ($types as $type){
            Stock::firstOrCreate($type);
        }

    }
}
