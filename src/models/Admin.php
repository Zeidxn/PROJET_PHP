<?php

class Admin extends User
{
    public function __construct($id, $email, $password, $firstname, $lastname, $old, $address, $phoneNumber)
    {
        parent::__construct($id, $email, $password, $firstname, $lastname, $old, $address, $phoneNumber);
    }



}