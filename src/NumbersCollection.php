<?php

namespace MyTest;

use MyTest\PhoneNumber;

class NumbersCollection
{
    private array $numbers = [];

    public function getNumbers(): array
    {
        return $this->numbers;
    }
    
    public function addPhoneNumber(PhoneNumber $phoneNumber)
    {
        array_push($this->numbers, $phoneNumber);
    }

    public function deleteNumber(PhoneNumber $phoneNumber)
    {
        $index = array_search($phoneNumber->getNumber(), $this->numbers);
        if ($index != null) {
            unset($this->numbers[$index]);
        }
    }
}
