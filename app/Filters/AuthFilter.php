<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Utilise la session native pour éviter les problèmes si ta lib Session n'est pas chargée
        $session = \Config\Services::session();

        // Log pour débug (regarde le fichier de log dans writable/logs)
        error_log('AuthFilter avant exécuté : idUser=' . ($session->get('idUser') ?? 'NULL'));

        if (!$session->get('idUser')) {
            // redirection automatique vers la page de connexion (aucun message flash pour forcer)
            return redirect()->to(site_url('Connexion'));
        }

        // si connecté => laisse passer (retourne null)
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // rien à faire après
    }
}




