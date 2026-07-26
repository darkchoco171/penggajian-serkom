<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h2 class="mb-1">Dashboard</h2>
<p class="text-muted mb-4">Ringkasan data penggajian PT Sumber Makmur</p>

<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon bg-primary-subtle text-primary"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="stat-number"><?= $totalKaryawan ?></div>
                <div class="stat-label">Total Karyawan</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon bg-success-subtle text-success"><i class="bi bi-diagram-3-fill"></i></div>
            <div>
                <div class="stat-number"><?= $totalJabatan ?></div>
                <div class="stat-label">Total Jabatan</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon bg-warning-subtle text-warning"><i class="bi bi-calendar-check-fill"></i></div>
            <div>
                <div class="stat-number"><?= $periodeAktif ? date('M Y', mktime(0,0,0,$periodeAktif['bulan'],1,$periodeAktif['tahun'])) : '-' ?></div>
                <div class="stat-label">Periode Berjalan</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon bg-info-subtle text-info"><i class="bi bi-receipt"></i></div>
            <div>
                <div class="stat-number"><?= $jumlahSlipDiproses ?></div>
                <div class="stat-label">Slip Gaji Diproses</div>
            </div>
        </div>
    </div>
</div>

<h5 class="mb-3">Akses Cepat</h5>
<div class="row g-3">
    <div class="col-md-4">
        <a href="<?= base_url('karyawan') ?>" class="quick-link">
            <i class="bi bi-people"></i>
            <div>
                <div class="fw-semibold">Data Karyawan</div>
                <div class="text-muted small">Kelola karyawan & jabatan</div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="<?= base_url('absensi') ?>" class="quick-link">
            <i class="bi bi-calendar3"></i>
            <div>
                <div class="fw-semibold">Absensi & Potongan</div>
                <div class="text-muted small">Catat kehadiran & potongan</div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="<?= base_url('penggajian') ?>" class="quick-link">
            <i class="bi bi-cash-coin"></i>
            <div>
                <div class="fw-semibold">Proses Gaji</div>
                <div class="text-muted small">Hitung & lihat slip gaji</div>
            </div>
        </a>
    </div>
</div>

<?= $this->endSection() ?>