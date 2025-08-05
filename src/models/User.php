<?php
class User {
    public $name;
    public $email;
    public $birth_date;
    public $address;
    public $state;
    public $gender;
    public $interests; // array
    public $username;
    public $password;

    public function __construct($data) {
        $this->name       = htmlspecialchars($data['name']);
        $this->email      = htmlspecialchars($data['email']);
        $this->birth_date = htmlspecialchars($data['birth_date']);
        $this->address    = htmlspecialchars($data['address']);
        $this->state      = htmlspecialchars($data['state']);
        $this->gender     = htmlspecialchars($data['gender']);
        
        // interests could be an array made of strings
        $this->interests = array_map('htmlspecialchars', $data['interests'] ?? []);

        $this->username   = htmlspecialchars($data['username']);
        $this->password   = password_hash($data['password'], PASSWORD_DEFAULT);
    }
}
