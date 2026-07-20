<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h2>Slip Gaji</h2>
<p class="text-muted">
    <?= esc($slip['nama']) ?> (<?= esc($slip['nik']) ?>) —
    <?= date('F Y', mktime(0, 0, 0, $slip['bulan'], 1, $slip['tahun'])) ?>
</p>

<div class="card mb-3">
    <div class="card-header">Ringkasan Gaji</div>
    <div class="card-body">
        <table class="table table-sm mb-0">
            <tr><td>Gaji Pokok</td><td class="text-end">Rp <?= number_format($slip['gaji_pokok'], 0, ',', '.') ?></td></tr>
            <tr><td>Tunjangan</td><td class="text-end">Rp <?= number_format($slip['total_tunjangan'], 0, ',', '.') ?></td></tr>
            <tr><td>Lembur</td><td class="text-end">Rp <?= number_format($slip['total_lembur'], 0, ',', '.') ?></td></tr>
            <tr><td>PPh21</td><td class="text-end text-danger">− Rp <?= number_format($slip['pph21'], 0, ',', '.') ?></td></tr>
            <tr><td>Total Potongan</td><td class="text-end text-danger">− Rp <?= number_format($slip['total_potongan'], 0, ',', '.') ?></td></tr>
            <tr class="table-active">
                <td><strong>Gaji Bersih</strong></td>
                <td class="text-end"><strong>Rp <?= number_format($slip['gaji_bersih'], 0, ',', '.') ?></strong></td>
            </tr>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header">Rincian Potongan</div>
    <div class="card-body">
        <?php if (empty($rincianPotongan)): ?>
            <p class="text-muted mb-0">Tidak ada potongan tercatat pada periode ini.</p>
        <?php else: ?>
            <table class="table table-sm mb-0">
                <thead>
                    <tr>
                        <th>Jenis</th>
                        <th class="text-end">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rincianPotongan as $r): ?>
                        <tr>
                            <td><span class="badge bg-secondary"><?= esc(strtoupper($r['jenis'])) ?></span></td>
                            <td class="text-end">Rp <?= number_format($r['nominal'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<a href="<?= base_url('slip-gaji/rekap/' . $slip['id_periode']) ?>" class="btn btn-secondary mt-3">Kembali ke Rekap</a>

<?= $this->endSection() ?>