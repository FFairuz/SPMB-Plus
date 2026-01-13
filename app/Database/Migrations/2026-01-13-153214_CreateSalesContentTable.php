<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSalesContentTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['video', 'brochure', 'fee_info', 'other'],
                'default' => 'other',
                'comment' => 'Type: video, brochure, fee_info, other',
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'video_url' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
                'comment' => 'YouTube/Vimeo URL for video content',
            ],
            'file_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'Path for PDF/image files',
            ],
            'fee_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'null' => true,
                'comment' => 'Fee amount for fee_info type',
            ],
            'fee_category' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'comment' => 'Category: pendaftaran, SPP, dll',
            ],
            'display_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addKey('type');
        $this->forge->addKey('is_active');
        $this->forge->createTable('sales_content');
    }

    public function down()
    {
        $this->forge->dropTable('sales_content');
    }
}
