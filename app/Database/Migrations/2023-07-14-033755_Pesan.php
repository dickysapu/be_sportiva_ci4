<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pesan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=> 'INT',
                'constraint'=> 5,
                'auto_increment'=> true
            ],
            'name'=>[
                'type'=> 'varchar',
                'constraint'=> 200,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'noTelp' => [
                'type' => 'VARCHAR',
                'constraint' => 12, // Sesuaikan panjang maksimum yang Anda inginkan
            ],
            'isiPesan'=>[
                'type'=> 'varchar',
                'constraint'=> 500,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pesan');
    }

    public function down()
    {
        //
    }
}
