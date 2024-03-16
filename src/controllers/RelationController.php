<?php

namespace controllers;

class RelationController
{
    private $db;

    public function __construct($db) {
        $this->db = $db;

    }

    public function addFriend($userId, $id) {
        $stmt = $this->db->prepare("INSERT INTO tn200843_PROJET.relation (idEnvoyant, idRecevant, statut) VALUES (?, ?, 'attente')");
        $stmt->execute([$userId, $id]);
    }


    public function deleteFriend($userId, $id){
        $stmt = $this->db->prepare("DELETE FROM tn200843_PROJET.relation WHERE idEnvoyant = ? AND idRecevant = ?");
        $stmt->execute([$userId, $id]);
    }

    public function showUsers(){
        $stmt = $this->db->prepare("SELECT * FROM tn200843_PROJET.User");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getFollowers($userId){
        $stmt = $this->db->prepare("SELECT u.id, u.pseudo, u.email ,r.* FROM tn200843_PROJET.relation r
                               JOIN tn200843_PROJET.User u ON r.idEnvoyant = u.id
                               WHERE r.idRecevant = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getRequests($userId){
        $stmt = $this->db->prepare("SELECT u.id, u.pseudo, u.email ,r.* FROM tn200843_PROJET.relation r
                               JOIN tn200843_PROJET.User u ON r.idRecevant = u.id
                               WHERE r.idEnvoyant = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function isFriend($userId, $id)
    {
        $stmt = $this->db->prepare("SELECT statut FROM tn200843_PROJET.relation WHERE idRecevant = ? AND idEnvoyant = ?");
        $stmt->execute([$id, $userId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return ($result !== false) ? $result['statut'] : null;

    }

    public function getUser($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM tn200843_PROJET.User WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getNbFriends($userId){
        $stmt = $this->db->prepare("SELECT COUNT(statut) AS nbFriends FROM tn200843_PROJET.relation WHERE idEnvoyant = ? AND statut = 'amis' OR idRecevant = ? AND statut = 'amis'");
        $stmt->execute([$userId,$userId]);
        $data= $stmt->fetch(\PDO::FETCH_ASSOC);
        return $data['nbFriends'];
    }

    public function getFriends($userId) {
        $stmt = $this->db->prepare("SELECT DISTINCT u.id, u.pseudo, u.email, r.* FROM tn200843_PROJET.relation r
                           JOIN tn200843_PROJET.User u ON (r.idEnvoyant = u.id OR r.idRecevant = u.id)
                           WHERE ((r.idRecevant = ? AND r.statut = 'amis' AND r.idEnvoyant != ?) 
                              OR (r.idEnvoyant = ? AND r.statut = 'amis' AND r.idRecevant != ?))
                              AND u.id != ?");
        $stmt->execute([$userId, $userId, $userId, $userId, $userId]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }




}


$db = include('../config.php');

$relationController = new RelationController($db);
if (isset($_POST['deleteFriend'])) {
    session_start();
    $userId = $_SESSION['userId'];
    $id = $_POST['userId'];
    $relationController->deleteFriend($userId, $id);
    $relationController->deleteFriend($id,$userId);

    header("Location: ../views/home_logged.php");
    exit();
}

if (isset($_POST['addFriend'])) {
    session_start();
    $userId = $_SESSION['userId'];
    $id = $_POST['userId'];
    $relationController->addFriend($userId, $id);
    header("Location: ../views/home_logged.php");
    exit();
}

if(isset($_POST['cancelFriend'])){
    session_start();
    $userId = $_SESSION['userId'];
    $id = $_POST['userId'];
    $relationController->deleteFriend($id,$userId);
    $relationController->deleteFriend($userId,$id);
    $_SESSION['relationStatus'] = $relationController->isFriend($userId, $id);
    header("Location: ../views/home_logged.php");
    exit();

}

if(isset($_POST['acceptFriend'])){
    session_start();
    $userId = $_SESSION['userId'];
    $id = $_POST['userId'];
    $stmt = $db->prepare("UPDATE tn200843_PROJET.relation SET statut = ? WHERE idEnvoyant = ? AND idRecevant = ?");
    $stmt->execute(["amis",$id,$userId]);
    header("Location: ../views/home_logged.php");
}

if(isset($_POST['refuseFriend'])){
    session_start();
    $userId = $_SESSION['userId'];
    $id = $_POST['userId'];
    $relationController->deleteFriend($id,$userId);
    $relationController->deleteFriend($userId,$id);
    header("Location: ../views/home_logged.php");
}