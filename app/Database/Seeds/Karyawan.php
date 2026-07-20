<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Karyawan extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'Andi Wijaya', 'nik' => '3201001', 'id_jabatan' => 1, 'status' => 'tetap', 'tgl_masuk' => '2022-01-10'],
            ['nama' => 'Budi Santoso', 'nik' => '3201002', 'id_jabatan' => 2, 'status' => 'tetap', 'tgl_masuk' => '2021-05-15'],
            ['nama' => 'Citra Dewi', 'nik' => '3201003', 'id_jabatan' => 1, 'status' => 'kontrak', 'tgl_masuk' => '2025-03-01'],
            ['nama' => 'Dian Permata', 'nik' => '3201004', 'id_jabatan' => 3, 'status' => 'tetap', 'tgl_masuk' => '2020-08-20'],
            ['nama' => 'Eko Prasetyo', 'nik' => '3201005', 'id_jabatan' => 4, 'status' => 'tetap', 'tgl_masuk' => '2019-11-05'],
        ];
        $this->db->table('karyawan')->insertBatch($data);
    }
}
