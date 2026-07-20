<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Data Potongan</h2>
    <a href="<?= base_url('potongan/create') ?>" class="btn btn-primary">+ Tambah Potongan</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Nama Karyawan</th>
            <th>Jenis</th>
            <th>Nominal</th>
            <th>Periode</th>
            <th width="100">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($potongan)): ?>
            <tr><td colspan="5" class="text-center">Belum ada data potongan</td></tr>
        <?php else: ?>
            <?php foreach ($potongan as $p): ?>
                <tr>
                    <td><?= esc($p['nama']) ?></td>
                    <td>
                        <span class="badge bg-secondary"><?= esc(strtoupper($p['jenis'])) ?></span>
                    </td>
                    <td>Rp <?= number_format($p['nominal'], 0, ',', '.') ?></td>
                    <td><?= esc($p['periode']) ?></td>
                    <td>
                        <a href="<?= base_url('potongan/delete/' . $p['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>