<?php

namespace App\Libraries;

use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\KomponenPotongan;

class PenggajianService
{
    /**
     * PTKP (Penghasilan Tidak Kena Pajak) status TK/0 — lajang tanpa tanggungan.
     * Acuan: PMK Nomor 101/PMK.010/2016, masih berlaku hingga 2026.
     */
    private const PTKP_TAHUNAN = 54000000;

    protected $karyawanModel;
    protected $absensiModel;
    protected $potonganModel;

    public function __construct()
    {
        $this->karyawanModel = new Karyawan();
        $this->absensiModel = new Absensi();
        $this->potonganModel = new KomponenPotongan();
    }

    /**
     * Menghitung upah lembur sesuai Kepmenakertrans No. 102/MEN/VI/2004.
     * Jam pertama dibayar 1,5x upah sejam, jam berikutnya dibayar 2x upah sejam.
     *
     * @param float $gajiPokok Upah sebulan (dasar perhitungan upah sejam)
     * @param float $jamLembur Total jam lembur
     * @return float
     */
    public function hitungGajiLembur(float $gajiPokok, float $jamLembur): float
    {
        if ($jamLembur <= 0) {
            return 0;
        }

        // Upah sejam = 1/173 x upah sebulan (acuan resmi Kepmenakertrans 102/2004)
        $upahSejam = $gajiPokok / 173;

        if ($jamLembur <= 1) {
            return $upahSejam * 1.5 * $jamLembur;
        }

        // Jam pertama: 1.5x, jam kedua dan seterusnya: 2x
        $jamPertama = $upahSejam * 1.5 * 1;
        $jamBerikutnya = $upahSejam * 2 * ($jamLembur - 1);

        return $jamPertama + $jamBerikutnya;
    }

    /**
     * Menghitung PPh21 bulanan berdasarkan PTKP TK/0 dan tarif progresif UU HPP.
     * Disederhanakan: mengasumsikan status TK/0 untuk semua karyawan
     * (di dunia nyata status PTKP bervariasi per karyawan berdasarkan status pernikahan/tanggungan).
     *
     * Acuan: UU No. 7 Tahun 2021 (UU HPP) Pasal 17 ayat (1) huruf a.
     *
     * @param float $gajiKotorBulanan
     * @return float PPh21 yang dipotong per bulan
     */
    public function hitungPPh21(float $gajiKotorBulanan): float
    {
        $gajiKotorTahunan = $gajiKotorBulanan * 12;
        $pkpTahunan = $gajiKotorTahunan - self::PTKP_TAHUNAN;

        if ($pkpTahunan <= 0) {
            return 0;
        }

        $pajakTahunan = $this->hitungTarifProgresif($pkpTahunan);

        return $pajakTahunan / 12;
    }

    /**
     * Tarif progresif PPh21 sesuai Pasal 17 UU HPP.
     * Dihitung bertahap per lapisan, bukan flat berdasarkan total PKP.
     *
     * @param float $pkpTahunan Penghasilan Kena Pajak setahun
     * @return float
     */
    private function hitungTarifProgresif(float $pkpTahunan): float
    {
        $lapisan = [
            ['batas' => 60000000, 'tarif' => 0.05],
            ['batas' => 250000000, 'tarif' => 0.15],
            ['batas' => 500000000, 'tarif' => 0.25],
            ['batas' => 5000000000, 'tarif' => 0.30],
            ['batas' => PHP_INT_MAX, 'tarif' => 0.35],
        ];

        $pajak = 0;
        $batasBawah = 0;

        foreach ($lapisan as $l) {
            if ($pkpTahunan <= $batasBawah) {
                break;
            }

            $kenaPajakDiLapisanIni = min($pkpTahunan, $l['batas']) - $batasBawah;
            $pajak += $kenaPajakDiLapisanIni * $l['tarif'];
            $batasBawah = $l['batas'];
        }

        return $pajak;
    }

    /**
     * Menghitung rincian gaji lengkap untuk satu karyawan pada satu periode.
     *
     * @param int $idKaryawan
     * @param int $bulan
     * @param int $tahun
     * @return array
     */
    public function hitungGajiKaryawan(int $idKaryawan, int $bulan, int $tahun): array
    {
        $karyawan = $this->karyawanModel
            ->select('karyawan.*, jabatan.gaji_pokok, jabatan.tunjangan_jabatan')
            ->join('jabatan', 'jabatan.id = karyawan.id_jabatan')
            ->find($idKaryawan);

        if (!$karyawan) {
            throw new \RuntimeException("Karyawan dengan ID {$idKaryawan} tidak ditemukan");
        }

        $gajiPokok = (float) $karyawan['gaji_pokok'];
        $tunjangan = (float) $karyawan['tunjangan_jabatan'];

        $jamLembur = (float) $this->absensiModel->getTotalLembur($idKaryawan, $bulan, $tahun);
        $totalLembur = $this->hitungGajiLembur($gajiPokok + $tunjangan, $jamLembur);

        $periode = sprintf('%04d-%02d', $tahun, $bulan);
        $totalPotongan = (float) $this->potonganModel->getTotalPotongan($idKaryawan, $periode);

        $gajiKotor = $gajiPokok + $tunjangan + $totalLembur;
        $pph21 = $this->hitungPPh21($gajiKotor);

        $gajiBersih = $gajiKotor - $totalPotongan - $pph21;

        return [
            'gaji_pokok' => $gajiPokok,
            'total_tunjangan' => $tunjangan,
            'total_lembur' => $totalLembur,
            'total_potongan' => $totalPotongan,
            'pph21' => $pph21,
            'gaji_bersih' => $gajiBersih,
        ];
    }
}