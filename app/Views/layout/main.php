<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistem Penggajian' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 240px;
            --sidebar-bg: #1e2938;
            --sidebar-hover: #2a3a4d;
            --accent: #3b82f6;
        }
        body { background: #f4f6f9; }

        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; bottom: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 1040;
            transition: transform 0.25s ease;
        }
        .sidebar-brand {
            padding: 1.25rem 1.25rem;
            color: #fff;
            font-weight: 600;
            font-size: 1.05rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            text-align: center;
        }
        .sidebar-nav { flex: 1; padding: 0.75rem 0.75rem; overflow-y: auto; }
        .sidebar-link {
            display: flex; align-items: center; gap: 0.65rem;
            padding: 0.6rem 0.85rem;
            border-radius: 8px;
            color: #b8c2cc;
            text-decoration: none;
            font-size: 0.92rem;
            margin-bottom: 0.15rem;
            transition: background 0.15s ease, color 0.15s ease;
        }
        .sidebar-link i { font-size: 1.05rem; width: 20px; text-align: center; }
        .sidebar-link:hover { background: var(--sidebar-hover); color: #fff; }
        .sidebar-link.active {
            background: var(--sidebar-hover);
            color: #fff;
            border-left: 3px solid var(--accent);
            padding-left: calc(0.85rem - 3px);
        }
        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-footer .user-name { color: #fff; font-size: 0.88rem; }

        .topbar {
            display: none;
            align-items: center;
            gap: 0.75rem;
            background: #fff;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e9ef;
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        .main-content { margin-left: var(--sidebar-width); padding: 1.75rem; }

        .stat-card {
            background: #fff; border-radius: 12px; padding: 1.1rem;
            display: flex; align-items: center; gap: 0.9rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            height: 100%;
        }
        .stat-icon {
            width: 44px; height: 44px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.15rem; flex-shrink: 0;
        }
        .stat-number { font-size: 1.3rem; font-weight: 700; line-height: 1.2; }
        .stat-label { font-size: 0.8rem; color: #6b7280; }

        .quick-link {
            display: flex; align-items: center; gap: 0.85rem;
            background: #fff; border-radius: 12px; padding: 1rem 1.1rem;
            text-decoration: none; color: inherit;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            transition: box-shadow 0.15s ease;
        }
        .quick-link:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .quick-link i { font-size: 1.4rem; color: var(--accent); }

        .sidebar-backdrop {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 1035;
        }

        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 1.25rem; }
            .topbar { display: flex; }
            .sidebar-backdrop.show { display: block; }
        }
    </style>
</head>
<body>

<?php
$currentPath = trim(uri_string(), '/');
$currentPath = $currentPath === '' ? 'dashboard' : explode('/', $currentPath)[0];
if (!function_exists('isActive')) {
    function isActive($path, $current) {
        return $path === $current ? 'active' : '';
    }
}
?>

<nav class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <a href="<?= base_url('dashboard') ?>" class="sidebar-brand text-decoration-none" style="color: #fff;">
            <h4 class="mb-0">SIMAJI</h4>
        </a>
    </div>
    <div class="sidebar-nav">
        <a href="<?= base_url('dashboard') ?>" class="sidebar-link <?= isActive('dashboard', $currentPath) ?>">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>
        <a href="<?= base_url('karyawan') ?>" class="sidebar-link <?= isActive('karyawan', $currentPath) ?>">
            <i class="bi bi-people-fill"></i> Karyawan
        </a>
        <a href="<?= base_url('jabatan') ?>" class="sidebar-link <?= isActive('jabatan', $currentPath) ?>">
            <i class="bi bi-diagram-3-fill"></i> Jabatan
        </a>
        <a href="<?= base_url('absensi') ?>" class="sidebar-link <?= isActive('absensi', $currentPath) ?>">
            <i class="bi bi-calendar3"></i> Absensi
        </a>
        <a href="<?= base_url('potongan') ?>" class="sidebar-link <?= isActive('potongan', $currentPath) ?>">
            <i class="bi bi-dash-circle"></i> Potongan
        </a>
        <a href="<?= base_url('penggajian') ?>" class="sidebar-link <?= isActive('penggajian', $currentPath) ?>">
            <i class="bi bi-cash-coin"></i> Proses Gaji
        </a>
        <a href="<?= base_url('slip-gaji') ?>" class="sidebar-link <?= isActive('slip-gaji', $currentPath) ?>">
            <i class="bi bi-receipt"></i> Rekap Slip Gaji
        </a>
    </div>
    <div class="sidebar-footer">
        <?php if (session()->get('isLoggedIn')): ?>
            <div class="user-name mb-2"><i class="bi bi-person-circle me-1"></i> <?= esc(session()->get('nama')) ?></div>
            <a href="<?= base_url('logout') ?>" class="btn btn-sm btn-outline-light w-100">Logout</a>
        <?php else: ?>
            <a href="<?= base_url('login') ?>" class="btn btn-sm btn-outline-light w-100">Login</a>
        <?php endif; ?>
    </div>
</nav>

<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<div class="topbar">
    <button class="btn btn-sm btn-outline-secondary" id="btnToggleSidebar">
        <i class="bi bi-list"></i>
    </button>
    <span class="fw-semibold">Sistem Penggajian</span>
</div>

<div class="main-content">
    <?= $this->renderSection('content') ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('sidebarBackdrop');
    const toggleBtn = document.getElementById('btnToggleSidebar');

    function openSidebar() {
        sidebar.classList.add('show');
        backdrop.classList.add('show');
    }
    function closeSidebar() {
        sidebar.classList.remove('show');
        backdrop.classList.remove('show');
    }

    toggleBtn?.addEventListener('click', openSidebar);
    backdrop?.addEventListener('click', closeSidebar);
</script>
</body>
</html>