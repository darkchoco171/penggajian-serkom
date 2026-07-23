<?php

namespace App\Libraries;

use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\KomponenPotongan;

class PenggajianService
{
    // Asumsi standar: 1 bulan ada 21 hari kerja (Senin-Jumat)
    private const HARI_KERJA_STANDAR = 21;

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
     * Hitung upah lembur.
     * Rumus: (Gaji bulanan / 173 jam) × 2 × jam lembur
     * 173 = standar jam kerja normal sebulan.
     */
    public function hitungGajiLembur(float $gajiBulanan, float $jamLembur): float
    {
        if ($jamLembur <= 0) {
            return 0;
        }
        $upahPerJam = $gajiBulanan / 173;
        return $upahPerJam * 2 * $jamLembur;
    }

    /**
     * Hitung PPh21 (Pajak Penghasilan).
     * Sederhana:
     * - Gaji kotor ≤ 5.000.000 → Tidak kena pajak (0%)
     * - Gaji kotor > 5.000.000 → 5% dari selisih gaji - 5.000.000
     */
    public function hitungPPh21(float $gajiKotor): float
    {
        if ($gajiKotor <= 5000000) {
            return 0;
        }
        $kenaPajak = $gajiKotor - 5000000;
        return $kenaPajak * 0.05;
    }

    /**
     * Hitung gaji pokok & tunjangan secara prorata berdasarkan hari masuk.
     * Rumus: (Gaji bulanan / 21) × hari masuk
     */
    private function hitungUpahProrata(float $gajiPokok, float $tunjangan, int $hariMasuk): array
    {
        // Batasi maksimal 21 hari (jika masuk lebih, tetap dihitung 21)
        $hariEfektif = min($hariMasuk, self::HARI_KERJA_STANDAR);

        $gajiPokokHarian = $gajiPokok / self::HARI_KERJA_STANDAR;
        $tunjanganHarian = $tunjangan / self::HARI_KERJA_STANDAR;

        return [
            'gaji_pokok' => $gajiPokokHarian * $hariEfektif,
            'tunjangan'  => $tunjanganHarian * $hariEfektif,
        ];
    }

    /**
     * Hitung gaji lengkap untuk 1 karyawan pada 1 periode.
     */
    public function hitungGajiKaryawan(int $idKaryawan, int $bulan, int $tahun): array
    {
        // 1. Ambil data karyawan + jabatan
        $karyawan = $this->karyawanModel
            ->select('karyawan.*, jabatan.gaji_pokok, jabatan.tunjangan_jabatan')
            ->join('jabatan', 'jabatan.id = karyawan.id_jabatan')
            ->find($idKaryawan);

        if (!$karyawan) {
            throw new \RuntimeException("Karyawan ID {$idKaryawan} tidak ditemukan");
        }

        $gajiPokokPenuh = (float) $karyawan['gaji_pokok'];
        $tunjanganPenuh = (float) $karyawan['tunjangan_jabatan'];
        $upahBulananPenuh = $gajiPokokPenuh + $tunjanganPenuh;

        // 2. Hitung hari masuk (21 standar - hari tidak masuk)
        $hariTidakMasuk = $this->absensiModel->getJumlahHariTidakMasuk($idKaryawan, $bulan, $tahun);
        $hariMasuk = max(0, self::HARI_KERJA_STANDAR - $hariTidakMasuk);

        // 3. Hitung prorata gaji pokok & tunjangan
        $prorata = $this->hitungUpahProrata($gajiPokokPenuh, $tunjanganPenuh, $hariMasuk);

        // 4. Hitung lembur (berdasarkan upah penuh, bukan prorata)
        $jamLembur = (float) $this->absensiModel->getTotalLembur($idKaryawan, $bulan, $tahun);
        $totalLembur = $this->hitungGajiLembur($upahBulananPenuh, $jamLembur);

        // 5. Hitung total potongan (BPJS, pinjaman, dll)
        $periode = sprintf('%04d-%02d', $tahun, $bulan);
        $totalPotongan = (float) $this->potonganModel->getTotalPotongan($idKaryawan, $periode);

        // 6. Hitung gaji kotor & PPh21
        $gajiKotor = $prorata['gaji_pokok'] + $prorata['tunjangan'] + $totalLembur;
        $pph21 = $this->hitungPPh21($gajiKotor);

        // 7. Hitung gaji bersih
        $gajiBersih = $gajiKotor - $totalPotongan - $pph21;

        return [
            'gaji_pokok'       => $prorata['gaji_pokok'],
            'jumlah_hari_masuk' => $hariMasuk,
            'total_tunjangan'  => $prorata['tunjangan'],
            'total_lembur'     => $totalLembur,
            'total_potongan'   => $totalPotongan,
            'pph21'            => $pph21,
            'gaji_bersih'      => $gajiBersih,
        ];
    }
}