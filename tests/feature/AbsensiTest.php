<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

class AbsensiTest extends CIUnitTestCase
{
    use FeatureTestTrait;
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $migrateOnce = false;
    protected $refresh = true;
    protected $namespace = 'App';

    public function testAbsensiEditMengembalikanRedirectSaatDataTidakDitemukan()
    {
        $result = $this->withSession([
            'user_id'    => 1,
            'nama'       => 'Admin Test',
            'isLoggedIn' => true
        ])->get('/absensi/edit/999999');

        $result->assertRedirectTo('/absensi');
    }
}
