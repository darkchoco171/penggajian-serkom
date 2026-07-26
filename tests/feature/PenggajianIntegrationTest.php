<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use App\Models\PeriodeGaji;
use App\Models\Karyawan;
use App\Models\Jabatan;

class PenggajianIntegrationTest extends CIUnitTestCase
{
    use FeatureTestTrait;
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $migrateOnce = false;
    protected $refresh = true;
    protected $namespace   = 'App';

    protected function setUp(): void
    {
        parent::setUp();
        
        // 1. Bersihkan tabel sebelum test
        $karyawanModel = new Karyawan();
        $periodeModel = new PeriodeGaji();
        $jabatanModel = new Jabatan();
        
        $karyawanModel->truncate();
        $periodeModel->truncate();
        $jabatanModel->truncate();
        
        // 2. Seed data dummy khusus untuk test integrasi ini
        $jabatanModel->insert([
            'nama_jabatan' => 'Programmer',
            'gaji_pokok' => 5000000,
            'tunjangan_jabatan' => 1000000
        ]);
        $idJabatan = $jabatanModel->getInsertID();

        $karyawanModel->insert([
            'nama' => 'Budi Test',
            'nip' => '1234567892518457',
            'id_jabatan' => $idJabatan,
            'status' => 'tetap',
            'tgl_masuk' => '2023-01-01'
        ]);

        $periodeModel->insert([
            'bulan' => 10,
            'tahun' => 2023,
            'status' => 'draft'
        ]);
    }

    public function testHalamanProsesPenggajianBisaDiakses()
    {
        // Ambil ID periode yang baru di-insert
        $periodeModel = new PeriodeGaji();
        $periode = $periodeModel->where('bulan', 10)->where('tahun', 2023)->first();

        // Simulasikan GET request ke URL proses penggajian
        $result = $this->withSession([
            'user_id'    => 1,
            'nama'       => 'Admin Test',
            'isLoggedIn' => true
        ])->get('penggajian/proses/' . $periode['id']);

        // HTTP Status 200 (OK / sukses)
        $result->assertStatus(200);
        
        // Halaman menampilkan teks ini (cek View)
        $result->assertSee('Budi Test');
    }

    public function testHalamanEditPeriodeBisaDiakses()
    {
        $periodeModel = new PeriodeGaji();
        $periode = $periodeModel->where('bulan', 10)->where('tahun', 2023)->first();

        $result = $this->withSession([
            'user_id'    => 1,
            'nama'       => 'Admin Test',
            'isLoggedIn' => true
        ])->get('penggajian/edit/' . $periode['id']);

        $result->assertStatus(200);
        $result->assertSee('Edit Periode Gaji');
    }

    public function testHalamanCetakRekapBisaDiakses()
    {
        // 1. Siapkan data slip gaji dummy untuk karyawan Budi Test
        $karyawanModel = new Karyawan();
        $periodeModel = new PeriodeGaji();
        $slipGajiModel = new \App\Models\SlipGaji();

        $karyawan = $karyawanModel->where('nama', 'Budi Test')->first();
        $periode = $periodeModel->where('bulan', 10)->where('tahun', 2023)->first();

        $slipGajiModel->insert([
            'id_karyawan' => $karyawan['id'],
            'id_periode' => $periode['id'],
            'gaji_pokok' => 5000000,
            'jumlah_hari_masuk' => 21,
            'total_tunjangan' => 1000000,
            'total_lembur' => 0,
            'total_potongan' => 0,
            'pph21' => 0,
            'gaji_bersih' => 6000000
        ]);

        // 2. Simulasikan akses ke halaman cetak rekap
        $result = $this->withSession([
            'user_id'    => 1,
            'nama'       => 'Admin Test',
            'isLoggedIn' => true
        ])->get('slip-gaji/cetak-rekap/' . $periode['id']);

        // 3. HTTP Status 200 (OK)
        $result->assertStatus(200);
        
        // 4. Halaman cetak menampilkan judul laporan dan nama karyawan
        $result->assertSee('REKAPITULASI GAJI KARYAWAN');
        $result->assertSee('Budi Test');
    }
}