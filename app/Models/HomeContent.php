<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeContent extends Model
{
    protected $table = 'home_content';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'section',
        'title',
        'subtitle',
        'content',
        'image',
        'button_text',
        'button_link',
        'display_order',
        'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'section' => 'required|max_length[100]',
        'title' => 'required|max_length[255]',
        'subtitle' => 'permit_empty|max_length[255]',
        'content' => 'permit_empty',
        'image' => 'permit_empty|max_length[255]',
        'button_text' => 'permit_empty|max_length[100]',
        'button_link' => 'permit_empty|max_length[255]',
        'display_order' => 'permit_empty|integer',
        'is_active' => 'permit_empty|in_list[0,1]'
    ];

    protected $validationMessages = [
        'section' => [
            'required' => 'Section harus diisi',
            'max_length' => 'Section maksimal 100 karakter'
        ],
        'title' => [
            'required' => 'Judul harus diisi',
            'max_length' => 'Judul maksimal 255 karakter'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get content by section
     *
     * @param string $section
     * @return array
     */
    public function getBySection(string $section)
    {
        return $this->where('section', $section)
                    ->where('is_active', 1)
                    ->orderBy('display_order', 'ASC')
                    ->findAll();
    }

    /**
     * Get active content
     *
     * @return array
     */
    public function getActiveContent()
    {
        return $this->where('is_active', 1)
                    ->orderBy('section', 'ASC')
                    ->orderBy('display_order', 'ASC')
                    ->findAll();
    }

    /**
     * Toggle active status
     *
     * @param int $id
     * @return bool
     */
    public function toggleStatus(int $id)
    {
        $content = $this->find($id);
        if ($content) {
            $newStatus = $content['is_active'] == 1 ? 0 : 1;
            return $this->update($id, ['is_active' => $newStatus]);
        }
        return false;
    }
}
