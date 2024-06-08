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
            $persons[] = self::createPerson();
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

    private function errorsString(array $persons) : void
    {

    }
}