<?php
namespace App\Libraries;

use CodeIgniter\Session\Session as CISession;

class Session
{
    public static function startSession()
    {
        $session = session(); // démarre la session automatiquement
        return $session;
    }

    public static function verifySession(): bool
    {
        $session = session();
        return $session->has('idUser');
    }

    public static function getSessionData($key)
    {
        $session = session();
        return $session->get($key);
    }

    public static function setSessionData($key, $value)
    {
        $session = session();
        $session->set($key, $value);
    }

    public static function destroySession()
    {
        $session = session();
        $session->destroy();
    }
}
