<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - <?= $slip['nama']; ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #000; }
        .container { width: 600px; margin: 0 auto; border: 1px solid #000; padding: 20px; }
        h3, h4 { text-align: center; margin: 2px 0; }
        hr { border: 1px solid #000; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 4px 0; }
        .text-right { text-align: right; }
        .section-title { font-weight: bold; border-bottom: 1px solid #000; margin-bottom: 5px; padding-bottom: 2px; }
        .btn-print { display: block; width: 100%; text-align: center; margin-top: 20px; }
        @media print {
            .btn-print { display: none; }
            .container { border: none; width: 100%; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>SLIP GAJI KARYAWAN</h3>
        <h4>Periode: <?= $slip['bulan']; ?> - <?= $slip['tahun']; ?></h4>
        <hr>
        
        <table>
            <tr>
                <td width="20%">Nama</td>
                <td width="5%">:</td>
                <td width="40%"><?= $slip['nama']; ?></td>
                <td width="15%">NIP</td>
                <td width="5%">:</td>
                <td width="15%"><?= $slip['nip']; ?></td>
            </tr>
        </table>
        <hr>

        <div class="section-title">PENGHASILAN</div>
        <table>
            <tr>
                <td>Gaji Pokok (<?= $slip['jumlah_hari_masuk']; ?> Hari)</td>
                <td class="text-right">Rp <?= number_format($slip['gaji_pokok'], 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <td>Tunjangan Jabatan</td>
                <td class="text-right">Rp <?= number_format($slip['total_tunjangan'], 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <td>Uang Lembur</td>
                <td class="text-right">Rp <?= number_format($slip['total_lembur'], 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <td><strong>Total Penghasilan Kotor</strong></td>
                <td class="text-right"><strong>Rp <?= number_format($slip['gaji_pokok'] + $slip['total_tunjangan'] + $slip['total_lembur'], 2, ',', '.'); ?></strong></td>
            </tr>
        </table>

        <div class="section-title" style="margin-top:10px;">POTONGAN</div>
        <table>
            <?php foreach ($rincianPotongan as $p) : ?>
            <tr>
                <td><?= esc(strtoupper($p['jenis'])); ?></td>
                <td class="text-right">Rp <?= number_format($p['nominal'], 2, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td>PPh21</td>
                <td class="text-right">Rp <?= number_format($slip['pph21'], 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <td><strong>Total Potongan</strong></td>
                <td class="text-right"><strong>Rp <?= number_format($slip['total_potongan'] + $slip['pph21'], 2, ',', '.'); ?></strong></td>
            </tr>
        </table>

        <hr>
        <table>
            <tr>
                <td><strong>GAJI BERSIH DITERIMA</strong></td>
                <td class="text-right"><strong>Rp <?= number_format($slip['gaji_bersih'], 2, ',', '.'); ?></strong></td>
            </tr>
        </table>
        
        <p style="text-align:center; margin-top:30px; font-size: 11px;">
            Slip ini dicetak secara otomatis oleh sistem. <br>
            Bandung, <?= date('d-m-Y'); ?>
        </p>
    </div>

    <div class="btn-print">
        <button onclick="window.print()">Cetak</button>
    </div>
</body>
</html>