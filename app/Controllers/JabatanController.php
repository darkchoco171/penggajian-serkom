<?php

namespace App\Controllers;

use App\Models\Jabatan;

class JabatanController extends BaseController
{
    protected $jabatanModel;

    public function __construct()
    {
        $this->jabatanModel = new Jabatan();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Jabatan',
            'jabatan' => $this->jabatanModel->findAll(),
        ];
        return view('jabatan/index', $data);
    }

    public function create()
    {
        return view('jabatan/form', ['title' => 'Tambah Jabatan', 'jabatan' => null]);
    }

    public function store()
    {
        $rules = [
            'nama_jabatan' => 'required|min_length[3]',
            'gaji_pokok' => 'required|numeric',
            'tunjangan_jabatan' => 'permit_empty|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->jabatanModel->save([
            'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            'gaji_pokok' => $this->request->getPost('gaji_pokok'),
            'tunjangan_jabatan' => $this->request->getPost('tunjangan_jabatan') ?: 0,
        ]);

        return redirect()->to('jabatan')->with('success', 'Jabatan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jabatan = $this->jabatanModel->find($id);
        if (!$jabatan) {
            return redirect()->to('jabatan')->with('error', 'Data tidak ditemukan');
        }
        return view('jabatan/form', ['title' => 'Edit Jabatan', 'jabatan' => $jabatan]);
    }

    public function update($id)
    {
        $rules = [
            'nama_jabatan' => 'required|min_length[3]',
            'gaji_pokok' => 'required|numeric',
            'tunjangan_jabatan' => 'permit_empty|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->jabatanModel->update($id, [
            'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            'gaji_pokok' => $this->request->getPost('gaji_pokok'),
            'tunjangan_jabatan' => $this->request->getPost('tunjangan_jabatan') ?: 0,
        ]);

        return redirect()->to('jabatan')->with('success', 'Jabatan berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->jabatanModel->delete($id);
        return redirect()->to('jabatan')->with('success', 'Jabatan berhasil dihapus');
    }
}