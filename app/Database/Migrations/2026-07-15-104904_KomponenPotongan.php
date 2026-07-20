<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KomponenPotongan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'id_karyawan' => ['type' => 'INT', 'unsigned' => true],
            'jenis' => ['type' => 'ENUM', 'constraint' => ['bpjs', 'pinjaman', 'lain']],
            'nominal' => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'periode' => ['type' => 'VARCHAR', 'constraint' => 7], // format: 2026-07
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_karyawan', 'karyawan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('komponen_potongan');
    }

    public function down()
    {
        $this->forge->dropTable('komponen_potongan');
    }
}
