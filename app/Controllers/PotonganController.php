<?php

namespace App\Controllers;

use App\Models\KomponenPotongan;
use App\Models\Karyawan;

class PotonganController extends BaseController
{
    protected $potonganModel;
    protected $karyawanModel;

    // Persentase resmi: BPJS Kesehatan 1% + BPJS Ketenagakerjaan (JHT) 2%
    private const PERSEN_BPJS = 0.03;

    public function __construct()
    {
        $this->potonganModel = new KomponenPotongan();
        $this->karyawanModel = new Karyawan();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Potongan',
            'potongan' => $this->getPotonganDenganNama(),
        ];
        return view('potongan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Potongan',
            'daftarKaryawan' => $this->getKaryawanDenganGajiPokok(),
        ];
        return view('potongan/form', $data);
    }

    public function store()
    {
        $jenis = $this->request->getPost('jenis');
        $idKaryawan = $this->request->getPost('id_karyawan');

        $rules = [
            'id_karyawan' => 'required|numeric',
            'jenis' => 'required|in_list[bpjs,pinjaman,lain]',
            'periode' => 'required|regex_match[/^\d{4}-\d{2}$/]',
        ];

        // Nominal cuma wajib diisi manual kalau BUKAN bpjs
        if ($jenis !== 'bpjs') {
            $rules['nominal'] = 'required|numeric|greater_than[0]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Kalau jenisnya BPJS, nominal DIHITUNG ULANG di backend
        // (tidak percaya nilai dari form, meski di JS sudah auto-terisi & disabled)
        if ($jenis === 'bpjs') {
            $karyawan = $this->karyawanModel
                ->select('karyawan.*, jabatan.gaji_pokok')
                ->join('jabatan', 'jabatan.id = karyawan.id_jabatan')
                ->find($idKaryawan);

            if (!$karyawan) {
                return redirect()->back()->withInput()->with('errors', ['id_karyawan' => 'Karyawan tidak ditemukan']);
            }

            $nominal = $karyawan['gaji_pokok'] * self::PERSEN_BPJS;
        } else {
            $nominal = $this->request->getPost('nominal');
        }

        $this->potonganModel->save([
            'id_karyawan' => $idKaryawan,
            'jenis' => $jenis,
            'nominal' => $nominal,
            'periode' => $this->request->getPost('periode'),
        ]);

        return redirect()->to('potongan')->with('success', 'Potongan berhasil ditambahkan');
    }

    public function delete($id)
    {
        $this->potonganModel->delete($id);
        return redirect()->to('potongan')->with('success', 'Potongan berhasil dihapus');
    }

    private function getPotonganDenganNama()
    {
        return $this->potonganModel
            ->select('komponen_potongan.*, karyawan.nama')
            ->join('karyawan', 'karyawan.id = komponen_potongan.id_karyawan')
            ->orderBy('komponen_potongan.periode', 'DESC')
            ->findAll();
    }

    // Ambil karyawan + gaji pokok, dibutuhkan JS untuk auto-hitung BPJS
    private function getKaryawanDenganGajiPokok()
    {
        return $this->karyawanModel
            ->select('karyawan.id, karyawan.nama, karyawan.nik, jabatan.gaji_pokok')
            ->join('jabatan', 'jabatan.id = karyawan.id_jabatan')
            ->findAll();
    }
}