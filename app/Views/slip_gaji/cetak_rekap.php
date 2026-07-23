<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Gaji - <?= $periode['bulan']; ?>/<?= $periode['tahun']; ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #000; }
        .container { width: 800px; margin: 0 auto; }
        h3, h4 { text-align: center; margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background-color: #f0f0f0; }
        .text-right { text-align: right; }
        .btn-print { display: block; width: 100%; text-align: center; margin-top: 20px; }
        @media print {
            .btn-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>REKAPITULASI GAJI KARYAWAN</h3>
        <h4>Periode: <?= $periode['bulan']; ?> - <?= $periode['tahun']; ?></h4>

        <table>
            <thead>
                <tr>
                    <th width="3%">No</th>
                    <th width="10%">NIP</th>
                    <th width="20%">Nama</th>
                    <th width="7%">Hadir</th>
                    <th width="15%">Gaji Pokok</th>
                    <th width="15%">Tunjangan</th>
                    <th width="15%">Potongan + Pajak</th>
                    <th width="15%">Gaji Bersih</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($slip as $s) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $s['nip']; ?></td>
                    <td><?= $s['nama']; ?></td>
                    <td style="text-align: center;"><?= $s['jumlah_hari_masuk']; ?> H</td>
                    <td class="text-right">Rp <?= number_format($s['gaji_pokok'], 0, ',', '.'); ?></td>
                    <td class="text-right">Rp <?= number_format($s['total_tunjangan'], 0, ',', '.'); ?></td>
                    <td class="text-right">Rp <?= number_format($s['total_potongan'] + $s['pph21'], 0, ',', '.'); ?></td>
                    <td class="text-right"><strong>Rp <?= number_format($s['gaji_bersih'], 0, ',', '.'); ?></strong></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="btn-print">
        <button onclick="window.print()">Cetak</button>
    </div>
</body>
</html>