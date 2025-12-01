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

    public function chambresAdd()
    {
        Session::startSession();
        if (!Session::verifySession() || Session::getSessionData('userAdmin') != 1) {
            return redirect()->to(site_url('Connexion/deconnexion'));
        }

        $chambreModel = new \App\Models\ChambreModel();

        if ($this->request->getMethod() === 'post') {
            $data = [
                'ch_numero' => $this->request->getPost('ch_numero'),
                'ch_capacite' => $this->request->getPost('ch_capacite'),
                'ch_prix' => $this->request->getPost('ch_prix'),
                'ch_description' => $this->request->getPost('ch_description'),
            ];

            $validation = \Config\Services::validation();
            $validation->setRules([
                'ch_numero' => 'required',
                'ch_capacite' => 'required|integer',
                'ch_prix' => 'required|numeric',
            ]);

            if ($validation->run($data)) {
                $chambreModel->insert($data);
                session()->setFlashdata('success', 'Chambre ajoutée.');
                return redirect()->to(site_url('PageAdmin/chambres'));
            } else {
                $errors = $validation->getErrors();
                return view('admin/chambre_form', ['errors' => $errors, 'chambre' => $data, 'mode' => 'add']);
            }
        }

        return view('admin/chambre_form', ['mode' => 'add']);
    }

    public function chambresEdit($id = null)
    {
        Session::startSession();
        if (!Session::verifySession() || Session::getSessionData('userAdmin') != 1) {
            return redirect()->to(site_url('Connexion/deconnexion'));
        }

        $chambreModel = new \App\Models\ChambreModel();
        $chambre = $chambreModel->find($id);
        if (!$chambre) {
            session()->setFlashdata('error', 'Chambre introuvable.');
            return redirect()->to(site_url('PageAdmin/chambres'));
        }

        if ($this->request->getMethod() === 'post') {
            $data = [
                'ch_numero' => $this->request->getPost('ch_numero'),
                'ch_capacite' => $this->request->getPost('ch_capacite'),
                'ch_prix' => $this->request->getPost('ch_prix'),
                'ch_description' => $this->request->getPost('ch_description'),
            ];

            $validation = \Config\Services::validation();
            $validation->setRules([
                'ch_numero' => 'required',
                'ch_capacite' => 'required|integer',
                'ch_prix' => 'required|numeric',
            ]);

            if ($validation->run($data)) {
                $chambreModel->update($id, $data);
                session()->setFlashdata('success', 'Chambre modifiée.');
                return redirect()->to(site_url('PageAdmin/chambres'));
            } else {
                $errors = $validation->getErrors();
                return view('admin/chambre_form', ['errors' => $errors, 'chambre' => array_merge($chambre, $data), 'mode' => 'edit']);
            }
        }

        return view('admin/chambre_form', ['chambre' => $chambre, 'mode' => 'edit']);
    }

    public function chambresDelete($id = null)
    {
        Session::startSession();
        if (!Session::verifySession() || Session::getSessionData('userAdmin') != 1) {
            return redirect()->to(site_url('Connexion/deconnexion'));
        }

        $chambreModel = new \App\Models\ChambreModel();
        if ($id && $chambreModel->find($id)) {
            $chambreModel->delete($id);
            session()->setFlashdata('success', 'Chambre supprimée.');
        } else {
            session()->setFlashdata('error', 'Chambre introuvable.');
        }

        return redirect()->to(site_url('PageAdmin/chambres'));
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

    public function reservationView($resNum = null)
    {
        Session::startSession();
        if (!Session::verifySession() || Session::getSessionData('userAdmin') != 1) {
            return redirect()->to(site_url('Connexion/deconnexion'));
        }

        $resModel = new \App\Models\ReservationModel();
        $reservation = $resModel->where('res_num', $resNum)->first();
        if (!$reservation) {
            session()->setFlashdata('error', 'Réservation introuvable.');
            return redirect()->to(site_url('PageAdmin/reservations'));
        }

        return view('admin/reservation_view', ['r' => $reservation]);
    }

    public function reservationCancel($resNum = null)
    {
        Session::startSession();
        if (!Session::verifySession() || Session::getSessionData('userAdmin') != 1) {
            return redirect()->to(site_url('Connexion/deconnexion'));
        }

        $resModel = new \App\Models\ReservationModel();
        $reservation = $resModel->where('res_num', $resNum)->first();
        if (!$reservation) {
            session()->setFlashdata('error', 'Réservation introuvable.');
            return redirect()->to(site_url('PageAdmin/reservations'));
        }

        // delete by res_num
        $resModel->where('res_num', $resNum)->delete();
        session()->setFlashdata('success', 'Réservation annulée.');
        return redirect()->to(site_url('PageAdmin/reservations'));
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

    public function usersEdit($id = null)
    {
        Session::startSession();
        if (!Session::verifySession() || Session::getSessionData('userAdmin') != 1) {
            return redirect()->to(site_url('Connexion/deconnexion'));
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($id);
        if (!$user) {
            session()->setFlashdata('error', 'Utilisateur introuvable.');
            return redirect()->to(site_url('PageAdmin/users'));
        }

        if ($this->request->getMethod() === 'post') {
            $data = [
                'nom' => $this->request->getPost('nom'),
                'prenom' => $this->request->getPost('prenom'),
                'email' => $this->request->getPost('email'),
                'userAdmin' => $this->request->getPost('userAdmin') ? 1 : 0,
            ];

            $validation = \Config\Services::validation();
            $validation->setRules([
                'nom' => 'required',
                'email' => 'required|valid_email',
            ]);

            if ($validation->run($data)) {
                // Prevent removing last admin
                if (isset($user['userAdmin']) && $user['userAdmin'] == 1 && $data['userAdmin'] == 0) {
                    // count other admins
                    $count = $userModel->where('userAdmin', 1)->countAllResults();
                    if ($count <= 1) {
                        session()->setFlashdata('error', 'Impossible de retirer le dernier administrateur.');
                        return redirect()->to(site_url('PageAdmin/users'));
                    }
                }

                $userModel->update($id, $data);
                session()->setFlashdata('success', 'Utilisateur mis à jour.');
                return redirect()->to(site_url('PageAdmin/users'));
            } else {
                $errors = $validation->getErrors();
                return view('admin/user_form', ['errors' => $errors, 'user' => array_merge($user, $data)]);
            }
        }

        return view('admin/user_form', ['user' => $user]);
    }

    public function usersDelete($id = null)
    {
        Session::startSession();
        if (!Session::verifySession() || Session::getSessionData('userAdmin') != 1) {
            return redirect()->to(site_url('Connexion/deconnexion'));
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($id);
        if (!$user) {
            session()->setFlashdata('error', 'Utilisateur introuvable.');
            return redirect()->to(site_url('PageAdmin/users'));
        }

        // Prevent deleting last admin
        if (!empty($user['userAdmin'])) {
            $count = $userModel->where('userAdmin', 1)->countAllResults();
            if ($count <= 1) {
                session()->setFlashdata('error', 'Impossible de supprimer le dernier administrateur.');
                return redirect()->to(site_url('PageAdmin/users'));
            }
        }

        $userModel->delete($id);
        session()->setFlashdata('success', 'Utilisateur supprimé.');
        return redirect()->to(site_url('PageAdmin/users'));
    }

    public function usersAdd()
    {
        Session::startSession();
        if (!Session::verifySession() || Session::getSessionData('userAdmin') != 1) {
            return redirect()->to(site_url('Connexion/deconnexion'));
        }

        $userModel = new \App\Models\UserModel();

        if ($this->request->getMethod() === 'post') {
            $data = [
                'nom' => $this->request->getPost('nom'),
                'prenom' => $this->request->getPost('prenom'),
                'email' => $this->request->getPost('email'),
                'userAdmin' => $this->request->getPost('userAdmin') ? 1 : 0,
            ];

            $password = $this->request->getPost('password');

            $validation = \Config\Services::validation();
            $validation->setRules([
                'nom' => 'required',
                'email' => 'required|valid_email',
                'password' => 'required|min_length[6]'
            ]);

            if ($validation->run(array_merge($data, ['password' => $password]))) {
                // check duplicate email
                if ($userModel->where('email', $data['email'])->first()) {
                    session()->setFlashdata('error', 'Un utilisateur avec cet email existe déjà.');
                    return view('admin/user_form', ['user' => $data, 'mode' => 'add', 'errors' => ['email' => 'Email déjà utilisé']]);
                }

                $data['password'] = password_hash($password, PASSWORD_DEFAULT);
                $userModel->insert($data);
                session()->setFlashdata('success', 'Utilisateur ajouté.');
                return redirect()->to(site_url('PageAdmin/users'));
            } else {
                $errors = $validation->getErrors();
                return view('admin/user_form', ['errors' => $errors, 'user' => $data, 'mode' => 'add']);
            }
        }

        return view('admin/user_form', ['mode' => 'add']);
    }
}
