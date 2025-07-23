<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrinterTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            PrinterType::insert([
            ['name' => 'LaserJet'],
            ['name' => 'InkJet'],
            ['name' => 'Multifunkční'],
            ['name' => 'Barevná'],
        ]);
    }
}
