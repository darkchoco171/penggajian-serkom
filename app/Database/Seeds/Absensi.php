<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Absensi extends Seeder
{
    public function run()
    {
        $data = [
            ['id_karyawan' => 1, 'tanggal' => '2026-07-01', 'jam_masuk' => '08:00:00', 'jam_keluar' => '17:00:00', 'jam_lembur' => 0],
            ['id_karyawan' => 1, 'tanggal' => '2026-07-02', 'jam_masuk' => '08:00:00', 'jam_keluar' => '19:30:00', 'jam_lembur' => 2.5],
            ['id_karyawan' => 2, 'tanggal' => '2026-07-01', 'jam_masuk' => '08:15:00', 'jam_keluar' => '17:00:00', 'jam_lembur' => 0],
            ['id_karyawan' => 3, 'tanggal' => '2026-07-01', 'jam_masuk' => '08:00:00', 'jam_keluar' => '20:00:00', 'jam_lembur' => 3],
            ['id_karyawan' => 4, 'tanggal' => '2026-07-01', 'jam_masuk' => '08:00:00', 'jam_keluar' => '17:00:00', 'jam_lembur' => 0],
        ];
        $this->db->table('absensi')->insertBatch($data);
    }
}
