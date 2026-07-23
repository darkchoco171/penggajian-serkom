<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Data Karyawan</h2>
    <a href="<?= base_url('karyawan/create') ?>" class="btn btn-primary">+ Tambah Karyawan</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Nama</th>
            <th>NIP</th>
            <th>Jabatan</th>
            <th>Status</th>
            <th>Tgl Masuk</th>
            <th width="150">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($karyawan)): ?>
            <tr><td colspan="6" class="text-center">Belum ada data</td></tr>
        <?php else: ?>
            <?php foreach ($karyawan as $k): ?>
                <tr>
                    <td><?= esc($k['nama']) ?></td>
                    <td><?= esc($k['nip']) ?></td>
                    <td><?= esc($k['nama_jabatan']) ?></td>
                    <td>
                        <span class="badge <?= $k['status'] === 'tetap' ? 'bg-success' : 'bg-warning text-dark' ?>">
                            <?= esc($k['status']) ?>
                        </span>
                    </td>
                    <td><?= esc($k['tgl_masuk']) ?></td>
                    <td>
                        <a href="<?= base_url('karyawan/edit/' . $k['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?= base_url('karyawan/delete/' . $k['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>