<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\PlatformType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlatformTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platformType = [
            ['name' => 'discount broker'],
            ['name' => 'bank'],
            
        ];

        foreach ($platformType as $platform){
            PlatformType::create($platform);
        }
    }
}
