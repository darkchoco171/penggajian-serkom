<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistem Penggajian' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">Sistem Penggajian</a>
            <div class="navbar-nav me-auto">
                <a class="nav-link" href="<?= base_url('karyawan') ?>">Karyawan</a>
                <a class="nav-link" href="<?= base_url('jabatan') ?>">Jabatan</a>
                <a class="nav-link" href="<?= base_url('absensi') ?>">Absensi</a>
                <a class="nav-link" href="<?= base_url('potongan') ?>">Potongan</a>
                <a class="nav-link" href="<?= base_url('penggajian') ?>">Proses Gaji</a>
                <a class="nav-link" href="<?= base_url('slip-gaji') ?>">Rekap Slip Gaji</a>
            </div>
            <div class="d-flex align-items-center">
                <?php if (session()->get('isLoggedIn')): ?>
                    <span class="navbar-text text-white me-3">Halo, <?= esc(session()->get('nama')) ?></span>
                    <a class="btn btn-outline-light btn-sm" href="<?= base_url('logout') ?>">Logout</a>
                <?php else: ?>
                    <a class="btn btn-outline-light btn-sm" href="<?= base_url('login') ?>">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container">
        <?= $this->renderSection('content') ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>