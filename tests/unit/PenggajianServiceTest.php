<?php

namespace Tests\Unit;

use App\Libraries\PenggajianService;
use CodeIgniter\Test\CIUnitTestCase;

class PenggajianServiceTest extends CIUnitTestCase
{
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PenggajianService();
    }

    public function testHitungPPh21Dibawah5Juta()
    {
        // Gaji 4.000.000 harusnya pajak 0
        $this->assertEquals(0, $this->service->hitungPPh21(4000000));
    }

    public function testHitungPPh21Diatas5Juta()
    {
        // Gaji 8.000.000 -> (8.000.000 - 5.000.000) * 5% = 150.000
        $this->assertEquals(150000, $this->service->hitungPPh21(8000000));
    }

    public function testHitungUpahProrata()
    {
        // untuk mengakses method private hitungUpahProrata
        $method = new \ReflectionMethod($this->service, 'hitungUpahProrata');
        $method->setAccessible(true);

        $gajiPokok = 5000000;
        $tunjangan = 1000000;
        $hariMasuk = 15;

        $hasil = $method->invoke($this->service, $gajiPokok, $tunjangan, $hariMasuk);

        // Rumus: (5.000.000 / 21) * 15 = 3.571.428,57...
        // (1.000.000 / 21) * 15 = 714.285,71...
        $this->assertEqualsWithDelta(3571428.57, $hasil['gaji_pokok'], 0.01);
        $this->assertEqualsWithDelta(714285.71, $hasil['tunjangan'], 0.01);
    }
}