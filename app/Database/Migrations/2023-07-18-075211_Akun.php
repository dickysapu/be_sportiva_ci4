<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Akun extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'auto_increment' => true
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ]
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->createTable('akun');
        
    }

    public function down()
    {
        //
    }
}
