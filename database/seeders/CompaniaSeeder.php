<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CompaniaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('companias')->insert([
            'ruc' => Str::random(13),
            'razon_social' => Str::random(100),
            'estado' => 'ACT'
        ]);
    }
}
