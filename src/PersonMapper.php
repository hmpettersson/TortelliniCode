<?php

namespace MyTest;

use ArrayObject;
use PDO;
use PDOException;
use MyTest\Person;
use MyTest\DbConnection;
use MyTest\Address;
use MyTest\NumbersCollection;
use MyTest\PhoneNumber;

class PersonMapper extends ArrayObject
{
    public function addPerson(Person $newPerson)
    {
        try {
            $connection = new DbConnection();
            $dB = $connection->Open();

            $firstName = $newPerson->getFirstName();
            $lastName = $newPerson->getLastName();
            $gender = $newPerson->getGender();
            $age = $newPerson->getAge();
            $streetAddress = $newPerson->getAddress()->getStreetAddress();
            $city = $newPerson->getAddress()->getCity();
            $state = $newPerson->getAddress()->getState();
            $postalCode = $newPerson->getAddress()->getPostalCode();
            $phoneNoCollection = $newPerson->getPhoneNumbers();
            
            $sql = $dB->prepare(
                "INSERT INTO Person(
                    `first_name`, `last_name`, gender, age, street_address, city, `state`,postal_code
                ) VALUES (
                    :firstName, :lastName, :gender, :age, :streetAddress, :city, :state, :postalCode
                )"
            );

            $sql->bindParam(':firstName', $firstName);
            $sql->bindParam(':lastName', $lastName);
            $sql->bindParam(':gender', $gender);
            $sql->bindParam(':age', $age);
            $sql->bindParam(':streetAddress', $streetAddress);
            $sql->bindParam(':city', $city);
            $sql->bindParam(':state', $state);
            $sql->bindParam(':postalCode', $postalCode);

            $sql->execute();
            $lastId = $dB->lastInsertId();
            $id = (int)$lastId;

            foreach ($phoneNoCollection->getNumbers() as $phoneNo) {
                $type = $phoneNo->getType();
                $number = $phoneNo->getNumber();

                $sql2 = $dB->prepare("INSERT INTO Phone_Number(`type`, `number`, person_id) 
                    VALUES (:type, :number, :person_id)");

                $sql2->bindParam(':type', $type);
                $sql2->bindParam(':number', $number);
                $sql2->bindParam(':person_id', $id);
                $sql2->execute();
            }
            $connection->close();
        } catch (PDOException $e) {
            echo $e->getMessage();
            $connection->close();
        }
    }

    public function findAllPersons(): array
    {
        try {
            $connection = new DbConnection();
            $dB = $connection->Open();
            $sql = $dB->prepare("SELECT * FROM Person");
            $sql->setFetchMode(PDO::FETCH_OBJ);
            $sql->execute();
            $result = $sql->fetchAll();
            $connection->close();
 
            $resultArray = [];

            foreach ($result as $result2) {
                $dB = $connection->Open();
                $personId = (int)$result2->id;

                $sql2 = $dB->prepare("SELECT * FROM Phone_Number WHERE person_id = :personId");
                $sql2->bindParam(':personId', $personId);
                $sql->setFetchMode(PDO::FETCH_OBJ);
                $sql2->execute();
                $numberResults = $sql2->fetchAll();

                $noCollection = new NumbersCollection();
                
                foreach ($numberResults as $entity) {
                    $phoneNo = new PhoneNumber();
                    $phoneNo->setType($entity['type']);
                    $phoneNo->setNumber($entity['number']);
                    $phoneNo->setPersonId($entity['person_id']);
                    $noCollection->addPhoneNumber($phoneNo);
                }

                $address = new Address(
                    $result2->street_address,
                    $result2->city,
                    $result2->state,
                    $result2->postal_code
                );
                $person = new Person(
                    $result2->first_name,
                    $result2->last_name,
                    $result2->gender,
                    $result2->age,
                    $address,
                    $noCollection
                );
                $person->setId($personId);
                array_push($resultArray, $person);
                $connection->close();
            }
            return $resultArray;
        } catch (PDOException $e) {
            echo $e->getMessage();
            $connection->close();
            return $resultArray;
        }
    }
}
