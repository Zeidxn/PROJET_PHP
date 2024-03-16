<?php

class Comment
{
    private $id;
    private $content;
    private $date;
    private $author;

    public function __construct($id, $content, $date, $author)
    {
        $this->id = $id;
        $this->content = $content;
        $this->date = date('Y-m-d');
        $this->author = $author;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getAuthor()
    {
        return $this->author->getFirstname() . ' ' . $this->author->getLastname();
    }

    // Setters
    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

}