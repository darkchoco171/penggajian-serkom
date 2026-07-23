<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h2>Rekap Gaji — <?= date('F Y', mktime(0, 0, 0, $periode['bulan'], 1, $periode['tahun'])) ?></h2>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Nama</th>
            <th>NIP</th>
            <th>Gaji Bersih</th>
            <th width="120">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($slip)): ?>
            <tr><td colspan="4" class="text-center">Belum ada slip gaji untuk periode ini</td></tr>
        <?php else: ?>
            <?php foreach ($slip as $s): ?>
                <tr>
                    <td><?= esc($s['nama']) ?></td>
                    <td><?= esc($s['nip']) ?></td>
                    <td><strong>Rp <?= number_format($s['gaji_bersih'], 0, ',', '.') ?></strong></td>
                    <td>
                        <a href="<?= base_url('slip-gaji/detail/' . $s['id']) ?>" class="btn btn-sm btn-info">Detail</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<a href="<?= base_url('slip-gaji') ?>" class="btn btn-secondary">Kembali</a>

<?= $this->endSection() ?>