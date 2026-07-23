<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Absensi extends Seeder
{
    public function run()
    {
        $data = [
            // Pengecualian ketidakhadiran
            ['id_karyawan' => 3, 'tanggal' => '2026-07-08', 'status' => 'izin', 'jam_masuk' => null, 'jam_keluar' => null, 'jam_lembur' => 0],
            ['id_karyawan' => 6, 'tanggal' => '2026-07-10', 'status' => 'sakit', 'jam_masuk' => null, 'jam_keluar' => null, 'jam_lembur' => 0],
            ['id_karyawan' => 6, 'tanggal' => '2026-07-11', 'status' => 'sakit', 'jam_masuk' => null, 'jam_keluar' => null, 'jam_lembur' => 0],
            ['id_karyawan' => 11, 'tanggal' => '2026-07-14', 'status' => 'cuti', 'jam_masuk' => null, 'jam_keluar' => null, 'jam_lembur' => 0],
            ['id_karyawan' => 18, 'tanggal' => '2026-07-05', 'status' => 'alpha', 'jam_masuk' => null, 'jam_keluar' => null, 'jam_lembur' => 0],

            // Pengecualian lembur (status tetap hadir)
            ['id_karyawan' => 1, 'tanggal' => '2026-07-15', 'status' => 'hadir', 'jam_masuk' => '08:00:00', 'jam_keluar' => '19:30:00', 'jam_lembur' => 2.5],
            ['id_karyawan' => 7, 'tanggal' => '2026-07-16', 'status' => 'hadir', 'jam_masuk' => '08:00:00', 'jam_keluar' => '20:00:00', 'jam_lembur' => 3],
            ['id_karyawan' => 16, 'tanggal' => '2026-07-17', 'status' => 'hadir', 'jam_masuk' => '08:00:00', 'jam_keluar' => '18:30:00', 'jam_lembur' => 1],
        ];
        $this->db->table('absensi')->insertBatch($data);
    }
}
