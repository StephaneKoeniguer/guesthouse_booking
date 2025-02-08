<?php

namespace App\DataFixtures;

use App\Entity\Reviews;
use App\Entity\RoomImage;
use App\Entity\Rooms;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RoomsFixtures extends Fixture
{


    public function __construct(private readonly CategoryRepository $categoryRepository){}



    public final function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $categories = $this->categoryRepository->findAll();

        if (empty($categories)) {
            throw new \RuntimeException('Aucune catégorie trouvée. Veuillez les créer avant d’exécuter les fixtures.');
        }


        for ($i = 0; $i < 10; $i++) {
            // Création de la chambre
            $room = new Rooms();
            $room->setName('Room ' . $i + 1)
                ->setDescription($faker->paragraph())
                ->setPricePerNight($faker->randomFloat(2, 50, 500))
                ->setCapacity($faker->numberBetween(1, 6))
                ->setAdress($faker->streetAddress())
                ->setCity($faker->city())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());

            // Associer une catégorie aléatoire à la chambre
            $randomCategory = $faker->randomElement($categories);
            $room->setCategory($randomCategory);

            // Création des images associées
            for ($j = 0; $j < $faker->numberBetween(1, 5); $j++) {
                $randomNumber = $faker->numberBetween(1, 50);
                $roomImage = new RoomImage();
                $roomImage->setRoomId($room)
                    ->setImageUrl("https://picsum.photos/800/450?random=$randomNumber")
                    ->setCreatedAt(new \DateTimeImmutable());

                $manager->persist($roomImage);
            }

            // Création des avis associés
            for ($k = 0; $k < $faker->numberBetween(1, 3); $k++) {
                $review = new Reviews();
                $review->setRoomId($room)
                    ->setComment($faker->sentence())
                    ->setRating($faker->numberBetween(1, 5))
                    ->setCreatedAt(new \DateTimeImmutable());

                $manager->persist($review);
            }



            $manager->persist($room);
        }

        $manager->flush();
    }

}
