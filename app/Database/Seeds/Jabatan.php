<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Jabatan extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_jabatan' => 'Staff Admin', 'gaji_pokok' => 5800000, 'tunjangan_jabatan' => 300000],
            ['nama_jabatan' => 'Staff Keuangan', 'gaji_pokok' => 6500000, 'tunjangan_jabatan' => 400000],
            ['nama_jabatan' => 'Supervisor', 'gaji_pokok' => 9000000, 'tunjangan_jabatan' => 800000],
            ['nama_jabatan' => 'Manager', 'gaji_pokok' => 15000000, 'tunjangan_jabatan' => 1500000],
        ];
        $this->db->table('jabatan')->insertBatch($data);
    }
}
