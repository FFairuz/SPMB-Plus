<?php

namespace App\Services;

use App\Repositories\ApplicantRepository;

/**
 * Admin Service
 * 
 * Service untuk menangani business logic dari dashboard admin dan management applicants.
 */
class AdminService
{
    /**
     * @var ApplicantRepository
     */
    protected $applicantRepository;

    /**
     * Constructor
     */
    public function __construct(ApplicantRepository $applicantRepository = null)
    {
        $this->applicantRepository = $applicantRepository ?? new ApplicantRepository();
    }

    /**
     * Get dashboard statistics
     * 
     * @return array
     */
    public function getDashboardStats()
    {
        $stats = $this->applicantRepository->getStatistics();
        
        // Map 'total' to 'total_applicants' for view compatibility
        return [
            'total_applicants' => $stats['total'],
            'total' => $stats['total'],
            'draft' => $stats['draft'],
            'submitted' => $stats['submitted'],
            'pending' => $stats['submitted'], // Map submitted to pending for view
            'verified' => $stats['verified'],
            'accepted' => $stats['accepted'],
            'diterima' => $stats['accepted'], // Alternative key
            'rejected' => $stats['rejected'],
            'ditolak' => $stats['rejected'], // Alternative key
        ];
    }

    /**
     * Get applicants with filters
     * 
     * @param array $filters Filter conditions
     * @param int $page Current page
     * @param int $limit Items per page
     * @return array ['data' => array, 'total' => int, 'pages' => int]
     */
    public function getApplicants(array $filters = [], $page = 1, $limit = 15)
    {
        // Validate limit to prevent division by zero
        $limit = (int)$limit;
        if ($limit <= 0) {
            $limit = 15; // Default limit
        }
        
        // Validate page
        $page = (int)$page;
        if ($page < 1) {
            $page = 1;
        }
        
        // Calculate offset
        $offset = ($page - 1) * $limit;

        $filters = array_filter($filters, function($value) {
            return $value !== null && $value !== '';
        });

        $options = [
            'limit' => $limit,
            'offset' => $offset,
            'orderBy' => ['created_at' => 'DESC'],
        ];

        $data = $this->applicantRepository->getFiltered($filters, $options);
        $total = $this->applicantRepository->countBy($filters);
        $pages = $limit > 0 ? ceil($total / $limit) : 0;

        return [
            'data' => $data,
            'total' => $total,
            'pages' => $pages,
            'current_page' => $page,
            'per_page' => $limit,
        ];
    }

    /**
     * Get applicant detail
     * 
     * @param int $id Applicant ID
     * @return array|null
     */
    public function getApplicantDetail($id)
    {
        return $this->applicantRepository->findById($id);
    }

    /**
     * Verify applicant (update status to verified)
     * 
     * @param int $id Applicant ID
     * @param string|null $catatan Notes/comments
     * @return bool
     */
    public function verifyApplicant($id, $catatan = null)
    {
        return $this->applicantRepository->updateStatus($id, 'verified', $catatan);
    }

    /**
     * Accept applicant
     * 
     * @param int $id Applicant ID
     * @param string|null $catatan Notes/comments
     * @return bool
     */
    public function acceptApplicant($id, $catatan = null)
    {
        return $this->applicantRepository->updateStatus($id, 'diterima', $catatan);
    }

    /**
     * Reject applicant
     * 
     * @param int $id Applicant ID
     * @param string $alasan Reason for rejection
     * @return bool
     */
    public function rejectApplicant($id, $alasan)
    {
        return $this->applicantRepository->updateStatus($id, 'ditolak', $alasan);
    }

    /**
     * Get applicants by status
     * 
     * @param string $status Status filter
     * @param int $limit Limit results
     * @return array
     */
    public function getApplicantsByStatus($status, $limit = 10)
    {
        return $this->applicantRepository->getByStatus($status, [
            'limit' => $limit,
            'orderBy' => ['created_at' => 'DESC'],
        ]);
    }

    /**
     * Get top performing applicants
     * 
     * @param int $limit Limit results
     * @return array
     */
    public function getTopApplicants($limit = 10)
    {
        return $this->applicantRepository->getTopApplicants($limit);
    }

    /**
     * Get statistics by province
     * 
     * @return array
     */
    public function getStatisticsByProvince()
    {
        return $this->applicantRepository->getStatisticsByProvince();
    }

    /**
     * Search applicant
     * 
     * @param string $query Search query (NIK, nama, nomor pendaftaran)
     * @return array
     */
    public function searchApplicant($query)
    {
        $query = trim($query);
        if (empty($query)) {
            return [];
        }

        $applicants = $this->applicantRepository->findAll();
        $results = [];

        foreach ($applicants as $applicant) {
            if (
                stripos($applicant['nik'], $query) !== false ||
                stripos($applicant['nama_lengkap'], $query) !== false ||
                stripos($applicant['nomor_pendaftaran'], $query) !== false
            ) {
                $results[] = $applicant;
            }
        }

        return array_slice($results, 0, 20);
    }

    /**
     * Export applicants to CSV
     * 
     * @param array $filters Filter conditions
     * @return string CSV data
     */
    public function exportToCSV(array $filters = [])
    {
        $applicants = $this->applicantRepository->getFiltered($filters);

        if (empty($applicants)) {
            return '';
        }

        $csv = "Nomor Pendaftaran,NIK,Nama Lengkap,Jenis Kelamin,Tanggal Lahir,Asal Sekolah,Status,Tanggal Daftar\n";

        foreach ($applicants as $applicant) {
            $csv .= sprintf(
                "\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\"\n",
                $applicant['nomor_pendaftaran'],
                $applicant['nik'],
                $applicant['nama_lengkap'],
                $applicant['jenis_kelamin'],
                $applicant['tanggal_lahir'],
                $applicant['asal_sekolah'],
                $applicant['status'],
                $applicant['created_at']
            );
        }

        return $csv;
    }

    /**
     * Get daily registration statistics
     * 
     * @param int $days Number of days to include
     * @return array
     */
    public function getDailyStats($days = 30)
    {
        $stats = [];
        $startDate = date('Y-m-d', strtotime("-{$days} days"));

        // Initialize stats array with dates
        for ($i = 0; $i < $days; $i++) {
            $date = date('Y-m-d', strtotime("+{$i} days", strtotime($startDate)));
            $stats[$date] = 0;
        }

        $applicants = $this->applicantRepository->findAll();

        foreach ($applicants as $applicant) {
            $date = substr($applicant['created_at'], 0, 10);
            if (isset($stats[$date])) {
                $stats[$date]++;
            }
        }

        return $stats;
    }

    /**
     * Generate report data
     * 
     * @return array
     */
    public function generateReport()
    {
        return [
            'total_pendaftar' => $this->applicantRepository->countBy(),
            'draft' => $this->applicantRepository->countBy(['status' => 'draft']),
            'submitted' => $this->applicantRepository->countBy(['status' => 'submitted']),
            'verified' => $this->applicantRepository->countBy(['status' => 'verified']),
            'diterima' => $this->applicantRepository->countBy(['status' => 'diterima']),
            'ditolak' => $this->applicantRepository->countBy(['status' => 'ditolak']),
            'by_province' => $this->applicantRepository->getStatisticsByProvince(),
            'top_applicants' => $this->applicantRepository->getTopApplicants(10),
        ];
    }

    /**
     * Register applicant manually by admin
     * 
     * @param array $data Applicant data
     * @return int Applicant ID
     */
    public function registerApplicantManually(array $data)
    {
        // Generate nomor pendaftaran
        $nomor_pendaftaran = $this->applicantRepository->generateNomorPendaftaran();

        // Prepare data for insertion
        $applicantData = [
            'nik' => $data['nik'],
            'nama_lengkap' => $data['nama_lengkap'],
            'jenis_kelamin' => $data['jenis_kelamin'] ?? 'laki-laki',
            'tanggal_lahir' => $data['tanggal_lahir'] ?? date('Y-m-d'),
            'asal_sekolah' => $data['asal_sekolah'] ?? '',
            'provinsi' => $data['provinsi'] ?? '',
            'kabupaten' => $data['kabupaten'] ?? '',
            'nomor_pendaftaran' => $nomor_pendaftaran,
            'status' => 'submitted', // Default status
        ];

        // Insert applicant
        return $this->applicantRepository->create($applicantData);
    }
}
