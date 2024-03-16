<?php

class Post
{
    private $id;
    private $title;
    private $content;
    private $date;
    private $owner;// User
    private $isPublic;
    private $likes=0;
    private $dislikes=0;
    private $comments= [];
    private $image;



    public function __construct($id, $title, $content, $author, $isPublic, $likes, $dislikes, $image, $owner)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->date = date('Y-m-d');
        $this->author = $author;
        $this->isPublic = $isPublic;
        $this->likes = $likes;
        $this->dislikes = $dislikes;
        $this->comments = [];
        $this->image=image;
        $this->owner=$owner;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getImage(){
        return $this->image;
    }
    public function getContent()
    {
        return $this->content;
    }

    public function getDate()
    {
        return $this->date;
    }

       public function getOwner(){
        return $this->owner;
       }


    public function getIsPublic()
    {
        return $this->isPublic;
    }

    public function getLikes()
    {
        return $this->likes;
    }

    public function getDislikes()
    {
        return $this->dislikes;
    }

    public function getComments()
    {
        return $this->comments;
    }

    // Setters

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;
    }

    public function setLikes()
    {
        $this->likes++;
    }

    public function setDislikes()
    {
        $this->dislikes++;
    }

    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    // Methods

    public function addComment($commentId, $content, $date, $author)
    {
        $comment = new Comment($commentId, $content, $date, $author);
        $this->comments[] = $comment;
    }

    public function removeComment($commentId)
    {
        foreach ($this->comments as $key => $comment) {
            if ($comment->getId() == $commentId) {
                unset($this->comments[$key]);
            }
        }
    }


    public function like()
    {
        $this->likes++;
    }

    public function dislike()
    {
        $this->dislikes++;
    }



}