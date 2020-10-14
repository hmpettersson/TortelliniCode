<?php

namespace MyTest;

use JsonSerializable;
use MyTest\Address;
use MyTest\NumbersCollection;

class Person implements JsonSerializable
{
    private string $firstName;
    private string $lastName;
    private string $gender;
    private int $age;
    private Address $address;
    private NumbersCollection $phoneNumbers;
    private string $id = '0';

    public function __construct(
        string $firstName,
        string $lastName,
        string $gender,
        int $age,
        Address $address,
        NumbersCollection $phoneNumbers
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gender = $gender;
        $this->age = $age;
        $this->address = $address;
        $this->phoneNumbers = $phoneNumbers;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender)
    {
        $this->gender = $gender;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age)
    {
        $this->gender = $age;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address)
    {
        $this->address = $address;
    }

    public function getPhoneNumbers(): NumbersCollection
    {
        return $this->phoneNumbers;
    }

    public function setPhoneNumbers(NumbersCollection $phoneNumbers)
    {
        $this->phoneNumbers = $phoneNumbers;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }
    
    public function jsonSerialize()
    {
        return [
            'name'=>$this->firstName . " " . $this->lastName,
            'address'=>$this->address,
            'phoneNumber'=>$this->phoneNumbers->getNumbers(),
        ];
    }
}
