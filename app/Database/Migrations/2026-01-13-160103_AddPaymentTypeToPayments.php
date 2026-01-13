<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaymentTypeToPayments extends Migration
{
    public function up()
    {
        $this->forge->addColumn('payments', [
            'payment_type' => [
                'type' => 'ENUM',
                'constraint' => ['lunas', 'cicilan'],
                'default' => 'lunas',
                'after' => 'payment_method',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('payments', 'payment_type');
    }
}
