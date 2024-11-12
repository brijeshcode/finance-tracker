<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\Platform;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platformType = [
            ['name' => 'Groww', 'platform_type_id' => 1],
            ['name' => 'Upstocks', 'platform_type_id' => 1],
            ['name' => 'Zerodha', 'platform_type_id' => 1],
            ['name' => 'PNB', 'platform_type_id' => 2], 
        ];

        foreach ($platformType as $platform){
            Platform::create($platform);
        }
    }
}
