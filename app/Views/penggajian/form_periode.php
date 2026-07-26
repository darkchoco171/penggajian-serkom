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

<?php
    $action = isset($periode) ? base_url('penggajian/update/' . $periode['id']) : base_url('penggajian/store-periode');
    $selectedBulan = old('bulan', isset($periode) ? $periode['bulan'] : '');
    $selectedTahun = old('tahun', isset($periode) ? $periode['tahun'] : date('Y'));
?>

<form method="post" action="<?= $action ?>">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label class="form-label">Bulan</label>
        <select name="bulan" class="form-select" required>
            <?php
            $namaBulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            foreach ($namaBulan as $i => $nama): ?>
                <option value="<?= $i + 1 ?>" <?= $selectedBulan == ($i + 1) ? 'selected' : '' ?>><?= $nama ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Tahun</label>
        <input type="number" name="tahun" class="form-control" value="<?= esc($selectedTahun) ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('penggajian') ?>" class="btn btn-secondary">Batal</a>
</form>

<?= $this->endSection() ?>