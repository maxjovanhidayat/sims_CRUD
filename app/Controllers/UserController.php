<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    public function index()
    {
        $model = new User();
        $data['users'] = $model->findAll();
        // return view('user_view', $data);

        return view('register');
    }

    // Handle the registration form submission
    public function register()
    {
        // Load validation service
        $validation = \Config\Services::validation();

        // Validate the form input
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]|max_length[255]',
            'confirm_password' => 'required|matches[password]',
            'image_profile' => 'permit_empty|is_image[image_profile]|max_size[image_profile,1024]',
        ];

        if (!$this->validate($rules)) {
            // Validation failed, return to form with errors
            return view('register', [
                'validation' => $this->validator
            ]);
        }

        // Validation passed, process the data
        $userModel = new User();

        // Get input data
        $data = [
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'image_profile' => $this->uploadProfileImage(),
        ];

        // Save user to the database
        $userModel->save($data);

        // Redirect to login page or show success message
        return redirect()->to('/login')->with('message', 'Registration successful. Please log in.');
    }

    // Upload the profile image if exists
    private function uploadProfileImage()
    {
        // Check if there’s an uploaded file
        if ($this->request->getFile('image_profile')->isValid()) {
            $image = $this->request->getFile('image_profile');
            $newName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads/profile_images', $newName);

            return 'uploads/profile_images/' . $newName;
        }

        return null; // No image uploaded
    }
}
