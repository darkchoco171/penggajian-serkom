<?php

namespace App\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\PeriodeGaji;
use App\Models\Absensi;
use App\Models\SlipGaji;

class DashboardController extends BaseController
{
    public function index()
    {
        $karyawanModel = new Karyawan();
        $jabatanModel = new Jabatan();
        $periodeModel = new PeriodeGaji();
        $slipGajiModel = new SlipGaji();

        $bulanIni = date('n');
        $tahunIni = date('Y');

        $periodeAktif = $periodeModel->where('bulan', $bulanIni)->where('tahun', $tahunIni)->first();
        $jumlahSlipDiproses = 0;
        if ($periodeAktif) {
            $jumlahSlipDiproses = $slipGajiModel->where('id_periode', $periodeAktif['id'])->countAllResults();
        }

        $data = [
            'title' => 'Dashboard',
            'totalKaryawan' => $karyawanModel->countAllResults(),
            'totalJabatan' => $jabatanModel->countAllResults(),
            'periodeAktif' => $periodeAktif,
            'jumlahSlipDiproses' => $jumlahSlipDiproses,
        ];

        return view('dashboard/index', $data);
    }
}