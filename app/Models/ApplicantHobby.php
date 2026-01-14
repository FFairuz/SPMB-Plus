<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Applicant Hobby Model
 * 
 * Model untuk tabel applicant_hobbies (pivot table)
 * Many-to-many relationship antara applicants dan hobbies
 */
class ApplicantHobby extends Model
{
    protected $table = 'applicant_hobbies';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'applicant_id',
        'hobby_id',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = null; // No updated_at in this table

    /**
     * Get hobbies by applicant ID
     * 
     * @param int $applicantId
     * @return array
     */
    public function getHobbiesByApplicant($applicantId)
    {
        return $this->db->table('applicant_hobbies')
            ->select('hobbies.*')
            ->join('hobbies', 'hobbies.id = applicant_hobbies.hobby_id')
            ->where('applicant_hobbies.applicant_id', $applicantId)
            ->orderBy('hobbies.nama_hobi', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Get hobby IDs by applicant ID
     * 
     * @param int $applicantId
     * @return array Array of hobby IDs
     */
    public function getHobbyIdsByApplicant($applicantId)
    {
        $results = $this->where('applicant_id', $applicantId)
            ->findAll();
        
        return array_column($results, 'hobby_id');
    }

    /**
     * Sync hobbies for an applicant
     * Replace all existing hobbies with new ones
     * 
     * @param int $applicantId
     * @param array $hobbyIds Array of hobby IDs
     * @return bool
     */
    public function syncHobbies($applicantId, $hobbyIds = [])
    {
        // Start transaction
        $this->db->transStart();

        // Delete existing hobbies
        $this->where('applicant_id', $applicantId)->delete();

        // Insert new hobbies
        if (!empty($hobbyIds)) {
            $data = [];
            foreach ($hobbyIds as $hobbyId) {
                $data[] = [
                    'applicant_id' => $applicantId,
                    'hobby_id' => $hobbyId,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
            }
            $this->insertBatch($data);
        }

        // Complete transaction
        $this->db->transComplete();

        return $this->db->transStatus();
    }

    /**
     * Delete hobbies by applicant ID
     * 
     * @param int $applicantId
     * @return bool
     */
    public function deleteByApplicant($applicantId)
    {
        return $this->where('applicant_id', $applicantId)->delete();
    }
}
