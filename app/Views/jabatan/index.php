<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Data Jabatan</h2>
    <a href="<?= base_url('jabatan/create') ?>" class="btn btn-primary">+ Tambah Jabatan</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Nama Jabatan</th>
            <th>Gaji Pokok</th>
            <th>Tunjangan Jabatan</th>
            <th width="150">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($jabatan)): ?>
            <tr><td colspan="4" class="text-center">Belum ada data</td></tr>
        <?php else: ?>
            <?php foreach ($jabatan as $j): ?>
                <tr>
                    <td><?= esc($j['nama_jabatan']) ?></td>
                    <td>Rp <?= number_format($j['gaji_pokok'], 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($j['tunjangan_jabatan'], 0, ',', '.') ?></td>
                    <td>
                        <a href="<?= base_url('jabatan/edit/' . $j['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?= base_url('jabatan/delete/' . $j['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>