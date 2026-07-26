<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// SEMUA route yang sudah ada, dibungkus filter 'auth'
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');

    $routes->get('jabatan', 'JabatanController::index');
    $routes->get('jabatan/create', 'JabatanController::create');
    $routes->post('jabatan/store', 'JabatanController::store');
    $routes->get('jabatan/edit/(:num)', 'JabatanController::edit/$1');
    $routes->post('jabatan/update/(:num)', 'JabatanController::update/$1');
    $routes->get('jabatan/delete/(:num)', 'JabatanController::delete/$1');

    $routes->get('karyawan', 'KaryawanController::index');
    $routes->get('karyawan/create', 'KaryawanController::create');
    $routes->post('karyawan/store', 'KaryawanController::store');
    $routes->get('karyawan/edit/(:num)', 'KaryawanController::edit/$1');
    $routes->post('karyawan/update/(:num)', 'KaryawanController::update/$1');
    $routes->get('karyawan/delete/(:num)', 'KaryawanController::delete/$1');

    $routes->get('absensi', 'AbsensiController::index');
    $routes->get('absensi/create', 'AbsensiController::create');
    $routes->post('absensi/store', 'AbsensiController::store');
    $routes->get('absensi/edit/(:num)', 'AbsensiController::edit/$1');
    $routes->post('absensi/update/(:num)', 'AbsensiController::update/$1');
    $routes->get('absensi/delete/(:num)', 'AbsensiController::delete/$1');

    $routes->get('potongan', 'PotonganController::index');
    $routes->get('potongan/create', 'PotonganController::create');
    $routes->post('potongan/store', 'PotonganController::store');
    $routes->get('potongan/delete/(:num)', 'PotonganController::delete/$1');

    $routes->get('penggajian', 'PenggajianController::index');
    $routes->get('penggajian/proses/(:num)', 'PenggajianController::proses/$1');
    $routes->post('penggajian/jalankan/(:num)', 'PenggajianController::jalankan/$1');
    $routes->get('penggajian/tambah-periode', 'PenggajianController::createPeriode');
    $routes->post('penggajian/store-periode', 'PenggajianController::storePeriode');
    $routes->get('penggajian/edit/(:num)', 'PenggajianController::edit/$1');
    $routes->post('penggajian/update/(:num)', 'PenggajianController::update/$1');
    $routes->get('penggajian/delete/(:num)', 'PenggajianController::delete/$1');

    $routes->get('slip-gaji', 'SlipGajiController::index');
    $routes->get('slip-gaji/rekap/(:num)', 'SlipGajiController::rekap/$1');
    $routes->get('slip-gaji/detail/(:num)', 'SlipGajiController::detail/$1');
    $routes->get('slip-gaji/cetak-detail/(:num)', 'SlipGajiController::cetakDetail/$1');
    $routes->get('slip-gaji/cetak-rekap/(:num)', 'SlipGajiController::cetakRekap/$1');
});