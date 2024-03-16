<?php

namespace controllers;

use PDOException;

class SessionManager
{
    public static function getUserPseudo()
    {
        // Assurez-vous que la session a déjà été démarrée
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifiez si l'utilisateur est connecté et si son pseudo est défini dans la session
        if (isset($_SESSION['user']) && isset($_SESSION['user']->pseudo)) {
            return $_SESSION['user']->pseudo;
        }

        return null; // Si l'utilisateur n'est pas connecté ou si le pseudo n'est pas défini
    }
}

?>