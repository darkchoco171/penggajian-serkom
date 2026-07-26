<?php

namespace App\Models;

use CodeIgniter\Model;

class Absensi extends Model
{
    protected $table            = 'absensi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_karyawan', 'tanggal', 'jam_masuk', 'jam_keluar', 'jam_lembur', 'status'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Total lembur per karyawan dalam satu bulan, dipakai saat proses hitung gaji
    public function getTotalLembur($idKaryawan, $bulan, $tahun)
    {
        $tanggalAwal  = sprintf('%04d-%02d-01', $tahun, $bulan);
        $tanggalAkhir = date('Y-m-t', strtotime($tanggalAwal));

        return $this->selectSum('jam_lembur')
                    ->where('id_karyawan', $idKaryawan)
                    ->where('status', 'hadir')
                    ->where('tanggal >=', $tanggalAwal)
                    ->where('tanggal <=', $tanggalAkhir)
                    ->first()['jam_lembur'] ?? 0;
    }

    public function getJumlahHariTidakMasuk($idKaryawan, $bulan, $tahun)
    {
        $tanggalAwal  = sprintf('%04d-%02d-01', $tahun, $bulan);
        $tanggalAkhir = date('Y-m-t', strtotime($tanggalAwal));

        return $this->where('id_karyawan', $idKaryawan)
                    ->where('tanggal >=', $tanggalAwal)
                    ->where('tanggal <=', $tanggalAkhir)
                    ->whereIn('status', ['izin', 'sakit', 'alpha', 'cuti'])
                    ->countAllResults();
    }
}