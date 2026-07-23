<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Jabatan extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_jabatan' => 'Office Boy', 'gaji_pokok' => 5800000, 'tunjangan_jabatan' => 200000],
            ['nama_jabatan' => 'Staff Admin', 'gaji_pokok' => 5900000, 'tunjangan_jabatan' => 300000],
            ['nama_jabatan' => 'Staff HR', 'gaji_pokok' => 6000000, 'tunjangan_jabatan' => 300000],
            ['nama_jabatan' => 'Staff Marketing', 'gaji_pokok' => 6200000, 'tunjangan_jabatan' => 350000],
            ['nama_jabatan' => 'Staff Keuangan', 'gaji_pokok' => 6500000, 'tunjangan_jabatan' => 400000],
            ['nama_jabatan' => 'Staff IT', 'gaji_pokok' => 7000000, 'tunjangan_jabatan' => 400000],
            ['nama_jabatan' => 'Sales Executive', 'gaji_pokok' => 6800000, 'tunjangan_jabatan' => 500000],
            ['nama_jabatan' => 'Supervisor', 'gaji_pokok' => 9000000, 'tunjangan_jabatan' => 800000],
            ['nama_jabatan' => 'Manager', 'gaji_pokok' => 15000000, 'tunjangan_jabatan' => 1500000],
            ['nama_jabatan' => 'Kepala Divisi', 'gaji_pokok' => 20000000, 'tunjangan_jabatan' => 2000000],
        ];
        $this->db->table('jabatan')->insertBatch($data);
    }
}
