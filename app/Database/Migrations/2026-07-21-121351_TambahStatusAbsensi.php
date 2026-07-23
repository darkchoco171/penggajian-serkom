<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TambahStatusAbsensi extends Migration
{
    public function up()
    {
        $this->forge->addColumn('absensi', [
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['hadir', 'izin', 'sakit', 'alpha', 'cuti'],
                'default' => 'hadir',
                'after' => 'tanggal',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('absensi', 'status');
    }
}
