<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservationModel extends Model
{
    protected $table = 'reserver';
    protected $primaryKey = ['user_id', 'Id_Chambre'];
    protected $allowedFields = [
        'user_id', 'Id_Chambre', 'res_nb_personnes', 'res_date_debut',
        'res_date_fin', 'res_duree', 'res_date', 'res_montant', 'res_num'
    ];

    public function getReservations()
    {
        return $this->select('reserver.*, users.nom AS cl_nom, users.prenom AS cl_prenom, users.email AS cl_mail, Chambre.ch_numero, Chambre.ch_capacite, Chambre.ch_prix, Chambre.ch_description')
                    ->join('users', 'users.id = reserver.user_id')
                    ->join('Chambre', 'Chambre.Id_Chambre = reserver.Id_Chambre')
                    ->findAll();
    }
}
