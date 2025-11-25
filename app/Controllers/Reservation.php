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

        return view('reservation_form', ['chambre' => $chambre]);
    }

    // 🔹 Récupère les dates réservées pour une chambre (AJAX)
    public function getReservedDates($idChambre)
    {
        $resModel = new ReservationModel();
        // Get all reservations for this room
        $reservations = $resModel->where('Id_Chambre', $idChambre)->findAll();

        $reserved = [];
        foreach ($reservations as $res) {
            $start = new \DateTime($res['res_date_debut']);
            $end = new \DateTime($res['res_date_fin']);
            // Add all dates in range (inclusive)
            while ($start <= $end) {
                $reserved[] = $start->format('Y-m-d');
                $start->modify('+1 day');
            }
        }

        return $this->response->setJSON(['reserved' => array_values(array_unique($reserved))]);
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
            return redirect()->to(site_url('Connexion'))->with('error', 'Utilisateur introuvable');
        }

        $idChambre = $this->request->getPost('Id_Chambre');
        $nbPersonnes = $this->request->getPost('res_nb_personnes');
        $dateDebut = $this->request->getPost('res_date_debut');
        $dateFin = $this->request->getPost('res_date_fin');
        $resNum = uniqid('RES-');

        // 🔹 Insertion dans reserver
        $resModel->insert([
            'user_id' => $user['id'],
            'Id_Chambre' => $idChambre,
            'res_nb_personnes' => $nbPersonnes,
            'res_date_debut' => $dateDebut,
            'res_date_fin' => $dateFin,
            'res_duree' => '', // ou calculer la durée
            'res_date' => date('Y-m-d H:i:s'),
            'res_montant' => 0, // calculer si nécessaire
            'res_num' => $resNum
        ]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Merci de votre réservation',
                'res_num' => $resNum
            ]);
        }

        return redirect()->to(site_url('Home'))->with('success', 'Réservation effectuée !');
    }
}
