<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KomponenPotongan extends Seeder
{
    public function run()
    {
        $data = [
            // BPJS: 1% Kesehatan + 2% Ketenagakerjaan = 3% dari gaji pokok
            ['id_karyawan' => 1, 'jenis' => 'bpjs', 'nominal' => 174000, 'periode' => '2026-07'],   // Andi, gapok 5.800.000
            ['id_karyawan' => 2, 'jenis' => 'bpjs', 'nominal' => 195000, 'periode' => '2026-07'],   // Budi, gapok 6.500.000
            ['id_karyawan' => 3, 'jenis' => 'bpjs', 'nominal' => 174000, 'periode' => '2026-07'],   // Citra, gapok 5.800.000
            ['id_karyawan' => 3, 'jenis' => 'pinjaman', 'nominal' => 500000, 'periode' => '2026-07'], // Citra, pinjaman
            ['id_karyawan' => 4, 'jenis' => 'bpjs', 'nominal' => 270000, 'periode' => '2026-07'],   // Dian, gapok 9.000.000
            ['id_karyawan' => 5, 'jenis' => 'bpjs', 'nominal' => 450000, 'periode' => '2026-07'],   // Eko, gapok 15.000.000
        ];
        $this->db->table('komponen_potongan')->insertBatch($data);
    }
}
