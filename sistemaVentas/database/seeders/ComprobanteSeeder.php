<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comprobante;

class ComprobanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Comprobante::insert([
            [
               'tipo_comprobante' => 'boleta'
            ],
            [
               'tipo_comprobante' => 'factura'
            ],
          
        ]);
    }
}
