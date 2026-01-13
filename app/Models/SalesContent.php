<?php

namespace App\Models;

use CodeIgniter\Model;

class SalesContent extends Model
{
    protected $table = 'sales_content';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'type',
        'title',
        'description',
        'video_url',
        'file_path',
        'fee_amount',
        'fee_category',
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
        'type' => 'required|in_list[video,brochure,fee_info,other]',
        'title' => 'required|max_length[255]',
        'description' => 'permit_empty',
        'video_url' => 'permit_empty|max_length[500]',
        'file_path' => 'permit_empty|max_length[255]',
        'fee_amount' => 'permit_empty|decimal',
        'fee_category' => 'permit_empty|max_length[100]',
        'display_order' => 'permit_empty|integer',
        'is_active' => 'permit_empty|in_list[0,1]'
    ];

    protected $validationMessages = [
        'type' => [
            'required' => 'Tipe konten harus dipilih',
            'in_list' => 'Tipe konten tidak valid'
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
     * Get content by type
     *
     * @param string $type
     * @return array
     */
    public function getByType(string $type)
    {
        return $this->where('type', $type)
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
                    ->orderBy('type', 'ASC')
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

    /**
     * Get videos for sales dashboard
     *
     * @return array
     */
    public function getVideos()
    {
        return $this->getByType('video');
    }

    /**
     * Get brochures for sales dashboard
     *
     * @return array
     */
    public function getBrochures()
    {
        return $this->getByType('brochure');
    }

    /**
     * Get fee information
     *
     * @return array
     */
    public function getFeeInfo()
    {
        return $this->getByType('fee_info');
    }
}
