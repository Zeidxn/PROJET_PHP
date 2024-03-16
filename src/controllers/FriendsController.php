<?php

use controllers\RelationController;


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'])) {
    session_start();
    $userId = $_SESSION['userId'];
    $id = $_POST['userId'];

    $db = include('../config.php');
    include('RelationController.php');
    $relationController = new RelationController($db);
    header
    exit();
}