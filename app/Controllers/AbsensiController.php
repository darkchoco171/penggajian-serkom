<?php

namespace App\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;

class AbsensiController extends BaseController
{
    protected $absensiModel;
    protected $karyawanModel;

    public function __construct()
    {
        $this->absensiModel = new Absensi();
        $this->karyawanModel = new Karyawan();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Absensi',
            'absensi' => $this->getAbsensiDenganNama(),
        ];
        return view('absensi/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Input Absensi',
            'absensi' => null,
            'daftarKaryawan' => $this->karyawanModel->findAll(),
        ];
        return view('absensi/form', $data);
    }

    public function store()
    {
        $rules = [
            'id_karyawan' => 'required|numeric',
            'tanggal' => 'required|valid_date',
            'status' => 'required|in_list[hadir,izin,sakit,alpha,cuti]',
            'jam_masuk' => 'permit_empty',
            'jam_keluar' => 'permit_empty',
            'jam_lembur' => 'permit_empty|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->absensiModel->save([
            'id_karyawan' => $this->request->getPost('id_karyawan'),
            'tanggal' => $this->request->getPost('tanggal'),
            'status' => $this->request->getPost('status'),
            'jam_masuk' => $this->request->getPost('jam_masuk') ?: null,
            'jam_keluar' => $this->request->getPost('jam_keluar') ?: null,
            'jam_lembur' => $this->request->getPost('jam_lembur') ?: 0,
        ]);

        return redirect()->to('absensi')->with('success', 'Absensi berhasil dicatat');
    }

    public function edit($id)
    {
        $absensi = $this->absensiModel->find($id);
        if (!$absensi) {
            return redirect()->to('absensi')->with('error', 'Data absensi tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Absensi',
            'absensi' => $absensi,
            'daftarKaryawan' => $this->karyawanModel->findAll(),
        ];

        return view('absensi/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'id_karyawan' => 'required|numeric',
            'tanggal' => 'required|valid_date',
            'status' => 'required|in_list[hadir,izin,sakit,alpha,cuti]',
            'jam_masuk' => 'permit_empty',
            'jam_keluar' => 'permit_empty',
            'jam_lembur' => 'permit_empty|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->absensiModel->update($id, [
            'id_karyawan' => $this->request->getPost('id_karyawan'),
            'tanggal' => $this->request->getPost('tanggal'),
            'status' => $this->request->getPost('status'),
            'jam_masuk' => $this->request->getPost('jam_masuk') ?: null,
            'jam_keluar' => $this->request->getPost('jam_keluar') ?: null,
            'jam_lembur' => $this->request->getPost('jam_lembur') ?: 0,
        ]);

        return redirect()->to('absensi')->with('success', 'Absensi berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->absensiModel->delete($id);
        return redirect()->to('absensi')->with('success', 'Data absensi berhasil dihapus');
    }

    // Join manual dengan nama karyawan, karena AbsensiModel belum ada method join khusus
    private function getAbsensiDenganNama()
    {
        return $this->absensiModel
            ->select('absensi.*, karyawan.nama')
            ->join('karyawan', 'karyawan.id = absensi.id_karyawan')
            ->orderBy('absensi.tanggal', 'DESC')
            ->findAll();
    }
}