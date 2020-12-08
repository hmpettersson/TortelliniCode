<?php

//declare(strict_types=1);

use MyTest\Person;
use MyTest\Address;
use MyTest\NumbersCollection;
use MyTest\PhoneNumber;
use MyTest\PersonMapper;
use MyTest\Request;
use MyTest\Router;

$jsonFile = file_get_contents("https://tools.learningcontainer.com/sample-json.json");
$respons = json_decode($jsonFile);
//die($respons->address->streetAddress); test och avslut av program

$address = new Address(
    $respons->address->streetAddress,
    $respons->address->city,
    $respons->address->state,
    $respons->address->postalCode
);
$collectionOfNumbers = new NumbersCollection();
foreach ($respons->phoneNumbers as $phoneNumber) {
    $phoneNoObj = new PhoneNumber();
    $phoneNoObj->setType($phoneNumber->type);
    $phoneNoObj->setNumber($phoneNumber->number);
    $collectionOfNumbers->addPhoneNumber($phoneNoObj);
}

$person = new Person(
    $respons->firstName,
    $respons->lastName,
    $respons->gender,
    $respons->age,
    $address,
    $collectionOfNumbers
);

$address2 = new Address('Happy Street', 'Fun City', 'Wonder Land', '43884');
$phoneNo2 = new PhoneNumber();
$phoneNo2->setType('home');
$phoneNo2->setNumber('35827499');
$numbersCollection2 = new NumbersCollection();
$numbersCollection2->addPhoneNumber($phoneNo2);
//$person2 = new Person('Wonder', 'Woman', 'woman', 85, $address2, $numbersCollection2);
//var_dump($person2);

//$personMapper = new PersonMapper();
//$personMapper->addPerson($person);
//$personMapper->addPerson($person2);

//$retreivedPersons = $personMapper->findAllPersons();
//var_dump($retreivedPersons);
//exit;

//$retreivedPersonsAsJson = json_encode($retreivedPersons, JSON_PRETTY_PRINT);
//header('Content-Type: application/json');
//echo $retreivedPersonsAsJson;

// $onePerson = $personMapper->getPersonById('44');
// $onePersonAsJson = json_encode($onePerson, JSON_PRETTY_PRINT);
//echo $onePersonAsJson;

$router = new Router(new Request);

$router->get('/persons', function () {
    $persMapper = new PersonMapper();
    $result = json_encode($persMapper->findAllPersons(), JSON_PRETTY_PRINT);
    return $result;
});


$router->get('/persons/single', function (Request $request) {
    $idParam = $request->getQueryString('id');
    $persMapper = new PersonMapper();
    $resultsAsJason = json_encode($persMapper->getPersonById($idParam), JSON_PRETTY_PRINT);
    return $resultsAsJason;
});

/*$router->post('/data', function ($request) {
    return json_encode($request->getBody());
});*/

echo PHP_EOL;
