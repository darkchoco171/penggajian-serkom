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

<form method="post" action="<?= (!empty($absensi) && isset($absensi['id'])) ? base_url('absensi/update/' . $absensi['id']) : base_url('absensi/store') ?>">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label class="form-label">Karyawan</label>
        <select name="id_karyawan" class="form-select" required>
            <option value="">-- Pilih Karyawan --</option>
            <?php foreach ($daftarKaryawan as $k): ?>
                <option value="<?= $k['id'] ?>" <?= old('id_karyawan', $absensi['id_karyawan'] ?? '') == $k['id'] ? 'selected' : '' ?>>
                    <?= esc($k['nama']) ?> (<?= esc($k['nip']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Tanggal</label>
        <input type="date" name="tanggal" class="form-control" value="<?= old('tanggal', $absensi['tanggal'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            <option value="hadir" <?= old('status', $absensi['status'] ?? '') == 'hadir' ? 'selected' : '' ?>>Hadir</option>
            <option value="izin" <?= old('status', $absensi['status'] ?? '') == 'izin' ? 'selected' : '' ?>>Izin</option>
            <option value="sakit" <?= old('status', $absensi['status'] ?? '') == 'sakit' ? 'selected' : '' ?>>Sakit</option>
            <option value="alpha" <?= old('status', $absensi['status'] ?? '') == 'alpha' ? 'selected' : '' ?>>Alpha (tanpa keterangan)</option>
            <option value="cuti" <?= old('status', $absensi['status'] ?? '') == 'cuti' ? 'selected' : '' ?>>Cuti</option>
        </select>
        <div class="form-text">Sistem berasumsi karyawan hadir penuh; catat di sini HANYA jika ada pengecualian (izin/sakit/alpha/cuti) atau lembur.</div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Jam Masuk</label>
            <input type="time" name="jam_masuk" class="form-control" value="<?= old('jam_masuk', $absensi['jam_masuk'] ?? '') ?>">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Jam Keluar</label>
            <input type="time" name="jam_keluar" class="form-control" value="<?= old('jam_keluar', $absensi['jam_keluar'] ?? '') ?>">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Jam Lembur (opsional)</label>
        <input type="number" step="0.5" min="0" name="jam_lembur" class="form-control" value="<?= old('jam_lembur', $absensi['jam_lembur'] ?? 0) ?>">
        <div class="form-text">Isi dalam satuan jam, contoh: 2.5 untuk 2 jam 30 menit</div>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('absensi') ?>" class="btn btn-secondary">Batal</a>
</form>

<?= $this->endSection() ?>