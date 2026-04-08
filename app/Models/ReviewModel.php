<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'Id_Chambre', 'rating', 'comment', 'stay_start', 'stay_end', 'created_at'
    ];

    public function getByChambre($idChambre)
    {
        return $this->where('Id_Chambre', $idChambre)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
