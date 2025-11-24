<?php

namespace App\Controllers;

use App\Libraries\Session;
use CodeIgniter\Controller;
use App\Models\ChambreModel;

class Home extends Controller
{
    public function index()
    {
        Session::startSession();

        if (!Session::verifySession()) {
            return redirect()->to(site_url('Connexion'));
        }

        $iduser = Session::getSessionData('idUser');
        $userAdmin = Session::getSessionData('userAdmin');

        // Récupère toutes les chambres
        $chambreModel = new ChambreModel();
        $chambres = $chambreModel->getAll();

        return view('pages/home', [
            'iduser' => $iduser,
            'userAdmin' => $userAdmin,
            'chambres' => $chambres
        ]);

    }
}
