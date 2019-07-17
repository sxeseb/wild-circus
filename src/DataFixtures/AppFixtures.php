<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\Price;
use App\Entity\Spectacle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        function randomDateInRange(\DateTime $start, \DateTime $end) {
            $randomTimestamp = mt_rand($start->getTimestamp(), $end->getTimestamp());
            $randomDate = new \DateTime();
            $randomDate->setTimestamp($randomTimestamp);
            return $randomDate;
        }

        // $product = new Product();
        // $manager->persist($product);
        $prices = [
            ['adults', 8, false ],
            ['adults', 10, true],
            ['children', 4, false],
            ['children', 5, true],
            ['group', 6, false],
            ['school group', 50, false],
            ['school group', 50, true]
        ];
        foreach ($prices as $price) {
            $prix = new Price();
            $prix->setName($price[0]);
            $prix->setPrice($price[1]);
            $prix->setWeekend($price[2]);
            $manager->persist($prix);
        }

        $events = ['the super magic show', 'the crazy (nice) clowns attack !', 'tiger magic'];
        $cities = ['Strasbourg', 'Bordeaux', 'Paris', 'Marseille', 'London', 'Koln', 'Dusseldorf'];
        $location = ['1, Main Square', '1, place Centrale', '1 hauptcentrumplatz'];
        $images = [
            '/assets/img/home/clowns.jpg',
            '/assets/img/home/magic.jpg',
            ];

        $start = new \DateTime('2019-08-01');
        $end= new \DateTime('2020-06-01');

        for ($i = 0; $i <= 15; $i++) {
            $show = new Spectacle();
            $show->setCity($cities[array_rand($cities, 1)]);
            $show->setLocation($location[array_rand($location, 1)]);
            $show->setName($events[array_rand($events, 1)]);
            $img = new Image();
            $img->setName($show->getName());
            $img->setSrc($images[array_rand($images, 1)]);
            $show->addImage($img);
            $show->setSeats(rand(100, 250));
            $show->setDate(randomDateInRange($start, $end));

            $manager->persist($img);
            $manager->persist($show);
        }

        $manager->flush();
    }
}
