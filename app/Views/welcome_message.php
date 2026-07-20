<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="text-center py-5">
    <h2>Selamat Datang di Sistem Penggajian</h2>
    <p class="text-muted">Kelola data karyawan, absensi, dan proses penggajian dengan mudah.</p>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Data Karyawan</h5>
                <p class="card-text text-muted">Kelola data karyawan & jabatan</p>
                <a href="<?= base_url('karyawan') ?>" class="btn btn-primary btn-sm">Buka</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Absensi & Potongan</h5>
                <p class="card-text text-muted">Catat kehadiran dan potongan gaji</p>
                <a href="<?= base_url('absensi') ?>" class="btn btn-primary btn-sm">Buka</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Proses Gaji</h5>
                <p class="card-text text-muted">Hitung & lihat slip gaji karyawan</p>
                <a href="<?= base_url('penggajian') ?>" class="btn btn-primary btn-sm">Buka</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>