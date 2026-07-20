<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h2>Preview Proses Gaji — <?= date('F Y', mktime(0, 0, 0, $periode['bulan'], 1, $periode['tahun'])) ?></h2>

<p class="text-muted">Ini baru pratinjau perhitungan, belum tersimpan ke database. Klik "Jalankan & Simpan" di bawah untuk memprosesnya secara permanen.</p>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Nama</th>
            <th>Gaji Pokok</th>
            <th>Tunjangan</th>
            <th>Lembur</th>
            <th>Potongan</th>
            <th>PPh21</th>
            <th>Gaji Bersih</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($preview)): ?>
            <tr><td colspan="7" class="text-center">Belum ada data karyawan</td></tr>
        <?php else: ?>
            <?php foreach ($preview as $p): ?>
                <tr>
                    <td><?= esc($p['nama']) ?></td>
                    <td>Rp <?= number_format($p['gaji_pokok'], 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($p['total_tunjangan'], 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($p['total_lembur'], 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($p['total_potongan'], 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($p['pph21'], 0, ',', '.') ?></td>
                    <td><strong>Rp <?= number_format($p['gaji_bersih'], 0, ',', '.') ?></strong></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<form method="post" action="<?= base_url('penggajian/jalankan/' . $periode['id']) ?>">
    <?= csrf_field() ?>
    <button type="submit" class="btn btn-success" onclick="return confirm('Yakin proses & simpan gaji untuk semua karyawan periode ini?')">
        Jalankan & Simpan
    </button>
    <a href="<?= base_url('penggajian') ?>" class="btn btn-secondary">Batal</a>
</form>

<?= $this->endSection() ?>