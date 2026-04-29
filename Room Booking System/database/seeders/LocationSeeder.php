<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('locations')->insert([
            ['location_name' => 'Bilik Mesyuarat Alamanda (Aras 5)'],
            ['location_name' => 'Bilik Seminar Teratai (Aras 5)'],
            ['location_name' => 'Bilik Bincang Iris (Aras 5)'],
            ['location_name' => 'Bilik Seminar Acacia (Aras 3)'],
            ['location_name' => 'Bilik Seminar Lavender (Aras 2)'],
            ['location_name' => 'Auditorium Raflesia'],
            ['location_name' => 'Lobi Utama'],
            ['location_name' => 'Lobi Klinik Pakar'],
            ['location_name' => 'Bilik Latihan IT(1)'],
            ['location_name' => 'Bilik Latihan IT(2)'],
        ]);
    }
}
