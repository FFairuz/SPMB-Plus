<?php

namespace App\Models;

use CodeIgniter\Model;

class Document extends Model
{
    protected $table = 'documents';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['applicant_id', 'document_type', 'file_name', 'file_path'];
    protected $useTimestamps = false;

    public function getDocumentsByApplicant($applicant_id)
    {
        return $this->where('applicant_id', $applicant_id)->findAll();
    }

    public function getDocumentByType($applicant_id, $document_type)
    {
        return $this->where('applicant_id', $applicant_id)
            ->where('document_type', $document_type)
            ->first();
    }
}
