<?php
class Deal {
    private $contact;
    private $price;

    // Конструктор
    public function __construct(Contact $contact, $price) {
        $this->contact = $contact;
        $this->price = $price;
    }

    // Геттеры и сеттеры...

    // Геттер для контакта
    public function getContact() {
        return $this->contact;
    }

    // Сеттер для контакта
    public function setContact(Contact $contact) {
        $this->contact = $contact;
    }

    // Геттер для цены
    public function getPrice() {
        return $this->price;
    }

    // Сеттер для цены
    public function setPrice($price) {
        $this->price = $price;
    }
}
?>