<?php

namespace App\Controllers;

use App\Models\User;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    // Handle the login form submission
    public function authenticate()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]',
        ];


        if (!$this->validate($rules)) {
            return redirect()->to('/login')->withInput()->with('validation', $this->validator);
        }

        $userModel = new User();
        $user = $userModel->where('email', $this->request->getVar('email'))->first();

        if ($user && password_verify($this->request->getVar('password'), $user['password'])) {
            // Set session data
            session()->set([
                'user_id' => $user['id'],
                'email' => $user['email'],
                'name' => $user['name'],
                'is_logged_in' => true, 
            ]);

            return redirect()->to('/dashboard');
        }

        return redirect()->to('/login')->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        $session = session();
        $session->destroy();

        return redirect()->to('/login')->with('message', 'You have been logged out successfully.');

    }
}
