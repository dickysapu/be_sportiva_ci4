<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JadwalJam extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=> 'INT',
                'constraint'=> 5,
                'auto_increment'=> true
            ],
            'jam'=>[
                'type'=> 'varchar',
                'constraint'=> 5,
            ],
            'status'=>[
                'type'=> 'varchar',
                'constraint'=> 11,
            ],
    ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('jadwalJam');
    
    }

    public function down()
    {
        //
    }
}
