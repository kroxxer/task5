<?php

namespace App\Service;

use App\Entity\Person;
use App\Entity\Region;
use Faker\Factory;
use Faker\Generator;

class PersonFactory
{
    private static int $id;
    private Generator $faker;

    private int $errorsAmount;

    public function __construct()
    {
        $this->faker = Factory::create();
        self::$id = 1;
        $this->errorsAmount = 0;
    }

    public function createMany(int $amount, int $seed = 1000, int $errorsAmount = 0, string $region = Region::USA->value) : array
    {
        self::$id = 1;

        $this->faker = Factory::create($region);
        $this->faker->seed($seed);
        $this->errorsAmount = $errorsAmount;
        $persons = array();

        for ($i = 0; $i < $amount; $i++, self::$id++)
            $persons[] = self::createPerson();
        return $persons;
    }

    public function updateMany (int $amount): array
    {
        $persons = array();
        for ($i = 0; $i < $amount; $i++, self::$id++)
            $persons[] = $this->createPerson();
        return $persons;
    }

    private function createPerson() : Person
    {
        $person = new Person();
        $person->setId(self::$id);
        $person->setName($this->faker->name());
        $person->setIdentity($this->faker->uuid());
        $person->setAddress($this->faker->address());
        $person->setPhoneNumber($this->faker->phoneNumber());
        return $person;
    }

    private function errorsString(array $persons) : void
    {

    }
}