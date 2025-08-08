<?php
class User
{
    public $name;
    public $email;
    public $birth_date;
    public $address;
    public $state;
    public $gender;
    public $interests; 
    public $username;
    public $photo;
    public $password;

    public function __construct($data)
    {
        $this->name       = htmlspecialchars(trim($data['name']));
        $this->email      = htmlspecialchars(trim($data['email']));
        $this->birth_date = htmlspecialchars($data['birth_date']);
        $this->address    = htmlspecialchars(trim($data['address']));
        $this->state      = htmlspecialchars($data['state']);
        $this->gender     = htmlspecialchars($data['gender']);

        $this->interests = array_map('htmlspecialchars', $data['interests'] ?? []);

        $this->username   = htmlspecialchars(trim($data['username']));

        // Só fazer hash da senha se ela foi fornecida (para updates opcionais)
        if (isset($data['password']) && !empty($data['password'])) {
            $this->password = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            // Para updates, pode manter a senha atual se não foi fornecida uma nova
            $this->password = isset($data['current_password']) ? $data['current_password'] : '';
        }

        $this->photo = isset($data['photo']) ? $data['photo'] : '';
    }
}
