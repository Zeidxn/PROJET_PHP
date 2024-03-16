<?php

namespace controllers;
use PDO;
use Post;

class PostController {
    private $db;

    public function __construct($db) {
        $this->db = $db;

    }

    public function createPost($title, $content, $isPublic, $likes, $dislikes, $imagedata, $owner)
    {
        try {

            $comments = [];
            $stmt = $this->db->prepare("INSERT INTO tn200843_PROJET.Post (title, content, date, isPublic, likes, dislikes, comment, imageData,owner) VALUES (?, ?, ?, ?, ?, ?, ?,?,?)");
            $stmt->execute([$title, $content, date('Y-m-d'), $isPublic, $likes, $dislikes, $comments, $imagedata,$owner]);
        } catch (PDOException $e) {
            // Gérer les erreurs
            header('Location: ' . '../views/error.php' . '?error=' . $e->getMessage());
        }
    }

     public function getPosts()
        {
            try {
                $stmt = $this->db->prepare("SELECT * FROM tn200843_PROJET.Post ORDER BY id DESC");
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // Gérer les erreurs
                header('Location: ' . '../views/error.php' . '?error=' . $e->getMessage());
                return [];
            }
        }

    public function getPostsPage($page, $postsPerPage)
    {
        try {
            $offset = ($page - 1) * $postsPerPage;
            $stmt = $this->db->prepare("SELECT * FROM tn200843_PROJET.Post ORDER BY id DESC LIMIT :limit OFFSET :offset");
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $postsPerPage, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Gérer les erreurs
            header('Location: ' . '../views/error.php' . '?error=' . $e->getMessage());
            return [];
        }
    }

    public function getPostCount()
    {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) AS count FROM tn200843_PROJET.Post");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $e) {
            // Gérer les erreurs
            header('Location: ' . '../views/error.php' . '?error=' . $e->getMessage());
            return 0;
        }
    }

    public function getPostsCountByUser($userId)
    {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM tn200843_PROJET.Post WHERE owner = ?");
            $stmt->execute([$userId]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            // Gérer les erreurs
            header('Location: ' . '../views/error.php' . '?error=' . $e->getMessage());
            return 0;
        }
    }






    public function getPostsByUser($userId, $page = 1, $postsPerPage = 10)
    {
        try {
            // Calculer l'offset en fonction de la page actuelle
            $offset = ($page - 1) * $postsPerPage;

            $offset = ($page - 1) * $postsPerPage;
            $stmt = $this->db->prepare("SELECT * FROM tn200843_PROJET.Post WHERE owner = :owner ORDER BY id DESC LIMIT :limit OFFSET :offset");
            $stmt->bindParam(':owner', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $postsPerPage, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Gérer les erreurs
            header('Location: ' . '../views/error.php' . '?error=' . $e->getMessage());
            return [];
        }
    }



    public function getLikesCount($postId) {
        $stmt = $this->db->prepare("SELECT COUNT(idUser) AS nbLikes FROM tn200843_PROJET.postLike WHERE idImage = ?");
        $stmt->execute([$postId]);
        $data= $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['nbLikes'];
    }
    public function getDislikesCount($postId) {
        $stmt = $this->db->prepare("SELECT COUNT(idUser) AS nbDislikes FROM tn200843_PROJET.postDisLike WHERE idImage = ?");
        $stmt->execute([$postId]);
        $data= $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['nbDislikes'];
    }


    public function likePost($postId, $userId) {
        $stmt = $this->db->prepare("SELECT COUNT(idUser) AS nbLikes FROM tn200843_PROJET.postLike WHERE idUser = ? AND idImage = ?");
        $stmt->execute([$userId, $postId]);
        $data= $stmt->fetch(PDO::FETCH_ASSOC);
        if($data['nbLikes'] > 0) {
            $stmt = $this->db->prepare("DELETE FROM tn200843_PROJET.postLike WHERE idUser = ? AND idImage = ?");
        }
        else {
            $stmt = $this->db->prepare("INSERT INTO tn200843_PROJET.postLike (idUser, idImage) VALUES (?, ?)");
        }
        $stmt->execute([$userId, $postId]);
    }

    public function userInLike($userId, $postId) {
        $stmt = $this->db->prepare("SELECT * FROM tn200843_PROJET.postLike WHERE idUser = ? AND idImage = ?");
        $stmt->execute([$userId, $postId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function userInDisLike($userId, $postId) {
        $stmt = $this->db->prepare("SELECT * FROM tn200843_PROJET.postDisLike WHERE idUser = ? AND idImage = ?");
        $stmt->execute([$userId, $postId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function dislikePost($postId, $userId) {
        $stmt = $this->db->prepare("SELECT COUNT(idUser) AS nbDislikes FROM tn200843_PROJET.postDisLike WHERE idUser = ? AND idImage = ?");
        $stmt->execute([$userId, $postId]);
        $data= $stmt->fetch(PDO::FETCH_ASSOC);
        if($data['nbDislikes'] > 0) {
            $stmt = $this->db->prepare("DELETE FROM tn200843_PROJET.postDisLike WHERE idUser = ? AND idImage = ?");
        }
        else {
            $stmt = $this->db->prepare("INSERT INTO tn200843_PROJET.postDisLike (idUser, idImage) VALUES (?, ?)");
        }
        $stmt->execute([$userId, $postId]);
    }

    public function deletePost($postId) {
        $stmt = $this->db->prepare("DELETE FROM tn200843_PROJET.Post WHERE id = ?");
        $stmt->execute([$postId]);
    }

    public function commentPost($postId, $userId, $comment) {
        $stmt = $this->db->prepare("INSERT INTO tn200843_PROJET.postComment (content, date, userId,postId) VALUES (?, ?, ?, ?)");
        $stmt->execute([$comment,date('Y-m-d'),$userId,$postId]);
    }

    public function getUserName($userId) {
        $stmt = $this->db->prepare("SELECT pseudo FROM tn200843_PROJET.User WHERE id = ?");
        $stmt->execute([$userId]);
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        return $result['pseudo'];

    }

    public function getComments($postId) {
        $stmt = $this->db->prepare("SELECT * FROM tn200843_PROJET.postComment WHERE postId = ?");
        $stmt->execute([$postId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPostInfo($postId)
    {
        $stmt = $this->db->prepare("SELECT * FROM tn200843_PROJET.Post WHERE id = ?");
        $stmt->execute([$postId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePost($postId,$title, $content, $imagedata)
    {
        try {
            $stmt = $this->db->prepare("UPDATE tn200843_PROJET.Post SET title = ?, content = ?, imageData = ? WHERE id = ?");
            $stmt->execute([$title, $content, $imagedata, $postId]);
        } catch (PDOException $e) {
            // Gérer les erreurs
            header('Location: ' . '../views/error.php' . '?error=' . $e->getMessage());
        }
    }



}