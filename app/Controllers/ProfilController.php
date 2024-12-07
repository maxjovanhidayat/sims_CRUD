<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Produk;
use App\Models\User;
use CodeIgniter\Controller;

class ProfilController extends Controller
{
    public function index()
    {
        $session = session();

        // Check if the user is logged in
        if (!$session->get('user_id')) {
            return redirect()->to('/login')->with('message', 'You need to log in first.');
        }

        // Get the user ID from the session
        $id = $session->get('user_id');

        // Create an instance of the User model
        $model = new User();

        // Fetch user details based on the user ID
        $user_detail = $model->where('id', $id)->first(); // Use 'first()' to get a single row

        // Check if the user is found
        if (!$user_detail) {
            return redirect()->to('/login')->with('message', 'User not found.');
        }
        $data['user'] = $user_detail;
        // Pass the user details to the view (example)
        // return view('user_profile', ['user' => $user_detail]);
        return view('layouts', [
            'content' => view('user_profile', $data)
        ]);
    }

}