<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaymentReceiptFields extends Migration
{
    public function up()
    {
        // Add fields for receipt tracking and bendahara verification
        $this->forge->addColumn('payments', [
            'receipt_number' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'unique' => true,
                'comment' => 'Nomor kwitansi unik',
            ],
            'verified_by_bendahara' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'comment' => 'ID bendahara yang verifikasi',
            ],
            'verified_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Waktu verifikasi pembayaran',
            ],
            'receipt_printed_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Waktu kwitansi dicetak',
            ],
            'printed_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'comment' => 'ID bendahara yang cetak kwitansi',
            ],
        ]);

        // Add foreign key for verified_by_bendahara
        $this->forge->addForeignKey('verified_by_bendahara', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('printed_by', 'users', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('payments', 'payments_verified_by_bendahara_foreign');
        $this->forge->dropForeignKey('payments', 'payments_printed_by_foreign');
        $this->forge->dropColumn('payments', [
            'receipt_number',
            'verified_by_bendahara',
            'verified_at',
            'receipt_printed_at',
            'printed_by',
        ]);
    }
}
