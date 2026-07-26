<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

class DashboardTest extends CIUnitTestCase
{
    use FeatureTestTrait;
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $migrateOnce = false;
    protected $refresh = true;
    protected $namespace = 'App';

    public function testDashboardBisaDiaksesSetelahLogin()
    {
        $result = $this->withSession([
            'user_id'    => 1,
            'nama'       => 'Admin Test',
            'isLoggedIn' => true
        ])->get('/');

        $result->assertStatus(200);
        $result->assertSee('Dashboard');
        $result->assertSee('Total Karyawan');
    }
}