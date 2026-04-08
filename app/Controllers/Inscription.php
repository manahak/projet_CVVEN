<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\ClientModel;

class Inscription extends Controller
{
    public function index()
    {
        // fournir les questions de sécurité au formulaire
        $qModel = new \App\Models\QuestionModel();
        $questions = $qModel->findAll();
        return view('inscription_form', ['questions' => $questions]);
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

        // Récupérer question de sécurité et réponse
        $security_question_id = $this->request->getPost('security_question_id');
        $security_answer = $this->request->getPost('security_answer');

        // Hacher la réponse de sécurité si fournie
        $security_answer_hash = null;
        if (!empty($security_answer)) {
            $security_answer_hash = password_hash($security_answer, PASSWORD_DEFAULT);
        }

        // Si une question a été choisie, la réponse est requise
        if (!empty($security_question_id) && empty($security_answer)) {
            return redirect()->back()->with('error', 'Vous avez choisi une question de sécurité, merci de fournir une réponse.');
        }

        // Création dans users
        $userModel->insert([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'userAdmin' => 0,
            'security_question_id' => $security_question_id ?: null,
            'security_answer' => $security_answer_hash
        ]);


        // Plus besoin, les infos sont déjà dans users


        return redirect()->to(site_url('Connexion'))->with('success', 'Compte créé avec succès !');
    }
}
