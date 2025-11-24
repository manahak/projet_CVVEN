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
}
