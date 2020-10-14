<?php

namespace MyTest;

use JsonSerializable;

class Address implements JsonSerializable
{
    private string $streetAddress;
    private string $city;
    private string $state;
    private int $postalCode;

    public function __construct(string $streetAddress, string $city, string $state, int $postalCode)
    {
        $this->streetAddress = $streetAddress;
        $this->city = $city;
        $this->state = $state;
        $this->postalCode = $postalCode;
    }

    public function getStreetAddress(): string
    {
        return $this->streetAddress;
    }

    public function setStreetAddress(string $streetAddress)
    {
        $this->streetAddress = $streetAddress;
    }

    public function getCity(): string
    {
        return $this-> city;
    }

    public function setCity(string $city)
    {
        $this->city = $city;
    }

    public function getState(): string
    {
        return $this-> state;
    }
    
    public function setState(string $state)
    {
        $this->state = $state;
    }

    public function getPostalCode(): int
    {
        return $this-> postalCode;
    }

    public function setPostalCode(string $postalCode)
    {
        $this->postalCode = $postalCode;
    }

    public function jsonSerialize()
    {
        return [
            'address'=>$this->streetAddress . ", " . $this->city . ", " .
            $this->state . ", " . $this->postalCode ,
        ];
    }
}
