<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Data Absensi</h2>
    <a href="<?= base_url('absensi/create') ?>" class="btn btn-primary">+ Input Absensi</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Nama Karyawan</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
            <th>Jam Lembur</th>
            <th width="100">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($absensi)): ?>
            <tr><td colspan="6" class="text-center">Belum ada data absensi</td></tr>
        <?php else: ?>
            <?php foreach ($absensi as $a): ?>
                <tr>
                    <td><?= esc($a['nama']) ?></td>
                    <td><?= esc($a['tanggal']) ?></td>
                    <td><?= esc($a['jam_masuk'] ?? '-') ?></td>
                    <td><?= esc($a['jam_keluar'] ?? '-') ?></td>
                    <td>
                        <?php if ($a['jam_lembur'] > 0): ?>
                            <span class="badge bg-info text-dark"><?= $a['jam_lembur'] ?> jam</span>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('absensi/delete/' . $a['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>