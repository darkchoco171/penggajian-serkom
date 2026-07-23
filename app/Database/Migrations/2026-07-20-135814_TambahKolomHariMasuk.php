<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TambahKolomHariMasuk extends Migration
{
    public function up()
    {
        $this->forge->addColumn('slip_gaji', [
            'jumlah_hari_masuk' => ['type' => 'INT', 'unsigned' => true, 'default' => 0, 'after' => 'gaji_pokok'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('slip_gaji', 'jumlah_hari_masuk');
    }
}
