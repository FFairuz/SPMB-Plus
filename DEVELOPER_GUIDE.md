# Quick Reference - PPDB Clean Code Architecture

## 🚀 Quick Start untuk Developer

### Import Services yang Diperlukan
```php
use App\Services\AuthService;
use App\Services\ApplicantService;
use App\Services\PaymentService;
use App\Validation\ValidationRules;
use App\Helpers\ResponseHelper;
```

## 📝 Common Patterns

### 1. Authentication Check
```php
// In Controller
private function isAuthenticated(): bool
{
    return session()->has('user_id') && session()->get('is_logged_in');
}

// Using AuthService
$authService = new AuthService();
if (!$authService->isLoggedIn()) {
    return redirect()->to('/auth/login');
}
```

### 2. Login User
```php
$authService = new AuthService();

// Authenticate
$result = $authService->authenticate($email, $password);

if ($result['success']) {
    // Create session
    $authService->createSession($result['user']);
    
    // Redirect to dashboard
    return $authService->redirectToDashboard($result['user']['role']);
}

// Handle error
session()->setFlashdata('error', $result['message']);
```

### 3. Register New User
```php
$authService = new AuthService();

$userData = [
    'username' => $this->request->getPost('username'),
    'email' => $this->request->getPost('email'),
    'password' => $this->request->getPost('password'),
    'role' => 'applicant',
];

$result = $authService->register($userData);

if ($result['success']) {
    session()->setFlashdata('success', 'Registrasi berhasil!');
    return redirect()->to('/auth/login');
}

session()->setFlashdata('error', $result['message']);
```

### 4. Create Applicant
```php
$applicantService = new ApplicantService();

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

$userId = session()->get('user_id');
$result = $applicantService->createApplicant($applicantData, $userId);

if ($result['success']) {
    session()->setFlashdata('success', 'Data pendaftaran berhasil disimpan!');
    return redirect()->to('/applicant/dashboard');
}

session()->setFlashdata('error', $result['message']);
```

### 5. Process Payment
```php
$paymentService = new PaymentService();

$paymentData = [
    'user_id' => session()->get('user_id'),
    'amount' => $this->request->getPost('amount'),
    'payment_method' => $this->request->getPost('payment_method'),
];

$result = $paymentService->createPayment($paymentData);

if ($result['success']) {
    // Upload payment proof if file exists
    if ($file = $this->request->getFile('payment_proof')) {
        $uploadResult = $paymentService->uploadPaymentProof(
            $result['payment_id'], 
            $file
        );
    }
    
    return redirect()->to('/applicant/payment');
}
```

### 6. Verify Payment (Bendahara)
```php
$paymentService = new PaymentService();

$result = $paymentService->verifyPayment(
    $paymentId,
    PaymentService::STATUS_CONFIRMED, // or STATUS_REJECTED
    'Pembayaran valid dan terkonfirmasi'
);

if ($result['success']) {
    return ResponseHelper::success($result, 'Pembayaran berhasil diverifikasi');
}

return ResponseHelper::error($result['message']);
```

### 7. Using Validation Rules
```php
// Get validation rules
$rules = ValidationRules::extractRules(
    ValidationRules::applicantRegistration()
);

// Validate
if (!$this->validate($rules)) {
    return view('applicant/register', [
        'errors' => $this->validator->getErrors()
    ]);
}

// Or get specific rules
$loginRules = ValidationRules::extractRules(ValidationRules::userLogin());
$paymentRules = ValidationRules::extractRules(ValidationRules::payment());
```

### 8. Standardized Responses
```php
use App\Helpers\ResponseHelper;

// Success response
return ResponseHelper::success($data, 'Operasi berhasil');

// Error response
return ResponseHelper::error('Terjadi kesalahan', 400);

// Validation error
return ResponseHelper::validationError($errors, 'Data tidak valid');

// Not found
return ResponseHelper::notFound('Data tidak ditemukan');

// Unauthorized
return ResponseHelper::unauthorized('Anda harus login');

// Forbidden
return ResponseHelper::forbidden('Akses ditolak');

// Paginated
return ResponseHelper::paginated($items, $total, $page, $perPage);
```

### 9. Upload Document
```php
$applicantService = new ApplicantService();

$file = $this->request->getFile('document_file');
$documentType = $this->request->getPost('document_type');

$result = $applicantService->uploadDocument(
    $applicantId,
    $documentType,
    $file
);

if ($result['success']) {
    session()->setFlashdata('success', 'Dokumen berhasil diunggah');
    return redirect()->back();
}

session()->setFlashdata('error', $result['message']);
```

### 10. Get Statistics
```php
// Applicant stats
$applicantService = new ApplicantService();
$stats = $applicantService->getApplicantStats();
// Returns: ['total' => X, 'pending' => Y, 'verified' => Z, ...]

// Payment stats
$paymentService = new PaymentService();
$stats = $paymentService->getPaymentStats();
// Returns: ['total' => X, 'confirmed' => Y, 'total_amount' => Z, ...]
```

### 11. Change Applicant Status
```php
$applicantService = new ApplicantService();

$result = $applicantService->changeStatus(
    $applicantId,
    ApplicantService::STATUS_VERIFIED
);

if ($result['success']) {
    return ResponseHelper::success($result);
}

return ResponseHelper::error($result['message']);
```

### 12. Check Payment Status
```php
$paymentService = new PaymentService();

// Check if user has confirmed payment
if ($paymentService->hasConfirmedPayment($userId)) {
    // Allow registration
} else {
    // Redirect to payment page
    return redirect()->to('/applicant/payment');
}
```

## 🎯 Available Constants

### Payment Status
```php
PaymentService::STATUS_PENDING      // 'pending'
PaymentService::STATUS_CONFIRMED    // 'confirmed'
PaymentService::STATUS_REJECTED     // 'rejected'
```

### Applicant Status
```php
ApplicantService::STATUS_PENDING    // 'pending'
ApplicantService::STATUS_SUBMITTED  // 'submitted'
ApplicantService::STATUS_VERIFIED   // 'verified'
ApplicantService::STATUS_ACCEPTED   // 'accepted'
ApplicantService::STATUS_REJECTED   // 'rejected'
```

## 🔧 Service Methods Reference

### AuthService
| Method | Parameters | Returns |
|--------|-----------|---------|
| `authenticate()` | email, password | array |
| `register()` | userData | array |
| `createSession()` | user | void |
| `destroySession()` | - | void |
| `isLoggedIn()` | - | bool |
| `getCurrentUser()` | - | array\|null |
| `getCurrentUserRole()` | - | string\|null |
| `redirectToDashboard()` | role (optional) | RedirectResponse |
| `hasRole()` | requiredRole | bool |
| `isAdmin()` | - | bool |

### ApplicantService
| Method | Parameters | Returns |
|--------|-----------|---------|
| `createApplicant()` | applicantData, userId | array |
| `updateApplicant()` | applicantId, applicantData | array |
| `changeStatus()` | applicantId, status | array |
| `uploadDocument()` | applicantId, documentType, file | array |
| `getApplicantByUserId()` | userId | array\|null |
| `getApplicantById()` | applicantId | array\|null |
| `getApplicantWithDocuments()` | applicantId | array\|null |
| `getApplicants()` | filters, page, limit | array |
| `getApplicantStats()` | - | array |
| `canRegister()` | userId | bool |

### PaymentService
| Method | Parameters | Returns |
|--------|-----------|---------|
| `createPayment()` | paymentData | array |
| `uploadPaymentProof()` | paymentId, file | array |
| `verifyPayment()` | paymentId, status, notes | array |
| `getPaymentByUserId()` | userId | array\|null |
| `getPaymentByApplicantId()` | applicantId | array\|null |
| `getPaymentById()` | paymentId | array\|null |
| `hasConfirmedPayment()` | userId | bool |
| `getPayments()` | filters, page, limit | array |
| `getPaymentStats()` | - | array |
| `linkPaymentToApplicant()` | paymentId, applicantId | array |

## 📋 Response Format

### Standard Success Response
```json
{
    "success": true,
    "message": "Operasi berhasil",
    "data": { ... },
    "status_code": 200
}
```

### Standard Error Response
```json
{
    "success": false,
    "message": "Error message",
    "status_code": 400,
    "errors": { ... } // optional
}
```

### Paginated Response
```json
{
    "success": true,
    "message": "Success",
    "data": [ ... ],
    "pagination": {
        "total": 100,
        "page": 1,
        "per_page": 15,
        "total_pages": 7
    },
    "status_code": 200
}
```

## 🐛 Error Handling

### Using Try-Catch
```php
try {
    $result = $service->someMethod();
    
    if (!$result['success']) {
        throw new Exception($result['message']);
    }
    
    // Success handling
} catch (ValidationException $e) {
    return ResponseHelper::validationError($e->getErrorData());
} catch (AuthenticationException $e) {
    return ResponseHelper::unauthorized($e->getMessage());
} catch (AuthorizationException $e) {
    return ResponseHelper::forbidden($e->getMessage());
} catch (NotFoundException $e) {
    return ResponseHelper::notFound($e->getMessage());
} catch (Exception $e) {
    log_message('error', $e->getMessage());
    return ResponseHelper::serverError('Terjadi kesalahan sistem');
}
```

## 🧪 Testing Example

### Unit Test for Service
```php
use PHPUnit\Framework\TestCase;
use App\Services\AuthService;

class AuthServiceTest extends TestCase
{
    public function testAuthenticateSuccess()
    {
        $service = new AuthService();
        
        $result = $service->authenticate(
            'test@example.com',
            'password123'
        );
        
        $this->assertTrue($result['success']);
        $this->assertNotNull($result['user']);
    }
    
    public function testAuthenticateFailure()
    {
        $service = new AuthService();
        
        $result = $service->authenticate(
            'test@example.com',
            'wrongpassword'
        );
        
        $this->assertFalse($result['success']);
        $this->assertNull($result['user']);
    }
}
```

## 📖 Best Practices

### ✅ DO
- Use services for business logic
- Use DTOs for data transfer
- Use ValidationRules for validation
- Use ResponseHelper for responses
- Use constants for status values
- Add PHPDoc comments
- Handle errors properly
- Log important operations

### ❌ DON'T
- Put business logic in controllers
- Access models directly from controllers
- Hardcode validation rules
- Mix response formats
- Use magic strings for statuses
- Skip error handling
- Ignore logging

## 🔗 Related Files
- [CLEAN_CODE_REFACTORING.md](CLEAN_CODE_REFACTORING.md) - Complete guide
- [README.md](README.md) - Project overview

---

**Last Updated:** 2026-01-13  
**Version:** 2.0
