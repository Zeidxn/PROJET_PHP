<?php

namespace controllers;


require 'PHPMailer.php';
require 'Exception.php';
use PDOException;
use PDO;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;



class AdminController {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getMembers(){
        $stmt = $this->db->prepare("SELECT * FROM tn200843_PROJET.User ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getUserById($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM tn200843_PROJET.User WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function sendEmail($to, $subject, $message)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'linserv-info-01.campus.unice.fr';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'tn200843';
            $mail->Password   = 'Sd89ox25&*';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('nicolas.toupin411@gmail.com', 'Nicolas Toupin');
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

if (isset($_POST['sendEmailToSelected'])) {
    $db = include('../config.php');
    $adminController = new AdminController($db);
    $adminController->sendEmail($_POST['selectedUser'], $_POST['emailSubject'], $_POST['emailMessage']);
    header('Location: ' . '../views/manageUser.php');
}
?>
