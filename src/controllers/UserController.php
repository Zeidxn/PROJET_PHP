<?php

namespace controllers;

use PDO;
use PDOException;
use Post;
use User;
include(__DIR__ . '/../config.php');

class UserController {
    private $currentUser;
    private $db;

    public function __construct($db) {
        $this->currentUser = null;
        $this->db = $db;

    }

    public function viewProfile() {
        $this->currentUser-$this->viewProfile();
    }

    public function editProfile($firstname, $lastname, $age, $address, $phoneNumber) {
        $this->currentUser->editProfile($firstname, $lastname, $age, $address, $phoneNumber);
    }

    public function createPost($title, $content, $isPublic) {
        $postId = rand(0, 1000);
        $date = date('Y-m-d');

        $this->currentUser->addPost($postId, $title, $content, $this->currentUser, $isPublic, 0, 0, [], $date);

    }



    public function editPost($postId, $title, $content, $isPublic) {
        $this->currentUser->editPost($postId, $title, $content, $isPublic);
    }

    public function deletePost($postId) {
        $this->currentUser->removePost($postId);
    }




}
