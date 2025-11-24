<?php

namespace App\Controllers;

use App\Libraries\Session;
use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\ReservationModel;
use App\Models\ChambreModel;

class Reservation extends Controller
{
    public function form($idChambre)
    {
        $chambreModel = new ChambreModel();
        $chambre = $chambreModel->find($idChambre);

        $data = ['chambre' => $chambre, 'title' => 'Réserver la chambre '.$chambre['ch_numero']];
        echo view('templates/header', $data);
        echo view('reservation_form', $data);
        echo view('templates/footer', $data);
    }

    public function submit()
    {
        // 🔹 Initialisation de la session
        $session = \Config\Services::session();

        $email = $session->get('userEmail'); // récupère l’email de l’utilisateur connecté

        $userModel = new UserModel();
        $resModel = new ReservationModel();

        // 🔹 Récupère l’utilisateur à partir de la table users
        $user = $userModel->where('email', $email)->first();
        if (!$user) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Utilisateur introuvable']);
            }
            return redirect()->to(site_url('Connexion'))->with('error', 'Utilisateur introuvable');
        }

        $idChambre = $this->request->getPost('Id_Chambre');
        $nbPersonnes = $this->request->getPost('res_nb_personnes');
        $dateDebut = $this->request->getPost('res_date_debut');
        $dateFin = $this->request->getPost('res_date_fin');

        // 🔹 Insertion dans reserver
        // Vérifier si une réservation identique existe déjà (même user, même chambre, mêmes dates)
        $existing = $resModel->where([
            'user_id' => $user['id'],
            'Id_Chambre' => $idChambre,
            'res_date_debut' => $dateDebut,
            'res_date_fin' => $dateFin
        ])->first();

        if ($existing) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Vous avez déjà réservé cette chambre pour ces dates']);
            }
            return redirect()->back()->with('error', 'Vous avez déjà réservé cette chambre pour ces dates');
        }

        $resModel->insert([
            'user_id' => $user['id'],
            'Id_Chambre' => $idChambre,
            'res_nb_personnes' => $nbPersonnes,
            'res_date_debut' => $dateDebut,
            'res_date_fin' => $dateFin,
            'res_duree' => '', // ou calculer la durée
            'res_date' => date('Y-m-d H:i:s'),
            'res_montant' => 0, // calculer si nécessaire
            'res_num' => uniqid('RES')
        ]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Merci de votre réservation']);
        }

        return redirect()->to(site_url('Home'))->with('success', 'Réservation effectuée !');
    }
}
