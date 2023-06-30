<?php
class Contact {
    private $id;
    private $name;
    private $email;
    private $phone;



    public function __construct($name, $email, $phone) {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
    }

    // Геттеры
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }

    // Сеттеры
    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }
}

?>