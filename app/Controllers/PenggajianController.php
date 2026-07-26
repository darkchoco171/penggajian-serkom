<?php

namespace App\Controllers;

use App\Models\PeriodeGaji;
use App\Models\Karyawan;
use App\Models\SlipGaji;
use App\Libraries\PenggajianService;

class PenggajianController extends BaseController
{
    protected $periodeModel;
    protected $karyawanModel;
    protected $slipGajiModel;
    protected $penggajianService;

    public function __construct()
    {
        $this->periodeModel = new PeriodeGaji();
        $this->karyawanModel = new Karyawan();
        $this->slipGajiModel = new SlipGaji();
        $this->penggajianService = new PenggajianService();
    }

    // Menampilkan daftar periode gaji yang bisa diproses
    public function index()
    {
        $data = [
            'title' => 'Proses Penggajian',
            'periode' => $this->periodeModel->findAll(),
        ];
        return view('penggajian/index', $data);
    }

    public function createPeriode()
    {
        return view('penggajian/form_periode', ['title' => 'Tambah Periode Gaji']);
    }

    public function storePeriode()
    {
        $rules = [
            'bulan' => 'required|numeric|greater_than[0]|less_than_equal_to[12]',
            'tahun' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        // Cek duplikat: jangan sampai ada 2 periode yang sama
        $sudahAda = $this->periodeModel->where('bulan', $bulan)->where('tahun', $tahun)->first();
        if ($sudahAda) {
            return redirect()->back()->withInput()->with('errors', ['bulan' => 'Periode ini sudah ada']);
        }

        $this->periodeModel->save([
            'bulan' => $bulan,
            'tahun' => $tahun,
            'status' => 'draft',
        ]);

        return redirect()->to('penggajian')->with('success', 'Periode gaji berhasil ditambahkan');
    }

    public function edit($idPeriode)
    {
        $periode = $this->periodeModel->find($idPeriode);
        if (!$periode) {
            return redirect()->to('penggajian')->with('error', 'Periode tidak ditemukan');
        }

        return view('penggajian/form_periode', [
            'title' => 'Edit Periode Gaji',
            'periode' => $periode,
        ]);
    }

    public function update($idPeriode)
    {
        $periode = $this->periodeModel->find($idPeriode);
        if (!$periode) {
            return redirect()->to('penggajian')->with('error', 'Periode tidak ditemukan');
        }

        $rules = [
            'bulan' => 'required|numeric|greater_than[0]|less_than_equal_to[12]',
            'tahun' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        $sudahAda = $this->periodeModel
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->where('id !=', $idPeriode)
            ->first();

        if ($sudahAda) {
            return redirect()->back()->withInput()->with('errors', ['bulan' => 'Periode ini sudah ada']);
        }

        $this->periodeModel->update($idPeriode, [
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);

        return redirect()->to('penggajian')->with('success', 'Periode gaji berhasil diperbarui');
    }

    // Menampilkan preview perhitungan gaji semua karyawan untuk 1 periode (belum disimpan)
    public function proses($idPeriode)
    {
        $periode = $this->periodeModel->find($idPeriode);
        if (!$periode) {
            return redirect()->to('penggajian')->with('error', 'Periode tidak ditemukan');
        }

        $semuaKaryawan = $this->karyawanModel->findAll();
        $preview = [];

        foreach ($semuaKaryawan as $k) {
            $hasil = $this->penggajianService->hitungGajiKaryawan(
                $k['id'],
                $periode['bulan'],
                $periode['tahun']
            );
            $preview[] = array_merge(['nama' => $k['nama'], 'nip' => $k['nip']], $hasil);
        }

        $data = [
            'title' => 'Preview Proses Gaji',
            'periode' => $periode,
            'preview' => $preview,
        ];
        // dd($preview);
        return view('penggajian/proses', $data);
    }

    // Menjalankan proses: hitung ulang & simpan permanen ke tabel slip_gaji
    public function jalankan($idPeriode)
    {
        $periode = $this->periodeModel->find($idPeriode);
        if (!$periode) {
            return redirect()->to('penggajian')->with('error', 'Periode tidak ditemukan');
        }

        // Hapus slip gaji lama untuk periode ini (kalau pernah diproses sebelumnya)
        // supaya tidak dobel kalau tombol "Proses" diklik lagi
        $this->slipGajiModel->where('id_periode', $idPeriode)->delete();

        $semuaKaryawan = $this->karyawanModel->findAll();

        foreach ($semuaKaryawan as $k) {
            $hasil = $this->penggajianService->hitungGajiKaryawan(
                $k['id'],
                $periode['bulan'],
                $periode['tahun']
            );

            $this->slipGajiModel->save([
                'id_karyawan' => $k['id'],
                'id_periode' => $idPeriode,
                'gaji_pokok' => $hasil['gaji_pokok'],
                'jumlah_hari_masuk' => $hasil['jumlah_hari_masuk'],
                'total_tunjangan' => $hasil['total_tunjangan'],
                'total_lembur' => $hasil['total_lembur'],
                'total_potongan' => $hasil['total_potongan'],
                'pph21' => $hasil['pph21'],
                'gaji_bersih' => $hasil['gaji_bersih'],
            ]);
        }

        // Update status periode jadi final
        $this->periodeModel->update($idPeriode, ['status' => 'final']);

        return redirect()->to('slip-gaji/rekap/' . $idPeriode)
            ->with('success', 'Gaji berhasil diproses untuk semua karyawan');
    }

    public function delete($idPeriode)
    {
        // Hapus slip gaji yang berhubungan dengan periode ini dulu (agar tidak error Foreign Key)
        $this->slipGajiModel->where('id_periode', $idPeriode)->delete();
        // Lalu hapus periode-nya
        $this->periodeModel->delete($idPeriode);
        
        return redirect()->to('penggajian')->with('success', 'Periode gaji berhasil dihapus beserta slip terkait');
    }
}