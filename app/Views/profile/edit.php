<?= $this->extend('layout/app'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Page Header -->
            <div class="d-flex align-items-center mb-4">
                <a href="javascript:history.back()" class="btn btn-outline-primary me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h2 class="mb-1">Edit Profile</h2>
                    <p class="text-muted mb-0">Update your personal information and account settings</p>
                </div>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeIn" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Profile Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-person-circle me-2"></i>
                        Personal Information
                    </h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('profile/update') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <!-- User Avatar Display -->
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <?php if (session()->get('profile_picture') && file_exists(FCPATH . 'uploads/profiles/' . session()->get('profile_picture'))): ?>
                                    <img src="<?= base_url('uploads/profiles/' . session()->get('profile_picture')) ?>" 
                                         alt="Profile" class="user-avatar-large" id="avatarPreview">
                                <?php else: ?>
                                    <div class="user-avatar-large" id="avatarPreview">
                                        <?= strtoupper(substr(session()->get('username'), 0, 2)) ?>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Upload Button Overlay -->
                                <label for="profile_picture" class="avatar-upload-btn" title="Change Profile Picture">
                                    <i class="bi bi-camera-fill"></i>
                                    <input type="file" id="profile_picture" name="profile_picture" 
                                           accept="image/jpeg,image/jpg,image/png" style="display: none;" 
                                           onchange="previewImage(this)">
                                </label>
                            </div>
                            <p class="text-muted mt-2 mb-0">
                                <span class="badge badge-primary"><?= ucfirst(session()->get('role')) ?></span>
                            </p>
                            <small class="text-muted d-block mt-2">Click camera icon to change picture</small>
                            <small class="text-muted">Max 2MB (JPG, PNG)</small>
                        </div>

                        <div class="row">
                            <!-- Username -->
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">
                                    <i class="bi bi-person me-1"></i>Username
                                </label>
                                <input type="text" class="form-control" id="username" name="username" 
                                       value="<?= esc(session()->get('username')) ?>" required>
                                <small class="text-muted">Username for login</small>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope me-1"></i>Email Address
                                </label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= esc(session()->get('email') ?? '') ?>" required>
                                <small class="text-muted">Your email address</small>
                            </div>

                            <!-- Full Name -->
                            <div class="col-md-6 mb-3">
                                <label for="full_name" class="form-label">
                                    <i class="bi bi-card-text me-1"></i>Full Name
                                </label>
                                <input type="text" class="form-control" id="full_name" name="full_name" 
                                       value="<?= esc(session()->get('full_name') ?? '') ?>">
                                <small class="text-muted">Your complete name</small>
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">
                                    <i class="bi bi-telephone me-1"></i>Phone Number
                                </label>
                                <input type="text" class="form-control" id="phone" name="phone" 
                                       value="<?= esc(session()->get('phone') ?? '') ?>">
                                <small class="text-muted">Your contact number</small>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Password Section -->
                        <h6 class="mb-3">
                            <i class="bi bi-shield-lock me-2"></i>
                            Change Password
                        </h6>
                        <p class="text-muted small mb-3">Leave blank if you don't want to change your password</p>

                        <div class="row">
                            <!-- Current Password -->
                            <div class="col-md-12 mb-3">
                                <label for="current_password" class="form-label">
                                    <i class="bi bi-key me-1"></i>Current Password
                                </label>
                                <input type="password" class="form-control" id="current_password" name="current_password" 
                                       placeholder="Enter current password to change">
                            </div>

                            <!-- New Password -->
                            <div class="col-md-6 mb-3">
                                <label for="new_password" class="form-label">
                                    <i class="bi bi-lock me-1"></i>New Password
                                </label>
                                <input type="password" class="form-control" id="new_password" name="new_password" 
                                       placeholder="Enter new password">
                                <small class="text-muted">Min 6 characters</small>
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6 mb-3">
                                <label for="confirm_password" class="form-label">
                                    <i class="bi bi-lock-fill me-1"></i>Confirm New Password
                                </label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                       placeholder="Re-enter new password">
                                <small class="text-muted">Must match new password</small>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex gap-2 justify-content-end mt-4">
                            <a href="javascript:history.back()" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.user-avatar-large {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 2.5rem;
    box-shadow: 0 4px 16px rgba(59, 130, 246, 0.3);
    border: 4px solid #ffffff;
    object-fit: cover;
}

.avatar-upload-btn {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    cursor: pointer;
    border: 3px solid white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
}

.avatar-upload-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.5);
}

.avatar-upload-btn i {
    font-size: 1rem;
}
</style>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        const preview = document.getElementById('avatarPreview');
        
        reader.onload = function(e) {
            // Check if preview is img or div
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                // Replace div with img
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Profile';
                img.className = 'user-avatar-large';
                img.id = 'avatarPreview';
                preview.parentNode.replaceChild(img, preview);
            }
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
<?= $this->endSection(); ?>
