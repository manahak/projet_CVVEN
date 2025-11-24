<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
// ClientModel not used in this controller; removed to avoid missing-class issues

class Inscription extends Controller
{
    public function index()
    {
        $data = ['title' => 'Inscription'];
        echo view('templates/header', $data);
        echo view('inscription_form', $data);
        echo view('templates/footer', $data);
    }

    public function register()
    {
        $nom = $this->request->getPost('cl_nom');
        $prenom = $this->request->getPost('cl_prenom');
        $email = $this->request->getPost('cl_mail');
        $password = $this->request->getPost('password');

    $userModel = new UserModel();

        if ($userModel->where('email', $email)->first()) {
            return redirect()->back()->with('error', 'Email déjà utilisé');
        }

        // Création dans users
        $userModel->insert([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'userAdmin' => 0
        ]);


        // Plus besoin, les infos sont déjà dans users


        return redirect()->to(site_url('Connexion'))->with('success', 'Compte créé avec succès !');
    }
}
