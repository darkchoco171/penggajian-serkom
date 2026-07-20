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

<form method="post" action="<?= base_url('potongan/store') ?>" id="formPotongan">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label class="form-label">Karyawan</label>
        <select name="id_karyawan" id="idKaryawan" class="form-select" required>
            <option value="">-- Pilih Karyawan --</option>
            <?php foreach ($daftarKaryawan as $k): ?>
                <option value="<?= $k['id'] ?>" data-gaji-pokok="<?= $k['gaji_pokok'] ?>">
                    <?= esc($k['nama']) ?> (<?= esc($k['nik']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Jenis Potongan</label>
        <select name="jenis" id="jenisPotongan" class="form-select" required>
            <option value="">-- Pilih Jenis --</option>
            <option value="bpjs">BPJS (Kesehatan + Ketenagakerjaan)</option>
            <option value="pinjaman">Pinjaman</option>
            <option value="lain">Lain-lain</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Nominal</label>
        <input type="number" name="nominal" id="nominalPotongan" class="form-control">
        <div class="form-text" id="helperNominal">
            Untuk BPJS, nominal otomatis dihitung 3% dari gaji pokok (1% Kesehatan + 2% Ketenagakerjaan).
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Periode</label>
        <input type="month" name="periode" class="form-control" value="<?= old('periode') ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('potongan') ?>" class="btn btn-secondary">Batal</a>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectKaryawan = document.getElementById('idKaryawan');
    const selectJenis = document.getElementById('jenisPotongan');
    const inputNominal = document.getElementById('nominalPotongan');
    const helperText = document.getElementById('helperNominal');

    const PERSEN_BPJS = 0.03; // 1% Kesehatan + 2% Ketenagakerjaan

    function hitungOtomatis() {
        const isBpjs = selectJenis.value === 'bpjs';
        const opsiTerpilih = selectKaryawan.options[selectKaryawan.selectedIndex];
        const gajiPokok = opsiTerpilih ? parseFloat(opsiTerpilih.dataset.gajiPokok || 0) : 0;

        if (isBpjs && gajiPokok > 0) {
            const nominalOtomatis = Math.round(gajiPokok * PERSEN_BPJS);
            inputNominal.value = nominalOtomatis;
            inputNominal.setAttribute('readonly', true);
            inputNominal.classList.add('bg-light');
            helperText.textContent = `Otomatis: 3% x Rp${gajiPokok.toLocaleString('id-ID')} = Rp${nominalOtomatis.toLocaleString('id-ID')}`;
        } else if (isBpjs) {
            inputNominal.value = '';
            inputNominal.setAttribute('readonly', true);
            helperText.textContent = 'Pilih karyawan terlebih dahulu untuk menghitung otomatis.';
        } else {
            inputNominal.value = '';
            inputNominal.removeAttribute('readonly');
            inputNominal.classList.remove('bg-light');
            helperText.textContent = 'Masukkan nominal potongan secara manual.';
        }
    }

    selectKaryawan.addEventListener('change', hitungOtomatis);
    selectJenis.addEventListener('change', hitungOtomatis);
});
</script>

<?= $this->endSection() ?>