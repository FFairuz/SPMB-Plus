<?php

namespace App\Controllers;

use App\Services\ApplicantService;
use App\Services\PaymentService;
use App\Validation\ValidationRules;

/**
 * ApplicantController
 * 
 * Controller untuk menangani fitur applicant (pendaftar)
 * Menggunakan services untuk business logic
 */
class ApplicantController extends BaseController
{
    /**
     * @var ApplicantService
     */
    private $applicantService;

    /**
     * @var PaymentService
     */
    private $paymentService;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->applicantService = new ApplicantService();
        $this->paymentService = new PaymentService();
    }

    /**
     * Applicant dashboard
     * 
     * @return mixed
     */
    public function dashboard()
    {
        // Check authentication and role
        if (!$this->isApplicantAuthenticated()) {
            return $this->redirectToLogin();
        }

        $userId = session()->get('user_id');
        $applicant = $this->applicantService->getApplicantByUserId($userId);
        $payment = null;

        if ($applicant) {
            $payment = $this->paymentService->getPaymentByApplicantId($applicant['id']);
        }

        return view('applicant/dashboard', [
            'applicant' => $applicant,
            'payment' => $payment,
        ]);
    }

    /**
     * Show registration form
     * 
     * @return mixed
     */
    public function register()
    {
        // Check authentication and role
        if (!$this->isApplicantAuthenticated()) {
            return $this->redirectToLogin();
        }

        $userId = session()->get('user_id');

        // Check if already registered
        $applicant = $this->applicantService->getApplicantByUserId($userId);
        if ($applicant) {
            return redirect()->to('/applicant/dashboard');
        }

        // Check if payment is confirmed
        if (!$this->paymentService->hasConfirmedPayment($userId)) {
            session()->setFlashdata('warning', 'Silakan lakukan pembayaran terlebih dahulu sebelum mengisi form pendaftaran.');
            return redirect()->to('/applicant/payment');
        }

        // Handle form submission
        if ($this->request->getMethod() === 'post') {
            return $this->processRegistration($userId);
        }

        return view('applicant/register');
    }

    /**
     * Process registration form
     * 
     * @param int $userId User ID
     * @return mixed
     */
    private function processRegistration(int $userId)
    {
        // Validate input
        $rules = ValidationRules::extractRules(ValidationRules::applicantRegistration());

        if (!$this->validate($rules)) {
            return view('applicant/register', ['errors' => $this->validator->getErrors()]);
        }

        // Prepare applicant data
        $applicantData = [
            'full_name' => $this->request->getPost('full_name'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'gender' => $this->request->getPost('gender'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'province' => $this->request->getPost('province'),
            'postal_code' => $this->request->getPost('postal_code'),
            'school_origin' => $this->request->getPost('school_origin'),
            'gpa' => $this->request->getPost('gpa'),
        ];

        // Create applicant
        $result = $this->applicantService->createApplicant($applicantData, $userId);

        if (!$result['success']) {
            session()->setFlashdata('error', $result['message']);
            return view('applicant/register');
        }

        session()->setFlashdata('success', 'Data pendaftaran berhasil disimpan!');
        return redirect()->to('/applicant/dashboard');
    }

    /**
     * Edit applicant data
     * 
     * @return mixed
     */
    public function edit()
    {
        // Check authentication and role
        if (!$this->isApplicantAuthenticated()) {
            return $this->redirectToLogin();
        }

        $userId = session()->get('user_id');
        $applicant = $this->applicantService->getApplicantByUserId($userId);

        if (!$applicant) {
            return redirect()->to('/applicant/register');
        }

        // Handle form submission
        if ($this->request->getMethod() === 'post') {
            return $this->processEdit($applicant);
        }

        return view('applicant/edit', ['applicant' => $applicant]);
    }

    /**
     * Process edit form
     * 
     * @param array $applicant Current applicant data
     * @return mixed
     */
    private function processEdit(array $applicant)
    {
        // Validate input
        $rules = ValidationRules::extractRules(ValidationRules::applicantRegistration());

        if (!$this->validate($rules)) {
            return view('applicant/edit', [
                'applicant' => $applicant,
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Prepare updated data
        $applicantData = [
            'full_name' => $this->request->getPost('full_name'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'gender' => $this->request->getPost('gender'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'province' => $this->request->getPost('province'),
            'postal_code' => $this->request->getPost('postal_code'),
            'school_origin' => $this->request->getPost('school_origin'),
            'gpa' => $this->request->getPost('gpa'),
        ];

        // Update applicant
        $result = $this->applicantService->updateApplicant($applicant['id'], $applicantData);

        if (!$result['success']) {
            session()->setFlashdata('error', $result['message']);
            return view('applicant/edit', ['applicant' => $applicant]);
        }

        session()->setFlashdata('success', 'Data berhasil diperbarui!');
        return redirect()->to('/applicant/dashboard');
    }

    /**
     * Check if user is authenticated as applicant
     * 
     * @return bool
     */
    private function isApplicantAuthenticated(): bool
    {
        return session()->has('user_id') && session()->get('role') === 'applicant';
    }

/**
 * Redirect to login page
 * 
 * @return \CodeIgniter\HTTP\RedirectResponse
 */
private function redirectToLogin()
{
    if (!session()->has('user_id')) {
        return redirect()->to('/auth/login');
    }

    session()->setFlashdata('error', 'Anda tidak memiliki akses ke halaman ini. Hanya applicant yang diizinkan.');
    return redirect()->to('/');
}

public function upload_documents()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth/login');
        }

        if (session()->get('role') !== 'applicant') {
            session()->setFlashdata('error', 'Anda tidak memiliki akses ke halaman ini. Hanya applicant yang diizinkan.');
            return redirect()->to('/');
        }

        $user_id = session()->get('user_id');
        $applicant = $this->applicantModel->getApplicantByUserId($user_id);

        if (!$applicant) {
            return redirect()->to('/applicant/register');
        }

        if ($this->request->getMethod() === 'post') {
            $files = $this->request->getFiles();
            $uploaded = false;

            foreach (['birth_certificate', 'report_card', 'identity_card'] as $doc_type) {
                if ($files['files'][$doc_type]->getError() === UPLOAD_ERR_OK) {
                    $file = $files['files'][$doc_type];

                    $newName = $file->getRandomName();
                    $file->move('uploads/documents', $newName);

                    $doc_data = [
                        'applicant_id' => $applicant['id'],
                        'document_type' => $doc_type,
                        'file_name' => $file->getOriginalName(),
                        'file_path' => 'uploads/documents/' . $newName,
                        'uploaded_at' => date('Y-m-d H:i:s'),
                    ];

                    $existing = $this->documentModel->getDocumentByType($applicant['id'], $doc_type);
                    if ($existing) {
                        $this->documentModel->update($existing['id'], $doc_data);
                    } else {
                        $this->documentModel->insert($doc_data);
                    }

                    $uploaded = true;
                }
            }

            if ($uploaded) {
                $this->applicantModel->update($applicant['id'], ['documents_uploaded' => 1]);
                session()->setFlashdata('success', 'Dokumen berhasil diupload!');
                return redirect()->to('/applicant/dashboard');
            }

            session()->setFlashdata('error', 'Gagal mengupload dokumen.');
        }

        $documents = $this->documentModel->getDocumentsByApplicant($applicant['id']);

        return view('applicant/upload_documents', [
            'applicant' => $applicant,
            'documents' => $documents,
        ]);
    }

    /**
     * Payment page untuk siswa melakukan pembayaran
     * Siswa harus membayar terlebih dahulu sebelum bisa mengakses form pendaftaran
     * 
     * @return mixed
     */
    public function payment()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/auth/login');
        }

        if (session()->get('role') !== 'applicant') {
            session()->setFlashdata('error', 'Anda tidak memiliki akses ke halaman ini. Hanya applicant yang diizinkan.');
            return redirect()->to('/');
        }

        $user_id = session()->get('user_id');
        
        // Get user data
        $userModel = new \App\Models\User();
        $userData = $userModel->find($user_id);
        
        if (!$userData) {
            session()->setFlashdata('error', 'Data user tidak ditemukan.');
            return redirect()->to('/auth/login');
        }

        // Get applicant data if exists
        $applicantModel = new \App\Models\Applicant();
        $applicant = $applicantModel->where('user_id', $user_id)->first();

        // Get payment status
        $paymentModel = new \App\Models\PaymentModel();
        $payment = $paymentModel->where('user_id', $user_id)->first();

        // Check if payment is already confirmed and applicant registered
        if ($payment && $payment['payment_status'] === 'confirmed' && $applicant) {
            return redirect()->to('/applicant/dashboard');
        }

        // Handle form submission
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'bank_name' => 'required',
                'account_number' => 'required',
                'account_holder' => 'required',
                'transfer_amount' => 'required|numeric',
                'transfer_date' => 'required|valid_date[Y-m-d]',
                'transfer_proof' => 'uploaded[transfer_proof]|mime_in[transfer_proof,image/jpg,image/jpeg,image/png,application/pdf]|max_size[transfer_proof,2048]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            try {
                // Create or update payment record
                $paymentData = [
                    'user_id' => $user_id,
                    'bank_name' => $this->request->getPost('bank_name'),
                    'account_number' => $this->request->getPost('account_number'),
                    'account_holder' => $this->request->getPost('account_holder'),
                    'transfer_amount' => $this->request->getPost('transfer_amount'),
                    'transfer_date' => $this->request->getPost('transfer_date'),
                    'payment_status' => 'submitted', // Waiting for admin confirmation
                    'registration_fee' => 150000,
                    'submitted_at' => date('Y-m-d H:i:s'),
                ];

                // Handle file upload
                $file = $this->request->getFile('transfer_proof');
                if ($file && $file->isValid()) {
                    $newName = $file->getRandomName();
                    $file->move('uploads/payments', $newName);
                    $paymentData['transfer_proof_path'] = 'uploads/payments/' . $newName;
                }

                // Logic: UPDATE only if payment exists AND status is pending/rejected
                // If confirmed, always create NEW payment (support multiple payments)
                if ($payment && in_array($payment['payment_status'], ['pending', 'rejected', 'submitted'])) {
                    // Update existing pending/rejected payment (re-upload)
                    $paymentModel->update($payment['id'], $paymentData);
                } else {
                    // Create new payment record
                    $paymentModel->insert($paymentData);
                }

                session()->setFlashdata('success', 'Bukti pembayaran berhasil diunggah. Menunggu konfirmasi admin.');
                return redirect()->to('/applicant/payment');
            } catch (\Exception $e) {
                session()->setFlashdata('error', 'Error: ' . $e->getMessage());
                return redirect()->back()->withInput();
            }
        }

        // Prepare user data array
        $user = [
            'email' => $userData['email'] ?? '',
            'name' => $userData['name'] ?? '',
        ];

        return view('applicant/payment', [
            'user' => $user,
            'payment' => $payment,
            'registration_fee' => 150000, // Default registration fee
        ]);
    }

    /**
     * Display visual status timeline
     * Shows the step-by-step progress of applicant's registration
     * 
     * @return mixed
     */
    public function timeline()
    {
        // Check authentication and role
        if (!$this->isApplicantAuthenticated()) {
            return $this->redirectToLogin();
        }

        $userId = session()->get('user_id');
        $applicant = $this->applicantService->getApplicantByUserId($userId);
        
        if (!$applicant) {
            session()->setFlashdata('error', 'Data pendaftar tidak ditemukan.');
            return redirect()->to('/applicant/dashboard');
        }

        // Get payment data
        $payment = $this->paymentService->getPaymentByApplicantId($applicant->id);

        // Calculate timeline progress
        $timelineData = [
            'registration' => [
                'status' => 'completed',
                'date' => $applicant->created_at ?? date('Y-m-d H:i:s'),
                'user' => session()->get('name'),
                'registration_number' => $applicant->registration_number ?? 'PPDB-2024-' . str_pad($applicant->id, 5, '0', STR_PAD_LEFT),
            ],
            'document_verification' => [
                'status' => $applicant->status === 'verified' || $applicant->status === 'accepted' ? 'completed' : ($applicant->status === 'pending' ? 'active' : 'pending'),
                'progress' => $applicant->status === 'pending' ? 65 : ($applicant->status === 'verified' ? 100 : 0),
                'estimated_time' => '1-2 hari kerja',
            ],
            'payment' => [
                'status' => $payment && $payment->status === 'verified' ? 'completed' : ($payment ? 'active' : 'pending'),
                'amount' => 250000,
                'methods' => ['Transfer Bank', 'Virtual Account', 'E-Wallet'],
                'payment_data' => $payment,
            ],
            'payment_verification' => [
                'status' => $payment && $payment->status === 'verified' ? 'completed' : 'pending',
                'verified_by' => $payment && $payment->verified_by ? $payment->verified_by : null,
                'verified_at' => $payment && $payment->verified_at ? $payment->verified_at : null,
            ],
            'entrance_test' => [
                'status' => $applicant->test_status === 'completed' ? 'completed' : ($applicant->test_status === 'scheduled' ? 'active' : 'pending'),
                'test_date' => $applicant->test_date ?? null,
                'test_location' => $applicant->test_location ?? 'TBA',
            ],
            'announcement' => [
                'status' => $applicant->status === 'accepted' ? 'completed' : ($applicant->status === 'rejected' ? 'rejected' : 'pending'),
                'announcement_date' => $applicant->announcement_date ?? null,
            ],
        ];

        // Calculate overall progress percentage
        $completedSteps = 0;
        $totalSteps = 6;
        
        if ($timelineData['registration']['status'] === 'completed') $completedSteps++;
        if ($timelineData['document_verification']['status'] === 'completed') $completedSteps++;
        if ($timelineData['payment']['status'] === 'completed') $completedSteps++;
        if ($timelineData['payment_verification']['status'] === 'completed') $completedSteps++;
        if ($timelineData['entrance_test']['status'] === 'completed') $completedSteps++;
        if ($timelineData['announcement']['status'] === 'completed') $completedSteps++;

        $overallProgress = round(($completedSteps / $totalSteps) * 100);

        return view('applicant/timeline', [
            'applicant' => $applicant,
            'timeline' => $timelineData,
            'progress' => $overallProgress,
        ]);
    }
}
