<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Proses Penggajian</h2>
    <a href="<?= base_url('penggajian/tambah-periode') ?>" class="btn btn-primary">+ Tambah Periode</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Periode</th>
            <th>Status</th>
            <th width="300">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($periode)): ?>
            <tr><td colspan="3" class="text-center">Belum ada periode gaji</td></tr>
        <?php else: ?>
            <?php foreach ($periode as $p): ?>
                <tr>
                    <td><?= date('F Y', mktime(0, 0, 0, $p['bulan'], 1, $p['tahun'])) ?></td>
                    <td>
                        <span class="badge <?= $p['status'] === 'final' ? 'bg-success' : 'bg-secondary' ?>">
                            <?= esc($p['status']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="<?= base_url('penggajian/proses/' . $p['id']) ?>" class="btn btn-sm btn-primary">
                            <?= $p['status'] === 'final' ? 'Proses Ulang' : 'Proses' ?>
                        </a>
                        
                        <?php if ($p['status'] === 'draft'): ?>
                            <a href="<?= base_url('penggajian/edit/' . $p['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= base_url('penggajian/delete/' . $p['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus periode ini?')">Hapus</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>