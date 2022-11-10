<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Car;
use App\Entity\CarCategory;


class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {

        $generator = Factory::create("fr_FR");

        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
            $car = new Car();
            $car->setName($generator->word() . ' car');
            $car->setCost(mt_rand(10000, 100000));
            $car->setNbDoors(mt_rand(4, 5));
            $car->setNbSeats(mt_rand(2, 8));
            $manager->persist($car);
        }

        // create 20 products! Bam!
        for ($i = 0; $i < 3; $i++) {
            $CarCategory = new CarCategory();
            $CarCategory->setName($generator->word() . ' category');
            $manager->persist($CarCategory);
        }
        

        $manager->flush();
    }
}
