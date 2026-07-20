<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h2>Rekap Slip Gaji</h2>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Periode</th>
            <th width="150">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($periode)): ?>
            <tr><td colspan="2" class="text-center">Belum ada periode yang sudah diproses (final)</td></tr>
        <?php else: ?>
            <?php foreach ($periode as $p): ?>
                <tr>
                    <td><?= date('F Y', mktime(0, 0, 0, $p['bulan'], 1, $p['tahun'])) ?></td>
                    <td>
                        <a href="<?= base_url('slip-gaji/rekap/' . $p['id']) ?>" class="btn btn-sm btn-primary">Lihat Rekap</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>