<?php

namespace App\Models;

use CodeIgniter\Model;

class SlipGaji extends Model
{
    protected $table            = 'slip_gaji';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'id_karyawan', 'id_periode', 'gaji_pokok', 'jumlah_hari_masuk', 'total_tunjangan',
        'total_lembur', 'total_potongan', 'pph21', 'gaji_bersih',
    ];

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

    // Rekap slip gaji lengkap dengan nama karyawan, dipakai di halaman Rekap
    public function getRekapPerPeriode($idPeriode)
    {
        return $this->select('slip_gaji.*, karyawan.nama, karyawan.nik')
                    ->join('karyawan', 'karyawan.id = slip_gaji.id_karyawan')
                    ->where('id_periode', $idPeriode)
                    ->findAll();
    }
}