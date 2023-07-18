<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Products extends Migration
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
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'harga'=>[
                'type'=> 'INT',
                'constraint'=> 11,
            ],
            'keterangan'=>[
                'type'=> 'varchar',
                'constraint'=> 200,
            ],
    ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('products');
    }

    public function down()
    {
        //
    }
}
