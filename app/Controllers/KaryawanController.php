<?php

namespace App\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;

class KaryawanController extends BaseController
{
    protected $karyawanModel;
    protected $jabatanModel;

    public function __construct()
    {
        $this->karyawanModel = new Karyawan();
        $this->jabatanModel = new Jabatan();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Karyawan',
            'karyawan' => $this->karyawanModel->getKaryawanDenganJabatan(),
        ];
        return view('karyawan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Karyawan',
            'karyawan' => null,
            'daftarJabatan' => $this->jabatanModel->findAll(),
        ];
        return view('karyawan/form', $data);
    }

    public function store()
    {
        $rules = [
            'nama' => 'required|min_length[3]',
            'nik' => 'required|exact_length[16]|numeric|is_unique[karyawan.nik]',
            'id_jabatan' => 'required|numeric',
            'status' => 'required|in_list[tetap,kontrak]',
            'tgl_masuk' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->karyawanModel->save([
            'nama' => $this->request->getPost('nama'),
            'nik' => $this->request->getPost('nik'),
            'id_jabatan' => $this->request->getPost('id_jabatan'),
            'status' => $this->request->getPost('status'),
            'tgl_masuk' => $this->request->getPost('tgl_masuk'),
        ]);

        return redirect()->to('karyawan')->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $karyawan = $this->karyawanModel->find($id);
        if (!$karyawan) {
            return redirect()->to('karyawan')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Karyawan',
            'karyawan' => $karyawan,
            'daftarJabatan' => $this->jabatanModel->findAll(),
        ];
        return view('karyawan/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'nama' => 'required|min_length[3]',
            'nik' => 'required|exact_length[16]|numeric|is_unique[karyawan.nik]',
            'id_jabatan' => 'required|numeric',
            'status' => 'required|in_list[tetap,kontrak]',
            'tgl_masuk' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->karyawanModel->update($id, [
            'nama' => $this->request->getPost('nama'),
            'nik' => $this->request->getPost('nik'),
            'id_jabatan' => $this->request->getPost('id_jabatan'),
            'status' => $this->request->getPost('status'),
            'tgl_masuk' => $this->request->getPost('tgl_masuk'),
        ]);

        return redirect()->to('karyawan')->with('success', 'Karyawan berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->karyawanModel->delete($id);
        return redirect()->to('karyawan')->with('success', 'Karyawan berhasil dihapus');
    }
}