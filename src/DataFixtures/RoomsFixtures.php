<?php

namespace App\DataFixtures;

use App\Entity\Reviews;
use App\Entity\RoomImage;
use App\Entity\Rooms;
use App\Faker\CategoryProvider;
use App\Faker\ReviewProvider;
use App\Faker\RoomProvider;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RoomsFixtures extends Fixture implements DependentFixtureInterface
{


    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly UserRepository $userRepository)
    {}



    public final function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $fakerReview = Factory::create('fr_FR');
        $faker->addProvider(new RoomProvider($faker));
        $fakerReview->addProvider(new ReviewProvider($faker));

        $categories = $this->categoryRepository->findAll();
        $users = $this->userRepository->findAll();

        if (empty($categories)) {
            throw new \RuntimeException('Aucune catégorie trouvée. Veuillez les créer avant d’exécuter les fixtures.');
        }


        for ($i = 0; $i < 30; $i++) {
            // Création de la chambre
            $room = new Rooms();
            $room->setName($faker->roomName())
                ->setDescription($faker->roomDescription())
                ->setPricePerNight($faker->randomFloat(2, 50, 500))
                ->setCapacity($faker->numberBetween(1, 6))
                ->setAdress($faker->streetAddress())
                ->setCity($faker->city())
                ->setZipdCode($faker->postcode())
                ->setCategory($faker->randomElement($categories))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());


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
            for ($k = 0; $k < $faker->numberBetween(1, 5); $k++) {
                $review = new Reviews();
                $review->setRoomId($room)
                    ->setComment($fakerReview->reviewDescription())
                    ->setRating($faker->numberBetween(1, 5))
                    ->setUser($faker->randomElement($users))
                    ->setCreatedAt(new \DateTimeImmutable());

                $manager->persist($review);
            }


            $manager->persist($room);
        }

        $manager->flush();
    }

    public final function getDependencies(): array
    {
        return [
            UserFixtures::class
        ];
    }

}
