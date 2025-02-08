<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{


    public final function load(ObjectManager $manager): void
    {

        $faker = Factory::create();


        $categories = [
            'Mer',
            'Montagne',
            'Neige',
            'Soleil',
            'Balade',
            'Campagne',
            'Urbain'
        ];

        foreach ($categories as $categoryName) {
            $category = new Category();
            $category->setName($categoryName)
                     ->setDescription($faker->paragraph());

            $manager->persist($category);
        }

        $manager->flush();
    }
}