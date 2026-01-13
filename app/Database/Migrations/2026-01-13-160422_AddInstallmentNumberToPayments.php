<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddInstallmentNumberToPayments extends Migration
{
    public function up()
    {
        $this->forge->addColumn('payments', [
            'installment_number' => [
                'type' => 'TINYINT',
                'constraint' => 2,
                'unsigned' => true,
                'null' => true,
                'comment' => 'Cicilan ke berapa (1-10)',
                'after' => 'payment_type'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('payments', 'installment_number');
    }
}
