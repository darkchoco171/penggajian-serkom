<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Karyawan extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'Andi Wijaya', 'nik' => '3171011501900001', 'id_jabatan' => 2, 'status' => 'tetap', 'tgl_masuk' => '2022-01-10'],
            ['nama' => 'Budi Santoso', 'nik' => '3171020203880002', 'id_jabatan' => 5, 'status' => 'tetap', 'tgl_masuk' => '2021-05-15'],
            ['nama' => 'Citra Dewi', 'nik' => '3171016407950003', 'id_jabatan' => 2, 'status' => 'kontrak', 'tgl_masuk' => '2025-03-01'],
            ['nama' => 'Dian Permata', 'nik' => '3171025809850004', 'id_jabatan' => 8, 'status' => 'tetap', 'tgl_masuk' => '2020-08-20'],
            ['nama' => 'Eko Prasetyo', 'nik' => '3171031012820005', 'id_jabatan' => 9, 'status' => 'tetap', 'tgl_masuk' => '2019-11-05'],
            ['nama' => 'Fitri Ramadhani', 'nik' => '3171046309920006', 'id_jabatan' => 3, 'status' => 'tetap', 'tgl_masuk' => '2022-06-12'],
            ['nama' => 'Gilang Ramadhan', 'nik' => '3171051107910007', 'id_jabatan' => 6, 'status' => 'tetap', 'tgl_masuk' => '2021-09-01'],
            ['nama' => 'Hana Salsabila', 'nik' => '3171062204960008', 'id_jabatan' => 4, 'status' => 'kontrak', 'tgl_masuk' => '2024-02-15'],
            ['nama' => 'Indra Kusuma', 'nik' => '3171071809890009', 'id_jabatan' => 7, 'status' => 'tetap', 'tgl_masuk' => '2023-01-20'],
            ['nama' => 'Joko Susilo', 'nik' => '3171081003870010', 'id_jabatan' => 1, 'status' => 'tetap', 'tgl_masuk' => '2020-03-10'],
            ['nama' => 'Kartika Sari', 'nik' => '3171092705970011', 'id_jabatan' => 3, 'status' => 'kontrak', 'tgl_masuk' => '2024-07-01'],
            ['nama' => 'Lukman Hakim', 'nik' => '3171101409860012', 'id_jabatan' => 6, 'status' => 'tetap', 'tgl_masuk' => '2022-10-05'],
            ['nama' => 'Maya Anggraini', 'nik' => '3171114206930013', 'id_jabatan' => 5, 'status' => 'tetap', 'tgl_masuk' => '2021-04-18'],
            ['nama' => 'Nanda Pratama', 'nik' => '3171120801940014', 'id_jabatan' => 7, 'status' => 'kontrak', 'tgl_masuk' => '2025-01-08'],
            ['nama' => 'Olivia Putri', 'nik' => '3171132205980015', 'id_jabatan' => 2, 'status' => 'tetap', 'tgl_masuk' => '2023-05-22'],
            ['nama' => 'Panji Setiawan', 'nik' => '3171141012840016', 'id_jabatan' => 9, 'status' => 'tetap', 'tgl_masuk' => '2018-12-01'],
            ['nama' => 'Qori Amelia', 'nik' => '3171154408910017', 'id_jabatan' => 4, 'status' => 'tetap', 'tgl_masuk' => '2022-08-14'],
            ['nama' => 'Rendra Wijaya', 'nik' => '3171160111990018', 'id_jabatan' => 1, 'status' => 'kontrak', 'tgl_masuk' => '2024-11-01'],
            ['nama' => 'Siti Nurhaliza', 'nik' => '3171175702870019', 'id_jabatan' => 8, 'status' => 'tetap', 'tgl_masuk' => '2020-02-17'],
            ['nama' => 'Taufik Hidayat', 'nik' => '3171182506830020', 'id_jabatan' => 10, 'status' => 'tetap', 'tgl_masuk' => '2017-06-25'],
        ];
        $this->db->table('karyawan')->insertBatch($data);
    }
}
