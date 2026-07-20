<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PeriodeGaji extends Seeder
{
    public function run()
    {
        $data = [
            ['bulan' => 7, 'tahun' => 2026, 'status' => 'draft'],
        ];
        $this->db->table('periode_gaji')->insertBatch($data);
    }
}
