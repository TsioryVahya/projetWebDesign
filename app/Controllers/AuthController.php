<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/admin/dashboard');
        }
        
        $this->data['title'] = 'Connexion - BackOffice';
        return view('admin/login', $this->data);
    }

    public function attemptLogin()
    {
        $session = session();
        $model = new UserModel();
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cas spécial pour admin/admin123 comme demandé (ou via DB)
        if (($username === 'admin' && $password === 'admin123') || $model->authenticate($username, $password)) {
            $session->set([
                'username'   => $username,
                'isLoggedIn' => true
            ]);
            return redirect()->to('/admin/dashboard');
        }

        return redirect()->back()->with('error', 'Identifiants invalides.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
