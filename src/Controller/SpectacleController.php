<?php

namespace App\Controller;

use App\Entity\Spectacle;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/spectacle")
 */
class SpectacleController extends AbstractController
{
    /**
     * @Route("/shows/city/{city}", name="browse_show")
     */
    public function browseShowByCity(string $city, EntityManager $em)
    {
        $shows = $em->getRepository(Spectacle::class)->findBy(['city' => $city]);

        return $this->render('spectacle/browse.html.twig', [
            'shows' => $shows
            ]
        );
    }

    /**
     * @Route("/book/{id}", name="book_show")
     */
    public function booking()
    {
        return $this->render('spectacle/book.html.twig');
    }
}
