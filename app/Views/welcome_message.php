<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
    /* Landing page overrides: hide the app chrome (sidebar/topbar) */
    .sidebar, .sidebar-backdrop, .topbar { display: none !important; }
    .main-content { margin-left: 0 !important; padding: 3rem 1.5rem !important; }

    .welcome-hero {
        max-width: 1000px;
        margin: 2.5rem auto;
        background: linear-gradient(180deg, #ffffff, #fbfdff);
        border-radius: 12px;
        padding: 3rem 2.25rem;
        box-shadow: 0 6px 24px rgba(13,38,59,0.06);
        text-align: center;
    }
    .welcome-hero h1 { 
        font-size: 2.2rem; 
        margin-bottom: 0.5rem; 
        font-weight: bold; 
        color: #2c3e50; 
    }
    .welcome-hero p.lead { 
        color: #6b7280; 
        margin-bottom: 2rem; 
    }

    /* Styling tombol login */
    .btn-login-hero {
        font-size: 1.1rem;
        padding: 0.6rem 2.5rem;
        border-radius: 50px;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.2);
        transition: all 0.3s ease;
    }
    .btn-login-hero:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(13, 110, 253, 0.3);
    }

    .welcome-cards { 
        display: flex; 
        gap: 1.5rem; 
        justify-content: center; 
        margin-top: 3rem; 
    }
    .welcome-card { 
        flex: 1; 
        max-width: 320px; 
    }
    .welcome-card .card { 
        border: none; 
        border-radius: 12px; 
        box-shadow: 0 4px 14px rgba(11,36,56,0.04);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .welcome-card .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(11,36,56,0.1);
    }
    .card-icon {
        font-size: 2.5rem;
        color: #0d6efd;
        margin-bottom: 1rem;
    }

    @media (max-width: 767.98px) {
        .welcome-cards { flex-direction: column; align-items: center; }
        .welcome-card { width: 100%; }
    }
</style>

<div class="welcome-hero">
    <h1>Selamat Datang di SIMAJI</h1>
    <p class="lead">Sistem Informasi Manajemen Gaji — kelola karyawan, absensi, dan penggajian dengan mudah.</p>
    
    <!-- Tombol Login Utama -->
    <a href="<?= base_url('login') ?>" class="btn btn-primary btn-login-hero">
        <i class="bi bi-box-arrow-in-right me-2"></i> Login Sekarang
    </a>

    <div class="welcome-cards">
        <div class="welcome-card">
            <div class="card text-center h-100">
                <div class="card-body py-4">
                    <div class="card-icon"><i class="bi bi-people-fill"></i></div>
                    <h5 class="card-title fw-bold">Data Karyawan</h5>
                    <p class="card-text text-muted mb-4">Kelola data karyawan & jabatan</p>
                    <!-- <a href="<?= base_url('karyawan') ?>" class="btn btn-outline-primary btn-sm px-4 rounded-pill">Buka</a> -->
                </div>
            </div>
        </div>
        <div class="welcome-card">
            <div class="card text-center h-100">
                <div class="card-body py-4">
                    <div class="card-icon"><i class="bi bi-calendar2-check-fill"></i></div>
                    <h5 class="card-title fw-bold">Absensi & Potongan</h5>
                    <p class="card-text text-muted mb-4">Catat kehadiran & potongan gaji</p>
                    <!-- <a href="<?= base_url('absensi') ?>" class="btn btn-outline-primary btn-sm px-4 rounded-pill">Buka</a> -->
                </div>
            </div>
        </div>
        <div class="welcome-card">
            <div class="card text-center h-100">
                <div class="card-body py-4">
                    <div class="card-icon"><i class="bi bi-cash-stack"></i></div>
                    <h5 class="card-title fw-bold">Proses Gaji</h5>
                    <p class="card-text text-muted mb-4">Hitung & lihat slip gaji karyawan</p>
                    <!-- <a href="<?= base_url('penggajian') ?>" class="btn btn-outline-primary btn-sm px-4 rounded-pill">Buka</a> -->
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>