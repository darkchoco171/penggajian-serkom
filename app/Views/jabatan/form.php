<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h2><?= $title ?></h2>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="<?= $jabatan ? base_url('jabatan/update/' . $jabatan['id']) : base_url('jabatan/store') ?>">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label class="form-label">Nama Jabatan</label>
        <input type="text" name="nama_jabatan" class="form-control" value="<?= old('nama_jabatan', $jabatan['nama_jabatan'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Gaji Pokok</label>
        <input type="number" name="gaji_pokok" class="form-control" value="<?= old('gaji_pokok', $jabatan['gaji_pokok'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Tunjangan Jabatan</label>
        <input type="number" name="tunjangan_jabatan" class="form-control" value="<?= old('tunjangan_jabatan', $jabatan['tunjangan_jabatan'] ?? 0) ?>">
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('jabatan') ?>" class="btn btn-secondary">Batal</a>
</form>

<?= $this->endSection() ?>