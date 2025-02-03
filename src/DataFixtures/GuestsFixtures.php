<?php

namespace App\DataFixtures;

use App\Entity\Guests;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GuestsFixtures extends Fixture
{
    const GUEST_REFERENCE = 'guest_';

    public final function load(ObjectManager $manager): void
    {
        $guestsData = [
            ['email' => 'john.doe@example.com', 'firstName' => 'John', 'lastName' => 'Doe', 'phone' => '1234567890'],
            ['email' => 'jane.smith@example.com', 'firstName' => 'Jane', 'lastName' => 'Smith', 'phone' => '9876543210'],
            ['email' => 'alice.wonder@example.com', 'firstName' => 'Alice', 'lastName' => 'Wonder', 'phone' => '4561237890'],
            ['email' => 'bob.builder@example.com', 'firstName' => 'Bob', 'lastName' => 'Builder', 'phone' => null],
            ['email' => 'charlie.brown@example.com', 'firstName' => 'Charlie', 'lastName' => 'Brown', 'phone' => '7418529630'],
        ];

        foreach ($guestsData as $index => $data) {
            $guest = new Guests();
            $guest->setEmail($data['email'])
                ->setFirstName($data['firstName'])
                ->setLastName($data['lastName'])
                ->setPhone($data['phone'])
                ->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($guest);

            $this->addReference(self::GUEST_REFERENCE . $index, $guest);
        }

        $manager->flush();
    }
}
