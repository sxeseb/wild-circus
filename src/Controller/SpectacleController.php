<?php

namespace App\Controller;

use App\Entity\Spectacle;
use App\Form\CityFormType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/spectacle")
 */
class SpectacleController extends AbstractController
{
    /**
     * @Route("/shows/city/{city}", name="browse_show")
     */
    public function browseShowByCity(Request $request, ObjectManager $em, string $city = null)
    {
        if ($city != null) {
            $shows = $em->getRepository(Spectacle::class)->findBy(['city' => $city]);
        } else {
            $shows = $em->getRepository(Spectacle::class)->findAll();
        }

        $citySearch = $this->createForm(CityFormType::class);

        $citySearch->handleRequest($request);

        if ($citySearch->isSubmitted() && $citySearch->isValid()) {
            $city = $citySearch->get('search')->getData();

            return $this->redirectToRoute('browse_show', ['city' => $city]);
        }

        return $this->render('spectacle/browse.html.twig', [
                'shows' => $shows,
                'city' => $city,
                'search' => $citySearch->createView()
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
