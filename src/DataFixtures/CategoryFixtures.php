<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Faker\CategoryProvider;

class CategoryFixtures extends Fixture
{


    public final function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        $faker->addProvider(new CategoryProvider($faker));

        // Création des catégories
        for ($i = 0; $i < 7; $i++) {
            $category = new Category();
            $category->setName($faker->category());
            $category->setDescription($faker->categoryDescription());

            $manager->persist($category);
        }

        $manager->flush();
    }
}