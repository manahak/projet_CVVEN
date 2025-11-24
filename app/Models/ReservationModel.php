<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservationModel extends Model
{
    protected $table = 'reserver';
    protected $primaryKey = ['Id_Client', 'Id_Chambre'];
    protected $allowedFields = [
        'Id_Client', 'Id_Chambre', 'res_nb_personnes', 'res_date_debut',
        'res_date_fin', 'res_duree', 'res_date', 'res_montant', 'res_num'
    ];

    public function getReservations()
    {
        return $this->select('reserver.*, Client.cl_nom, Client.cl_prenom, Client.cl_mail, Chambre.ch_numero, Chambre.ch_capacite, Chambre.ch_prix, Chambre.ch_description')
                    ->join('Client', 'Client.Id_Client = reserver.Id_Client')
                    ->join('Chambre', 'Chambre.Id_Chambre = reserver.Id_Chambre')
                    ->findAll();
    }
}
