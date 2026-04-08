<?php

namespace App\Controllers;

use App\Libraries\Session;
use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\QuestionModel;

class Connexion extends Controller
{
    public function index()
    {
        // Affiche le formulaire de connexion
        return view('connexion_form');
    }

    public function login()
    {
        // On récupère les données du formulaire : email + mot de passe
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $model = new UserModel();
        $user = $model->where('email', $email)->first();
        // If email not found, keep the existing generic error and also set a specific flash message
        if (!$user) {
            return redirect()->back()
                ->with('error', 'Identifiants invalides')
                ->with('unknown_email', "Votre mail {$email} n'est pas connu");
        }

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

    // Mot de passe oublié - étape 1 : demander l'email
    public function forgot()
    {
        return view('forgot_form');
    }

    // Mot de passe oublié - étape 2 : afficher la question associée à l'email
    public function askSecurity()
    {
        $email = $this->request->getPost('email');
        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', "Votre mail {$email} n'est pas connu");
        }

        if (empty($user['security_question_id']) || empty($user['security_answer'])) {
            return redirect()->back()->with('error', 'Aucune question de sécurité configurée pour ce compte.');
        }

        $qModel = new QuestionModel();
        $question = $qModel->find($user['security_question_id']);
        if (!$question) {
            return redirect()->back()->with('error', 'Question de sécurité introuvable.');
        }

        return view('security_question_form', ['email' => $email, 'question' => $question['question_text']]);
    }

    // Vérifier la réponse à la question de sécurité
    public function verifySecurity()
    {
        $email = $this->request->getPost('email');
        $answer = $this->request->getPost('security_answer');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();
        if (!$user) {
            return redirect()->to(site_url('Connexion/forgot'))->with('error', "Votre mail {$email} n'est pas connu");
        }

        if (empty($user['security_answer'])) {
            return redirect()->to(site_url('Connexion/forgot'))->with('error', 'Aucune réponse de sécurité enregistrée.');
        }

        if (password_verify($answer, $user['security_answer'])) {
            // autoriser reset de mot de passe
            return view('reset_password_form', ['email' => $email]);
        }

        return redirect()->back()->with('error', 'Réponse incorrecte');
    }

    // Mettre à jour le mot de passe après vérification
    public function resetPassword()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $password2 = $this->request->getPost('password_confirm');

        if ($password !== $password2) {
            return redirect()->back()->with('error', 'Les mots de passe ne correspondent pas.');
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();
        if (!$user) {
            return redirect()->to(site_url('Connexion/forgot'))->with('error', "Votre mail {$email} n'est pas connu");
        }

        $userModel->update($user['id'], ['password' => password_hash($password, PASSWORD_DEFAULT)]);
        return redirect()->to(site_url('Connexion'))->with('success', 'Mot de passe mis à jour. Vous pouvez vous connecter.');
    }
}
