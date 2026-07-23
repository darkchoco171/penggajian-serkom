<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Absensi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'id_karyawan' => ['type' => 'INT', 'unsigned' => true],
            'tanggal'     => ['type' => 'DATE'],
            'jam_masuk'   => ['type' => 'TIME', 'null' => true],
            'jam_keluar'  => ['type' => 'TIME', 'null' => true],
            'jam_lembur'  => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0.00],
            'status'      => [
                'type'       => 'ENUM',
                'constraint' => ['hadir', 'izin', 'sakit', 'alpha', 'cuti'],
                'default'    => 'hadir',
            ],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_karyawan', 'karyawan', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('absensi');
    }

    public function down()
    {
        $this->forge->dropTable('absensi');
    }
}