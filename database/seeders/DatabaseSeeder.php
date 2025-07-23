<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Printer;
use App\Models\Toner;
use App\Models\PrinterType;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

	$pt = PrinterType::firstOrCreate(['name' => 'Generic'], ['oid' => config('snmp.default_oid')]);

        $t = Toner::factory()->create([
            'name' => 'Bílý Toner',
            'color' => '#FFFFFF',
            'stock_count' => 10,
            'barcode' => '1234567890123',
            'price' => 500,
        ]);

        Printer::factory()->create([
            'name' => 'Printer Demo',
            'ip_address' => '192.168.1.50',
            'printer_type_id' => $pt->id,
        ])->toners()->attach($t->id, ['installed_at' => now()]);

$this->call(PrinterTypeSeeder::class);


    }
}
