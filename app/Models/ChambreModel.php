<?php

namespace App\Models;

use CodeIgniter\Model;

class ChambreModel extends Model
{
    protected $table = 'Chambre';
    protected $primaryKey = 'Id_Chambre';
    protected $allowedFields = ['ch_numero', 'ch_capacite', 'ch_prix', 'ch_description'];

    public function getAll()
    {
        return $this->findAll();
    }
}
