<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', function() {
    return view('welcome_message');
});

// Routes.php

// TIDAK pakai filter — supaya bisa diakses sebelum login
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attempt');
$routes->get('logout', 'AuthController::logout');

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

// // Route sementara untuk test
//  $routes->get('/test-gaji', function () {
//     $service = new \App\Libraries\PenggajianService();

//     echo "<h3>Test 1: Pajak 0%</h3>";
//     echo "PPh21 untuk 4.000.000 = " . $service->hitungPPh21(4000000) . "<br>";

//     echo "<h3>Test 2: Pajak 5%</h3>";
//     echo "PPh21 untuk 8.000.000 = " . $service->hitungPPh21(8000000) . "<br>";

//     echo "<h3>Test 3: Prorata (Akses Private Method)</h3>";
//     $method = new \ReflectionMethod($service, 'hitungUpahProrata');
//     $method->setAccessible(true);
    
//     // Gaji Pokok 5.000.000, Tunjangan 1.000.000, Masuk 15 hari
//     $hasil = $method->invoke($service, 5000000, 1000000, 15);
    
//     echo "Gaji Pokok (Masuk 15 hari) = " . $hasil['gaji_pokok'] . "<br>";
//     echo "Tunjangan (Masuk 15 hari) = " . $hasil['tunjangan'] . "<br>";
// });