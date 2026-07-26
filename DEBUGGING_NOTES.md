# Catatan Debugging

## Ringkasan log tanggal 23 Juli 2026

### Masalah utama yang muncul
- Error terkait array tidak terdefinisi: `Undefined array key "nik"` dan `Undefined array key "NIP"`.
- Error di view dan controller karena data yang dipakai tidak tersedia di array yang dikirim ke view.
- Query database gagal karena kolom `nik` tidak ditemukan: `Unknown column 'karyawan.nik' in 'field list'`.
- Beberapa test PHPUnit gagal karena tabel tidak ada, misalnya `db_jabatan` dan `db_absensi`.
- Query SQL menggunakan fungsi `MONTH` menyebabkan error karena fungsi tersebut tidak tersedia di lingkungan database yang dipakai.
- Migrasi/struktur tabel mengalami masalah: duplicate column name untuk `jumlah_hari_masuk` dan `status`.
- Kesalahan relasi foreign key saat insert data absensi: `a foreign key constraint fails`.
- Ada juga error duplikasi class saat menjalankan test: `Cannot declare class Tests\Feature\AlurPenggajianTest, because the name is already in use`.

### Area yang terdampak
- [app/Controllers/PenggajianController.php](app/Controllers/PenggajianController.php)
- [app/Views/karyawan/index.php](app/Views/karyawan/index.php)
- [app/Views/slip_gaji/rekap.php](app/Views/slip_gaji/rekap.php)
- [tests](tests)

### Kesimpulan singkat
Masalah pada log 23 Juli 2026 lebih banyak berkaitan dengan:
- struktur database / migrasi yang belum konsisten,
- data yang tidak terisi sesuai yang diharapkan,
- dan query/view yang mengakses kolom yang tidak ada.

## Ringkasan log tanggal 25 Juli 2026

### Kondisi log
- Tidak ditemukan error atau critical pada log ini.
- Log hanya berisi debug session handler normal: `Session: Class initialized using 'CodeIgniter\Session\Handlers\FileHandler' driver.`

### Kesimpulan singkat
Log 25 Juli 2026 tidak menunjukkan masalah aktif. Ini terlihat sebagai log normal dan bukan gejala error.
