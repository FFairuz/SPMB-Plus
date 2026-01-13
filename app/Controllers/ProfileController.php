<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ProfileController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new \App\Models\User();
    }

    public function edit()
    {
        // Check if user is logged in
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/auth/login')->with('error', 'Please login first');
        }

        $data = [
            'title' => 'Edit Profile - PPDB System',
        ];

        return view('profile/edit', $data);
    }

    public function update()
    {
        // Check if user is logged in
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/auth/login')->with('error', 'Please login first');
        }

        $userId = session()->get('user_id');
        
        // Validation rules
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email',
            'full_name' => 'permit_empty|max_length[100]',
            'phone' => 'permit_empty|max_length[20]',
        ];

        // Add profile picture validation if uploaded
        $profilePicture = $this->request->getFile('profile_picture');
        if ($profilePicture && $profilePicture->isValid()) {
            $rules['profile_picture'] = 'uploaded[profile_picture]|max_size[profile_picture,2048]|is_image[profile_picture]|mime_in[profile_picture,image/jpg,image/jpeg,image/png]';
        }

        // If password is being changed, add password validation
        if ($this->request->getPost('current_password')) {
            $rules['current_password'] = 'required';
            $rules['new_password'] = 'required|min_length[6]';
            $rules['confirm_password'] = 'required|matches[new_password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Please check your input. ' . implode(' ', $this->validator->getErrors()));
        }

        // Get current user data
        $currentUser = $this->userModel->find($userId);
        if (!$currentUser) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Prepare update data
        $updateData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'full_name' => $this->request->getPost('full_name'),
            'phone' => $this->request->getPost('phone'),
        ];

        // Handle profile picture upload
        if ($profilePicture && $profilePicture->isValid() && !$profilePicture->hasMoved()) {
            // Create upload directory if not exists
            $uploadPath = FCPATH . 'uploads/profiles/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Generate unique filename
            $newName = 'profile_' . $userId . '_' . time() . '.' . $profilePicture->getExtension();
            
            // Delete old profile picture if exists
            if (!empty($currentUser['profile_picture']) && file_exists($uploadPath . $currentUser['profile_picture'])) {
                @unlink($uploadPath . $currentUser['profile_picture']);
            }

            // Move uploaded file
            try {
                $profilePicture->move($uploadPath, $newName);
                $updateData['profile_picture'] = $newName;
            } catch (\Exception $e) {
                log_message('error', 'Profile picture upload error: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'Failed to upload profile picture');
            }
        }

        // Handle password change
        if ($this->request->getPost('current_password')) {
            // Verify current password
            if (!password_verify($this->request->getPost('current_password'), $currentUser['password'])) {
                return redirect()->back()->withInput()->with('error', 'Current password is incorrect');
            }

            // Hash new password
            $updateData['password'] = password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT);
        }

        // Update user data
        try {
            $this->userModel->update($userId, $updateData);

            // Update session data
            $sessionData = [
                'username' => $updateData['username'],
                'email' => $updateData['email'],
                'full_name' => $updateData['full_name'] ?? '',
                'phone' => $updateData['phone'] ?? '',
            ];
            
            // Add profile picture to session if uploaded
            if (isset($updateData['profile_picture'])) {
                $sessionData['profile_picture'] = $updateData['profile_picture'];
            }
            
            session()->set($sessionData);

            return redirect()->back()->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            log_message('error', 'Profile update error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to update profile. Username or email might already exist.');
        }
    }
}
