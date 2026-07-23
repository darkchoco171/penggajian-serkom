<?php

namespace App\Libraries;

use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\KomponenPotongan;

/**
 * Service untuk menangani seluruh logika perhitungan gaji karyawan.
 * Dipisah dari Controller supaya bisa di-test independen dan dipakai ulang
 * tanpa duplikasi kode (mendukung skalabilitas sistem).
 *
 * Asumsi yang dipakai dalam sistem ini:
 * - Semua karyawan berstatus PTKP TK/0 (lajang, tanpa tanggungan) untuk keperluan
 *   penyederhanaan perhitungan PPh21. Sistem dapat dikembangkan lebih lanjut untuk
 *   menangani variasi status PTKP per individu.
 * - Skema kerja perusahaan: 5 hari kerja/minggu (21 hari kerja standar/bulan).
 * - PPh21 dihitung menggunakan skema TER (berlaku untuk semua masa pajak dalam
 *   sistem ini, termasuk Desember). Di dunia nyata, masa pajak Desember memerlukan
 *   penghitungan ulang tahunan dengan tarif progresif untuk rekonsiliasi akhir tahun
 *   (di luar cakupan sistem ini).
 */
class PenggajianService
{
    /**
     * Hari kerja standar sebulan untuk skema 5 hari kerja/minggu.
     * Acuan: Pasal 17 huruf b, PP Nomor 36 Tahun 2021 tentang Pengupahan.
     */
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
     * Menghitung upah lembur.
     * Jam pertama dibayar 1,5x upah sejam, jam berikutnya dibayar 2x upah sejam.
     * Upah sejam = upah sebulan / 173.
     *
     * Acuan: Pasal 13 PP Nomor 35 Tahun 2021 tentang PKWT, Alih Daya, Waktu Kerja,
     * dan Waktu Istirahat dan PHK (menggantikan Kepmenakertrans No. 102/MEN/VI/2004
     * yang telah dicabut melalui Permenaker No. 23 Tahun 2021 sebagai konsekuensi
     * UU Cipta Kerja). Rumus perhitungan tidak berubah dari ketentuan sebelumnya.
     *
     * @param float $upahBulanan Upah sebulan (gaji pokok + tunjangan tetap)
     * @param float $jamLembur Total jam lembur
     * @return float
     */
    public function hitungGajiLembur(float $upahBulanan, float $jamLembur): float
    {
        if ($jamLembur <= 0) {
            return 0;
        }

        $upahSejam = $upahBulanan / 173;

        if ($jamLembur <= 1) {
            return $upahSejam * 1.5 * $jamLembur;
        }

        $jamPertama = $upahSejam * 1.5 * 1;
        $jamBerikutnya = $upahSejam * 2 * ($jamLembur - 1);

        return $jamPertama + $jamBerikutnya;
    }

    /**
     * Menghitung PPh21 bulanan menggunakan skema Tarif Efektif Rata-rata (TER)
     * Kategori A, yang berlaku untuk status PTKP TK/0, TK/1, dan K/0.
     *
     * Acuan: PP Nomor 58 Tahun 2023 tentang Tarif Pemotongan PPh Pasal 21,
     * jo. PMK Nomor 168/PMK.03/2023 (Lampiran Kategori A).
     *
     * @param float $penghasilanBrutoBulanan Gaji pokok + tunjangan (prorata) + lembur
     * @return float PPh21 yang dipotong bulan ini
     */
    public function hitungPPh21(float $penghasilanBrutoBulanan): float
    {
        $tarif = $this->cariTarifTER($penghasilanBrutoBulanan);
        return $penghasilanBrutoBulanan * $tarif;
    }

    /**
     * Tabel TER Kategori A (PTKP TK/0, TK/1, K/0) sesuai Lampiran PP 58/2023.
     * Setiap baris merepresentasikan batas atas penghasilan bruto bulanan
     * dan tarif TER yang berlaku untuk rentang tersebut.
     *
     * @param float $bruto
     * @return float Tarif dalam desimal (misal 0.015 untuk 1,5%)
     */
    private function cariTarifTER(float $bruto): float
    {
        $tabel = [
            ['batas' => 5400000, 'tarif' => 0.0000],
            ['batas' => 5650000, 'tarif' => 0.0025],
            ['batas' => 5950000, 'tarif' => 0.0050],
            ['batas' => 6300000, 'tarif' => 0.0075],
            ['batas' => 6750000, 'tarif' => 0.0100],
            ['batas' => 7500000, 'tarif' => 0.0125],
            ['batas' => 8550000, 'tarif' => 0.0150],
            ['batas' => 9650000, 'tarif' => 0.0175],
            ['batas' => 10050000, 'tarif' => 0.0200],
            ['batas' => 10350000, 'tarif' => 0.0225],
            ['batas' => 10700000, 'tarif' => 0.0250],
            ['batas' => 11050000, 'tarif' => 0.0275],
            ['batas' => 11600000, 'tarif' => 0.0300],
            ['batas' => 12500000, 'tarif' => 0.0325],
            ['batas' => 13750000, 'tarif' => 0.0350],
            ['batas' => 15100000, 'tarif' => 0.0375],
            ['batas' => 16950000, 'tarif' => 0.0400],
            ['batas' => 19750000, 'tarif' => 0.0425],
            ['batas' => 24150000, 'tarif' => 0.0450],
            ['batas' => 26450000, 'tarif' => 0.0475],
            ['batas' => 28000000, 'tarif' => 0.0500],
            ['batas' => 30050000, 'tarif' => 0.0525],
            ['batas' => 32400000, 'tarif' => 0.0550],
            ['batas' => 35400000, 'tarif' => 0.0575],
            ['batas' => 39100000, 'tarif' => 0.0600],
            ['batas' => 43850000, 'tarif' => 0.0625],
            ['batas' => 47800000, 'tarif' => 0.0650],
            ['batas' => 51400000, 'tarif' => 0.0675],
            ['batas' => 56300000, 'tarif' => 0.0700],
            ['batas' => 62200000, 'tarif' => 0.0725],
            ['batas' => 68600000, 'tarif' => 0.0750],
            ['batas' => 77500000, 'tarif' => 0.0775],
            ['batas' => 89000000, 'tarif' => 0.0800],
            ['batas' => 103000000, 'tarif' => 0.0850],
            ['batas' => 125000000, 'tarif' => 0.0900],
            ['batas' => 157000000, 'tarif' => 0.0950],
            ['batas' => 206000000, 'tarif' => 0.1000],
            ['batas' => 337000000, 'tarif' => 0.1500],
            ['batas' => 454000000, 'tarif' => 0.2000],
            ['batas' => 550000000, 'tarif' => 0.2500],
            ['batas' => 1400000000, 'tarif' => 0.3000],
            ['batas' => PHP_INT_MAX, 'tarif' => 0.3400],
        ];

        foreach ($tabel as $lapisan) {
            if ($bruto <= $lapisan['batas']) {
                return $lapisan['tarif'];
            }
        }

        return 0.34; // fallback, seharusnya tidak pernah tercapai
    }

    /**
     * Menghitung upah pokok dan tunjangan secara PRORATA berdasarkan jumlah
     * hari masuk kerja. Karyawan yang tidak masuk penuh selama hari kerja
     * standar akan menerima upah pokok dan tunjangan yang lebih kecil,
     * proporsional dengan kehadirannya.
     *
     * @param float $gajiPokok
     * @param float $tunjangan
     * @param int $jumlahHariMasuk
     * @return array{gaji_pokok: float, tunjangan: float}
     */
    private function hitungUpahProrata(float $gajiPokok, float $tunjangan, int $jumlahHariMasuk): array
    {
        $hariMasukEfektif = min($jumlahHariMasuk, self::HARI_KERJA_STANDAR);

        $gajiPokokHarian = $gajiPokok / self::HARI_KERJA_STANDAR;
        $tunjanganHarian = $tunjangan / self::HARI_KERJA_STANDAR;

        return [
            'gaji_pokok' => $gajiPokokHarian * $hariMasukEfektif,
            'tunjangan' => $tunjanganHarian * $hariMasukEfektif,
        ];
    }

    /**
     * Menghitung rincian gaji lengkap untuk satu karyawan pada satu periode.
     *
     * Alur perhitungan:
     * 1. Ambil data karyawan beserta jabatannya (gaji pokok & tunjangan penuh)
     * 2. Hitung upah pokok & tunjangan prorata berdasarkan jumlah hari masuk
     * 3. Hitung upah lembur (berdasarkan upah PENUH, bukan prorata)
     * 4. Hitung total potongan (BPJS, pinjaman, dll dari input manual)
     * 5. Hitung gaji kotor, lalu PPh21 menggunakan TER
     * 6. Hitung gaji bersih
     *
     * @param int $idKaryawan
     * @param int $bulan
     * @param int $tahun
     * @return array{
     *     gaji_pokok: float,
     *     jumlah_hari_masuk: int,
     *     total_tunjangan: float,
     *     total_lembur: float,
     *     total_potongan: float,
     *     pph21: float,
     *     gaji_bersih: float
     * }
     */
    public function hitungGajiKaryawan(int $idKaryawan, int $bulan, int $tahun): array
    {
        // 1. Ambil data karyawan beserta jabatannya
        $karyawan = $this->karyawanModel
            ->select('karyawan.*, jabatan.gaji_pokok, jabatan.tunjangan_jabatan')
            ->join('jabatan', 'jabatan.id = karyawan.id_jabatan')
            ->find($idKaryawan);

        if (!$karyawan) {
            throw new \RuntimeException("Karyawan dengan ID {$idKaryawan} tidak ditemukan");
        }

        $gajiPokokPenuh = (float) $karyawan['gaji_pokok'];
        $tunjanganPenuh = (float) $karyawan['tunjangan_jabatan'];
        $upahBulananPenuh = $gajiPokokPenuh + $tunjanganPenuh;

        // 2. Hitung upah pokok & tunjangan prorata berdasarkan kehadiran
        $jumlahHariTidakMasuk = $this->absensiModel->getJumlahHariTidakMasuk($idKaryawan, $bulan, $tahun);
        $jumlahHariMasuk = max(0, self::HARI_KERJA_STANDAR - $jumlahHariTidakMasuk);
        $prorata = $this->hitungUpahProrata($gajiPokokPenuh, $tunjanganPenuh, $jumlahHariMasuk);

        // 3. Hitung upah lembur (berdasarkan upah penuh, sesuai PP 35/2021)
        $jamLembur = (float) $this->absensiModel->getTotalLembur($idKaryawan, $bulan, $tahun);
        $totalLembur = $this->hitungGajiLembur($upahBulananPenuh, $jamLembur);

        // 4. Hitung total potongan pada periode ini
        $periode = sprintf('%04d-%02d', $tahun, $bulan);
        $totalPotongan = (float) $this->potonganModel->getTotalPotongan($idKaryawan, $periode);

        // 5. Hitung gaji kotor, lalu PPh21 menggunakan TER
        $gajiKotor = $prorata['gaji_pokok'] + $prorata['tunjangan'] + $totalLembur;
        $pph21 = $this->hitungPPh21($gajiKotor);

        // 6. Hitung gaji bersih
        $gajiBersih = $gajiKotor - $totalPotongan - $pph21;

        return [
            'gaji_pokok' => $prorata['gaji_pokok'],
            'jumlah_hari_masuk' => $jumlahHariMasuk,
            'total_tunjangan' => $prorata['tunjangan'],
            'total_lembur' => $totalLembur,
            'total_potongan' => $totalPotongan,
            'pph21' => $pph21,
            'gaji_bersih' => $gajiBersih,
        ];
    }
}