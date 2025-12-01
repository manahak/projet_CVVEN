<?php

namespace App\Controllers;

use App\Libraries\Session;
use CodeIgniter\Controller;

class PageAdmin extends Controller
{
    public function index()
    {
        Session::startSession();

        if (!Session::verifySession() || Session::getSessionData('userAdmin') != 1) {
            return redirect()->to(site_url('Connexion/deconnexion'));
        }

        return view('admin_page');
    }

    public function chambres()
    {
        Session::startSession();
        if (!Session::verifySession() || Session::getSessionData('userAdmin') != 1) {
            return redirect()->to(site_url('Connexion/deconnexion'));
        }

        $chambreModel = new \App\Models\ChambreModel();
        $chambres = $chambreModel->getAll();

        return view('admin/chambres', ['chambres' => $chambres]);
    }

    public function reservations()
    {
        Session::startSession();
        if (!Session::verifySession() || Session::getSessionData('userAdmin') != 1) {
            return redirect()->to(site_url('Connexion/deconnexion'));
        }

        $resModel = new \App\Models\ReservationModel();
        $reservations = $resModel->getReservations();

        return view('admin/reservations', ['reservations' => $reservations]);
    }

    public function users()
    {
        Session::startSession();
        if (!Session::verifySession() || Session::getSessionData('userAdmin') != 1) {
            return redirect()->to(site_url('Connexion/deconnexion'));
        }

        $userModel = new \App\Models\UserModel();
        $users = $userModel->findAll();

        return view('admin/users', ['users' => $users]);
    }
}
