<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\UserModel;
use CodeIgniter\Controller;

class RegisterController extends Controller
{
    // Show the registration form
    public function index()
    {
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
            'confirm_password' => 'required|matches[password]',  // Ensure it matches the password field
            'position' => 'required|min_length[3]|max_length[50]', // Position field
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
            'position' => $this->request->getVar('position'),  // Added position field
            'image_profile' => $this->uploadProfileImage(),
        ];

        // Check if data is correct before saving to database (for debugging purposes)
        echo '<pre>';
        print_r($data);
        echo '</pre>';

        // Save user to the database
        if ($userModel->save($data)) {
            // Redirect to login page after successful registration
            return redirect()->to('/login')->with('message', 'Registration successful. Please log in.');
        } else {
            // If saving fails, print the error messages
            echo '<pre>';
            print_r($userModel->errors());
            echo '</pre>';
            exit;
        }
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
