<?php

class User
{
    private $id;
    private $email;
    private $password;

    private $firstname;
    private $lastname;
    private $old;
    private $address;
    private $phoneNumber;

    private $role;

    public [] $posts;

    public function __construct($id, $email, $password, $firstname, $lastname, $old, $address, $phoneNumber)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;

        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->old = $old;
        $this->address = $address;
        $this->phoneNumber = $phoneNumber;
        $this->role = 1;// 1 = user, 2 = admin
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getOld()
    {
        return $this->old;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function getPosts()
    {
        return $this->posts;
    }

    public function getRole()
    {
        return $this->role;
    }

    // Setters

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function setOld($old)
    {
        $this->old = $old;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    //Methods


    public function addPost($postId, $title, $content, $author, $isPublic, $likes, $dislikes, $comments)
    {
        $post = new Post($postId, $title, $content, $author, $isPublic, $likes, $dislikes, $comments);
        $this->posts[] = $post;
    }

    public function removePost($postId)
    {
        foreach ($this->posts as $key => $post) {
            if ($post->getId() == $postId) {
                unset($this->posts[$key]);
            }
        }
    }

    public function editPost($postId, $title, $content, $isPublic)
    {
        foreach ($this->posts as $key => $post) {
            if ($post->getId() == $postId) {
                $post->setTitle($title);
                $post->setContent($content);
                $post->setAuthor($this);
                $post->setIsPublic($isPublic);
                break;
            }
        }
    }

    public function viewProfile()
    {
        return [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'old' => $this->old,
            'address' => $this->address,
            'phoneNumber' => $this->phoneNumber,
        ];
    }

    public function editProfile($firstname, $lastname, $old, $address, $phoneNumber)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->old = $old;
        $this->address = $address;
        $this->phoneNumber = $phoneNumber;
    }


}