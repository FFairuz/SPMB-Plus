<?php

namespace App\Controllers;

use App\Services\RegistrationService;
use App\Models\School;
use App\Traits\AuthTrait;
use App\Traits\ResponseTrait;
use App\Traits\ValidationTrait;

/**
 * Registration Controller
 * 
 * Controller untuk menangani proses registrasi applicant PPDB.
 * Menggunakan RegistrationService untuk business logic dan Repository untuk data access.
 */
class Registration extends BaseController
{
    use AuthTrait;
    use ResponseTrait;
    use ValidationTrait;

    /**
     * @var RegistrationService
     */
    protected $registrationService;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->registrationService = new RegistrationService();
    }

    /**
     * Tampilkan form registrasi
     * 
     * @return mixed
     */
    public function index()
    {
        $this->requireLogin();

        $userId = $this->getUserId();
        $applicant = $this->registrationService->getRegistrationForm($userId);

        // Redirect ke dashboard jika sudah submit
        if ($applicant && $applicant['status'] !== 'draft') {
            return redirect()->to('/applicant/dashboard');
        }

        $schoolModel = new School();
        $data = [
            'title' => 'Form Pendaftaran PPDB',
            'applicant' => $applicant,
            'edit_mode' => $applicant ? true : false,
            'progress' => $applicant ? $this->registrationService->getProgress($applicant) : 0,
            'schools' => $schoolModel->orderBy('provinsi')->orderBy('kota')->orderBy('nama')->findAll(),
        ];

        return view('registration/form', $data);
    }

    /**
     * Simpan data registrasi (AJAX)
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function save()
    {
        if (!$this->request->isAJAX()) {
            return $this->errorResponse('Invalid request', null, 400);
        }

        $this->requireLogin();

        $userId = $this->getUserId();
        $formData = $this->request->getJSON();

        // Convert JSON to array
        $data = json_decode(json_encode($formData), true);

        // Save registration
        $result = $this->registrationService->saveRegistration($userId, $data);

        if ($result['success']) {
            return $this->successResponse($result['message'], $result['data']);
        } else {
            return $this->errorResponse(
                $result['message'],
                $result['errors'] ?? null,
                400
            );
        }
    }

    /**
     * Simpan dan lanjut ke preview
     * 
     * @return mixed
     */
    public function saveAndPreview()
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->errorResponse('Method Not Allowed', null, 405);
        }

        $this->requireLogin();

        $userId = $this->getUserId();
        $data = $this->request->getPost();

        // Validate input
        $validationRules = [
            'nik' => 'required|string|min_length[16]|max_length[16]',
            'nama_lengkap' => 'required|string|min_length[3]',
            'jenis_kelamin' => 'required|in_list[laki-laki,perempuan]',
            'tanggal_lahir' => 'required|valid_date[Y-m-d]',
            'agama' => 'required|string',
            'nomor_hp' => 'required|string',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save registration
        $result = $this->registrationService->saveRegistration($userId, $data);

        if ($result['success']) {
            session()->setFlashdata('success', $result['message']);
            return redirect()->to('/registration/preview');
        } else {
            session()->setFlashdata('error', $result['message']);
            return redirect()->back()->withInput();
        }
    }

    /**
     * Tampilkan preview registrasi
     * 
     * @return mixed
     */
    public function preview()
    {
        $this->requireLogin();

        $userId = $this->getUserId();
        $applicant = $this->registrationService->getPreviewData($userId);

        if (!$applicant) {
            session()->setFlashdata('error', 'Data registrasi tidak ditemukan');
            return redirect()->to('/registration');
        }

        $data = [
            'title' => 'Preview Pendaftaran PPDB',
            'applicant' => $applicant,
            'nomor_pendaftaran' => $applicant['nomor_pendaftaran'],
        ];

        return view('registration/preview', $data);
    }

    /**
     * Submit registrasi
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function submit()
    {
        if (!$this->request->isAJAX()) {
            return $this->errorResponse('Invalid request', null, 400);
        }

        $this->requireLogin();

        $userId = $this->getUserId();

        // Submit registration
        $result = $this->registrationService->submitRegistration($userId);

        if ($result['success']) {
            return $this->successResponse($result['message'], $result['data']);
        } else {
            return $this->errorResponse($result['message'], null, 400);
        }
    }

    /**
     * Get registration summary (AJAX)
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function getSummary()
    {
        if (!$this->request->isAJAX()) {
            return $this->errorResponse('Invalid request', null, 400);
        }

        $this->requireLogin();

        $userId = $this->getUserId();
        $summary = $this->registrationService->getSummary($userId);

        if ($summary) {
            return $this->successResponse('Summary retrieved', $summary);
        } else {
            return $this->errorResponse('Summary not found', null, 404);
        }
    }

    /**
     * Print preview
     * 
     * @return mixed
     */
    public function printPreview()
    {
        $this->requireLogin();

        $userId = $this->getUserId();
        $applicant = $this->registrationService->getPreviewData($userId);

        if (!$applicant) {
            return redirect()->to('/registration');
        }

        $data = [
            'title' => 'Form Pendaftaran PPDB',
            'applicant' => $applicant,
            'print_mode' => true,
        ];

        return view('registration/print', $data);
    }

    /**
     * Multi-Step Form Wizard
     * Modern registration form with 6-step wizard interface
     * 
     * @return mixed
     */
    public function wizard()
    {
        $this->requireLogin();

        $userId = $this->getUserId();
        $applicant = $this->registrationService->getRegistrationForm($userId);

        // Redirect to dashboard if already submitted
        if ($applicant && $applicant['status'] !== 'draft') {
            return redirect()->to('/applicant/dashboard');
        }

        // Get reference data for dropdowns
        $schoolModel = new School();
        $schools = $schoolModel->findAll();

        // Get majors (jurusan) from database
        $majorModel = model('App\Models\Major');
        $majors = $majorModel->findAll();

        // Get hobbies from database
        $hobbyModel = model('App\Models\Hobby');
        $hobbies = $hobbyModel->findAll();

        $data = [
            'title' => 'Form Pendaftaran - Multi-Step Wizard',
            'applicant' => $applicant ?? [],
            'schools' => $schools,
            'majors' => $majors,
            'hobbies' => $hobbies,
            'user' => [
                'name' => session()->get('name'),
                'email' => session()->get('email'),
            ],
        ];

        return view('registration/form_wizard', $data);
    }
}
