<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipodocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tipodocs')->insert([
            'nombre' => 'FACTURA',
            'version' => '2.0',
            'dir_xsd' => ''
        ]);

        DB::table('tipodocs')->insert([
            'nombre' => 'NOTA DE CREDITO',
            'version' => '2.0',
            'dir_xsd' => ''
        ]);

        DB::table('tipodocs')->insert([
            'nombre' => 'NOTA DE DEBITO',
            'version' => '2.0',
            'dir_xsd' => ''
        ]);

        DB::table('tipodocs')->insert([
            'nombre' => 'GUIA DE REMISION',
            'version' => '2.0',
            'dir_xsd' => ''
        ]);

        DB::table('tipodocs')->insert([
            'nombre' => 'RETENCIONES',
            'version' => '2.0',
            'dir_xsd' => ''
        ]);

        DB::table('tipodocs')->insert([
            'nombre' => 'LIQUIDACION DE COMPRA',
            'version' => '2.0',
            'dir_xsd' => ''
        ]);


    }
}
