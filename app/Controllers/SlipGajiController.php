<?php

namespace App\Controllers;

use App\Models\SlipGaji;
use App\Models\PeriodeGaji;
use App\Models\KomponenPotongan;

class SlipGajiController extends BaseController
{
    protected $slipGajiModel;
    protected $periodeModel;
    protected $potonganModel;

    public function __construct()
    {
        $this->slipGajiModel = new SlipGaji();
        $this->periodeModel = new PeriodeGaji();
        $this->potonganModel = new KomponenPotongan();
    }

    // Daftar periode yang bisa dilihat rekapnya
    public function index()
    {
        $data = [
            'title' => 'Rekap Slip Gaji',
            'periode' => $this->periodeModel->where('status', 'final')->findAll(),
        ];
        return view('slip_gaji/index', $data);
    }

    // Rekap semua karyawan untuk 1 periode
    public function rekap($idPeriode)
    {
        $periode = $this->periodeModel->find($idPeriode);
        if (!$periode) {
            return redirect()->to('slip-gaji')->with('error', 'Periode tidak ditemukan');
        }

        $data = [
            'title' => 'Rekap Gaji',
            'periode' => $periode,
            'slip' => $this->slipGajiModel->getRekapPerPeriode($idPeriode),
        ];
        return view('slip_gaji/rekap', $data);
    }

    // Detail slip gaji 1 karyawan, termasuk rincian potongan
    public function detail($idSlip)
    {
        $slip = $this->slipGajiModel
            ->select('slip_gaji.*, karyawan.nama, karyawan.nik, periode_gaji.bulan, periode_gaji.tahun')
            ->join('karyawan', 'karyawan.id = slip_gaji.id_karyawan')
            ->join('periode_gaji', 'periode_gaji.id = slip_gaji.id_periode')
            ->find($idSlip);

        if (!$slip) {
            return redirect()->to('slip-gaji')->with('error', 'Slip gaji tidak ditemukan');
        }

        // Ambil rincian potongan karyawan ini di periode yang sama
        $periodeFormat = sprintf('%04d-%02d', $slip['tahun'], $slip['bulan']);
        $rincianPotongan = $this->potonganModel
            ->where('id_karyawan', $slip['id_karyawan'])
            ->where('periode', $periodeFormat)
            ->findAll();

        $data = [
            'title' => 'Detail Slip Gaji',
            'slip' => $slip,
            'rincianPotongan' => $rincianPotongan,
        ];
        return view('slip_gaji/detail', $data);
    }
}