<?php

namespace App\Controllers;

use App\Libraries\Session;
use CodeIgniter\Controller;
use App\Models\UserModel;

class Connexion extends Controller
{
    public function index()
    {
        // Affiche le formulaire de connexion avec template global
        $data = ['title' => 'Connexion'];
        echo view('templates/header', $data);
        echo view('connexion_form', $data);
        echo view('templates/footer', $data);
    }

    public function login()
    {
        // On récupère les données du formulaire : email + mot de passe
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $model = new UserModel();
        $user = $model->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Connexion réussie : on démarre la session
            Session::startSession();
            Session::setSessionData('idUser', $user['id']);
            Session::setSessionData('userAdmin', $user['userAdmin']);
            Session::setSessionData('userEmail', $user['email']); // utile pour associer à Client

            return redirect()->to(site_url('Home'));
        } else {
            // Échec de la connexion
            return redirect()->back()->with('error', 'Identifiants invalides');
        }
    }

    public function deconnexion()
    {
        Session::destroySession();
        return redirect()->to(site_url('Connexion'));
    }
}
