<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SlipGaji extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'id_karyawan' => ['type' => 'INT', 'unsigned' => true],
            'id_periode' => ['type' => 'INT', 'unsigned' => true],
            'gaji_pokok' => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'total_tunjangan' => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'total_lembur' => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'total_potongan' => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'pph21' => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'gaji_bersih' => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_karyawan', 'karyawan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_periode', 'periode_gaji', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('slip_gaji');
    }

    public function down()
    {
        $this->forge->dropTable('slip_gaji');
    }
}
