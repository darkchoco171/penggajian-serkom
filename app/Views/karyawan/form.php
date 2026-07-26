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

<form method="post" action="<?= $karyawan ? base_url('karyawan/update/' . $karyawan['id']) : base_url('karyawan/store') ?>">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="nama" class="form-control" value="<?= old('nama', $karyawan['nama'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">NIP</label>
        <input type="text" name="nip" class="form-control" value="<?= old('nip', $karyawan['nip'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Jabatan</label>
        <select name="id_jabatan" class="form-select" required>
            <option value="">-- Pilih Jabatan --</option>
            <?php foreach ($daftarJabatan as $j): ?>
                <option value="<?= $j['id'] ?>" <?= (old('id_jabatan', $karyawan['id_jabatan'] ?? '') == $j['id']) ? 'selected' : '' ?>>
                    <?= esc($j['nama_jabatan']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            <option value="tetap" <?= (old('status', $karyawan['status'] ?? '') == 'tetap') ? 'selected' : '' ?>>Tetap</option>
            <option value="kontrak" <?= (old('status', $karyawan['status'] ?? '') == 'kontrak') ? 'selected' : '' ?>>Kontrak</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Tanggal Masuk</label>
        <input type="date" name="tgl_masuk" class="form-control" value="<?= old('tgl_masuk', $karyawan['tgl_masuk'] ?? '') ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('karyawan') ?>" class="btn btn-secondary">Batal</a>
</form>

<?= $this->endSection() ?>