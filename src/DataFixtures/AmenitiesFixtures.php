<?php

namespace App\DataFixtures;

use App\Entity\Amenities;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AmenitiesFixtures extends Fixture
{
    public final function load(ObjectManager $manager): void
    {
        $amenitiesNames = [
            'Piscine',
            'Wi-Fi',
            'Climatisation',
            'Barbecue',
            'Terrasse',
            'Sauna',
            'Parking privé',
            'Salle de sport',
            'Jacuzzi',
        ];

        foreach ($amenitiesNames as $name) {
            $amenity = new Amenities();
            $amenity->setName($name);

            $manager->persist($amenity);
        }

        $manager->flush();

    }

}
