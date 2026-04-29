<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('departments')->insert([
            ['department_name' => 'Jabatan Ortopedik'],
            ['department_name' => 'Jabatan Psikiatri'],
            ['department_name' => 'Jabatan Anestesiologi'],
            ['department_name' => 'Jabatan Perubatan'],
            ['department_name' => 'Jabatan Obstetrik Ginekologi'],
            ['department_name' => 'Jabatan Patologi'],
            ['department_name' => 'Jabatan Kecemasan Trauma'],
            ['department_name' => 'Jabatan Pembedahan Am'],
            ['department_name' => 'Jabatan Pediatrik'],
            ['department_name' => 'Jabatan Radiologi'],
            ['department_name' => 'Jabatan Otorinolaringologi'],
            ['department_name' => 'Jabatan Oftalmologi'],
            ['department_name' => 'Jabatan Forensik'],
            ['department_name' => 'Jabatan Bedah Mulut dan Maksilofasial'],
            ['department_name' => 'Jabatan Rekod Perubatan'],
            ['department_name' => 'Unit Kesihatan Awam'],
            ['department_name' => 'Unit Pengurusan Risiko Pekerjaan'],
            ['department_name' => 'Unit Survelan Klinikal'],
            ['department_name' => 'Unit Pengurusan Risiko Pesakit'],
            ['department_name' => 'Jabatan Farmasi'],
            ['department_name' => 'Jabatan Kerja Sosial'],
            ['department_name' => 'Jabatan Dietetik dan Sajian'],
            ['department_name' => 'Unit Fisioterapi'],
            ['department_name' => 'Unit Pemulihan Carakerja'],
            ['department_name' => 'Unit Credentialing dan Privileging'],
            ['department_name' => 'Unit Penyelidikan Klinikal'],
            ['department_name' => 'Unit Psikologi dan Kaunseling'],
            ['department_name' => 'Unit Kawalan Infeksi'],
            ['department_name' => 'Unit Penyeliaan Hospital'],
            ['department_name' => 'Unit Kejururawatan'],
            ['department_name' => 'Unit Teknologi Maklumat'],
            ['department_name' => 'Unit Kejuruteraan'],
            ['department_name' => 'Unit Sumber Manusia'],
            ['department_name' => 'Unit Pentadbiran'],
            ['department_name' => 'Unit Kewangan'],
            ['department_name' => 'Unit Perolehan, Pembangunan dan Aset'],
            ['department_name' => 'Unit Keselamatan'],
            ['department_name' => 'Unit Hal Ehwal Islam'],
            ['department_name' => 'Unit Hasil dan Bilik Daftar Masuk'],
            ['department_name' => 'Unit Perhubungan Awam'],
        ]);
    }
}
