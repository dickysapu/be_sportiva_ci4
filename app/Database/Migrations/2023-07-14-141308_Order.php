<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Order extends Migration
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
                'constraint' => 13, // Sesuaikan panjang maksimum yang Anda inginkan
            ],
            'lapangan'=>[
                'type'=> 'varchar',
                'constraint'=> 500,
            ],
            'tanggal'=>[
                'type'=> 'date',
            ],
            'waktu'=>[
                'type'=> 'char',
                'constraint'=> 10,
            ],
            'tanggal_pesanan_dibuat'=>[
                'type'=> 'datetime'
            ],
            'orderId'=>[
                'type'=> 'varchar',
                'constraint'=> 200,
            ],
            'metodePembayaran'=>[
                'type'=> 'varchar',
                'constraint'=> 200,
            ],
            'status'=>[
                'type'=> 'varchar',
                'constraint'=> 100,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('order');
    }

    public function down()
    {
        //
    }
}
