<?php

namespace App\DataFixtures;

use App\Entity\Price;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $prices = [
            ['adults', 8, 10],
            ['children', 4, 5],
            ['group', 6, 7],
            ['school group', 50, 50]
        ];
        foreach ($prices as $price) {
            $prix = new Price();
            $prix->setName($price[0]);
            $prix->setPriceWeek($price[1]);
            $prix->setPriceWeekEnd($price[2]);
            $manager->persist($prix);
        }

        $manager->flush();
    }
}
