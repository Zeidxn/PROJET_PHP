<?php

namespace controllers;

use PDOException;

class AuthenController
{

    private static $userLogged;
    private $db;
    private $isLogged = false;


    public function __construct($db) {
        $this->db = $db;

    }


    public function isLoggedIn()
    {
        return $this->isLogged;
    }

    public function setLogged($isLogged)
    {
        $this->isLogged = $isLogged;
    }
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            try {
                $stmt = $this->db->prepare("SELECT * FROM tn200843_PROJET.User WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch();


                if ($user && password_verify($password, $user['password'])) {
                    session_start();
                    $_SESSION['user'] = $user;
                    $_SESSION['userId'] = $user['id'];
                    $this->setLogged(true);
                    if (strcasecmp($user['email'], "admin@gmail.com") === 0) {
                        header('Location: ' . 'views/admin.php');
                    } else {
                        header('Location: ' . 'views/home_logged.php');
                    }
                } else {
                    include 'views/error.php';

                }
            } catch (PDOException $e) {
                // Gérer les erreurs
                header('Location: ' . '../views/error.php' . '?error=' . $e->getMessage());
            }
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? null;
            $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
            $pseudo = $_POST['pseudo'] ?? null;
            $firstname = $_POST['firstname'] ?? null;
            $lastname = $_POST['lastname'] ?? null;
            $age = $_POST['age'] ?? null;
            $address = $_POST['address'] ?? null;
            $phoneNumber = $_POST['phoneNumber'] ?? null;
            $role = 1;

            try {
                $stmt = $this->db->prepare("INSERT INTO tn200843_PROJET.User (pseudo,email, password, firstname, lastname, age, address, phoneNumber,role) VALUES ( ?,?, ?, ?, ?, ?, ?, ?,?)");
                $stmt->execute([$pseudo,$email, $password, $firstname, $lastname, $age, $address, $phoneNumber,$role]);
                header('Location: ' . 'views/login.php');


            } catch (PDOException $e) {
                // Gérer les erreurs
                //header('Location: ' . 'views/error.php' . '?error=' . $e->getMessage());
            }
        }
    }

    public function logout()
    {
        session_destroy();
        $this->setLogged(false);


        include '../views/home.php';
    }

}