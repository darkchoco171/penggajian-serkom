<?php

namespace App\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\PeriodeGaji;
use App\Models\SlipGaji;

class Home extends BaseController
{
    public function index()
    {
        $karyawanModel = new Karyawan();
        $jabatanModel = new Jabatan();
        $periodeModel = new PeriodeGaji();
        $slipGajiModel = new SlipGaji();

        $data = [
            'title' => 'Dashboard',
            'totalKaryawan' => $karyawanModel->countAll(),
            'totalJabatan' => $jabatanModel->countAll(),
            'totalPeriode' => $periodeModel->countAll(),
            'totalSlipGaji' => $slipGajiModel->countAll(),
        ];

        return view('welcome_message', $data);
    }
}