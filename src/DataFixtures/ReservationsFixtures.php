<?php

namespace App\DataFixtures;

use App\Entity\Guests;
use App\Entity\Reservations;
use App\Entity\Rooms;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ReservationsFixtures extends Fixture implements DependentFixtureInterface
{
    public final function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Charger les invités et les chambres existants
        $guests = $manager->getRepository(Guests::class)->findAll();
        $rooms = $manager->getRepository(Rooms::class)->findAll();

        // Vérifiez que des données existent pour les invités et les chambres
        if (empty($guests) || empty($rooms)) {
            throw new \RuntimeException('Assurez-vous d\'avoir des données pour Guests et Rooms avant de charger les Reservations.');
        }

        for ($i = 0; $i < 20; $i++) {
            $reservation = new Reservations();

            // Attribuer un invité aléatoire
            $guest = $faker->randomElement($guests);
            $reservation->setGuestId($guest);

            // Attribuer une ou plusieurs chambres
            $numRooms = $faker->numberBetween(1, 3);
            for ($j = 0; $j < $numRooms; $j++) {
                $room = $faker->randomElement($rooms);
                $reservation->addRoom($room);
            }

            // Générer des dates de réservation
            $startDate = $faker->dateTimeBetween('-1 year', '+1 month');
            $endDate = (clone $startDate)->modify('+' . $faker->numberBetween(1, 14) . ' days');
            $reservation->setStartDate(\DateTimeImmutable::createFromMutable($startDate));
            $reservation->setEndDate(\DateTimeImmutable::createFromMutable($endDate));

            // Générer le statut
            $reservation->setStatus($faker->randomElement(['confirmed', 'pending', 'cancelled']));

            // Ajouter les timestamps
            $now = new \DateTimeImmutable();
            $reservation->setCreatedAt($now);
            $reservation->setUpdatedAt($now);

            // Persister l'entité
            $manager->persist($reservation);
        }

        // Sauvegarder les données dans la base
        $manager->flush();
    }

    public final function getDependencies(): array
    {
        return [
            GuestsFixtures::class,
            RoomsFixtures::class,
        ];
    }
}
