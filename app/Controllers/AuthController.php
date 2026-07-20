<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login()
    {
        return view('auth/login');
    }

    public function attempt()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('username', $username)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Username atau password salah');
        }

        // Simpan data user ke session
        session()->set([
            'user_id' => $user['id'],
            'nama' => $user['nama'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to('/')->with('success', 'Login berhasil');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login')->with('success', 'Anda telah logout');
    }
}