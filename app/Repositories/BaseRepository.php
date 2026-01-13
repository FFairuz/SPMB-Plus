<?php

namespace App\Repositories;

use CodeIgniter\Model;

/**
 * Base Repository Class
 * 
 * Menyediakan fungsi-fungsi CRUD dasar untuk semua repository.
 * Mengikuti Repository Pattern untuk abstraksi data access layer.
 */
abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Constructor
     * 
     * @param Model $model Instance dari CodeIgniter Model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Mendapatkan semua data
     * 
     * @return array
     */
    public function findAll()
    {
        return $this->model->findAll();
    }

    /**
     * Mendapatkan data berdasarkan ID
     * 
     * @param int $id Primary key
     * @return array|null
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

    /**
     * Mendapatkan data berdasarkan kondisi tertentu
     * 
     * @param array $conditions Kondisi pencarian
     * @return array|null
     */
    public function findBy(array $conditions)
    {
        $query = $this->model;
        foreach ($conditions as $field => $value) {
            $query = $query->where($field, $value);
        }
        return $query->first();
    }

    /**
     * Mendapatkan semua data berdasarkan kondisi tertentu
     * 
     * @param array $conditions Kondisi pencarian
     * @param array $options Opsi tambahan (limit, offset, orderBy)
     * @return array
     */
    public function findAllBy(array $conditions, array $options = [])
    {
        $query = $this->model;
        
        // Apply conditions
        foreach ($conditions as $field => $value) {
            if (is_array($value)) {
                $query = $query->whereIn($field, $value);
            } else {
                $query = $query->where($field, $value);
            }
        }

        // Apply ordering
        if (isset($options['orderBy'])) {
            foreach ($options['orderBy'] as $field => $direction) {
                $query = $query->orderBy($field, $direction);
            }
        }

        // Apply pagination
        if (isset($options['limit'])) {
            $query = $query->limit($options['limit']);
        }
        if (isset($options['offset'])) {
            $query = $query->offset($options['offset']);
        }

        return $query->findAll();
    }

    /**
     * Menghitung data dengan kondisi tertentu
     * 
     * @param array $conditions Kondisi pencarian
     * @return int
     */
    public function countBy(array $conditions = [])
    {
        $query = $this->model;
        foreach ($conditions as $field => $value) {
            if (is_array($value)) {
                $query = $query->whereIn($field, $value);
            } else {
                $query = $query->where($field, $value);
            }
        }
        return $query->countAllResults();
    }

    /**
     * Membuat data baru
     * 
     * @param array $data Data yang akan disimpan
     * @return int|false ID dari data yang baru dibuat atau false jika gagal
     */
    public function create(array $data)
    {
        if ($this->model->insert($data)) {
            return $this->model->getInsertID();
        }
        return false;
    }

    /**
     * Update data
     * 
     * @param int $id Primary key
     * @param array $data Data yang akan diupdate
     * @return bool
     */
    public function update($id, array $data)
    {
        return $this->model->update($id, $data);
    }

    /**
     * Delete data
     * 
     * @param int $id Primary key
     * @return bool
     */
    public function delete($id)
    {
        return $this->model->delete($id);
    }

    /**
     * Batch create
     * 
     * @param array $data Array of data to insert
     * @return bool
     */
    public function createMany(array $data)
    {
        return $this->model->insertBatch($data);
    }

    /**
     * Batch update
     * 
     * @param array $data Array of data with primary key
     * @return bool
     */
    public function updateMany(array $data)
    {
        return $this->model->updateBatch($data, 'id');
    }

    /**
     * Get model instance
     * 
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }
}
