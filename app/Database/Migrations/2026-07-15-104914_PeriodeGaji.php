<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PeriodeGaji extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'bulan' => ['type' => 'TINYINT', 'unsigned' => true],
            'tahun' => ['type' => 'SMALLINT', 'unsigned' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['draft', 'final'], 'default' => 'draft'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('periode_gaji');
    }

    public function down()
    {
        $this->forge->dropTable('periode_gaji');
    }
}
