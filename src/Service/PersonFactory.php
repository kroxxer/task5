<?php

namespace App\Service;

use App\Entity\Person;
use App\Entity\Region;
use Faker\Factory;
use Faker\Generator;

class PersonFactory
{
    private int $id;
    private Generator $faker;

    private int $errorsAmount;

    public function __construct()
    {
        $this->id = 1;
        $this->errorsAmount = 0;
    }

    public function createMany(int $amount, int $id = 1, int $seed = 1000, int $errorsAmount = 0, string $region = Region::USA->value) : array
    {
        $this->faker = Factory::create($region);
        $this->id = $id;
        $this->faker->seed($seed);
        $this->errorsAmount = $errorsAmount;
        $persons = array();
        for ($i = 0; $i < $amount; $i++, $this->id++)
        {
            $person = $this->createPerson();
            $this->errorsPerson($person);
            $persons[] = $person;
        }
        return $persons;
    }

    private function createPerson() : Person
    {
        $person = new Person();
        $person->setId($this->id);
        $person->setName($this->faker->name());
        $person->setIdentity($this->faker->uuid());
        $person->setAddress($this->faker->numberBetween(0, 1) ?
                            implode(separator: ',',
                                    array: [
                                    $this->faker->city(),
                                    $this->faker->streetAddress(),
                                    ])
                            :
                            implode(separator: ',',
                                    array: [
                                        $this->faker->address(),
                                        $this->faker->numberBetween(1,100)
                                    ])
        );
        $person->setPhoneNumber($this->faker->phoneNumber());
        return $person;
    }

    private function errorsPerson(Person $person) : void
    {
        for ($i = 0; $i < $this->errorsAmount; $i++)
        {
            switch ($this->faker->numberBetween(1, 3))
            {
                case 1:
                    $person->setName($this->errorString($person->getName()));
                    break;
                case 2:
                    $person->setAddress($this->errorString($person->getAddress()));
                    break;
                case 3:
                    $person->setPhoneNumber($this->errorString($person->getPhoneNumber()));
                    break;
            }
        }
    }
    private function errorString(string $personInfo) : string
    {
        switch ($this->faker->numberBetween(1,3))
        {
            case 1:
                $deleteIndex = $this->faker->numberBetween(0, mb_strlen($personInfo) - 1);
                return mb_substr($personInfo, 0, $deleteIndex) . mb_substr($personInfo, $deleteIndex + 1);
            case 2:
                $addIndex = $this->faker->numberBetween(0, mb_strlen($personInfo) - 1);
                return mb_substr($personInfo, 0, $addIndex) . $this->faker->randomLetter() . mb_substr($personInfo, $addIndex);
            case 3:
                $swapIndex = $this->faker->numberBetween(1, mb_strlen($personInfo) - 2);
                $result = "";
                switch( $this->faker->randomElement([-1,1]) )
                {
                    case 1:
                        $result = mb_substr($personInfo, 0, $swapIndex) . mb_substr($personInfo, $swapIndex + 1, 1) .
                                    mb_substr($personInfo, $swapIndex, 1) . mb_substr($personInfo, $swapIndex + 2);
                        break;
                    case -1:
                        $result = mb_substr($personInfo, 0, $swapIndex - 1) . mb_substr($personInfo, $swapIndex, 1) .
                                    mb_substr($personInfo, $swapIndex -1, 1) . mb_substr($personInfo, $swapIndex + 1);
                        break;
                }

                return $result;
            default:
                return "Error";
        }
    }
}