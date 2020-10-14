<?php

namespace MyTest;

use JsonSerializable;

class PhoneNumber implements JsonSerializable
{
    private string $type;
    private string $number;
    private string $personId;

    // function __construct(string $type, int $number){
    //     $this->type = $type;
    //     $this->number = $number;
    // }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number)
    {
        $this->number = $number;
    }

    public function getPersonId(): string
    {
        return $this->personId;
    }

    public function setPersonId(string $personId)
    {
        $this->personId = $personId;
    }

    public function isObject(object $object): bool
    {
        if (is_string($object->type) && is_string($object->number)) {
            return true;
        }
        
        return false;
    }

    public function jsonSerialize()
    {
        return $this->number;
    }
}
