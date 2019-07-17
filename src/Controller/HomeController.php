<?php

namespace App\Controller;

use App\Entity\Spectacle;
use App\Form\CityFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {
        $citySearch = $this->createForm(CityFormType::class);

        $citySearch->handleRequest($request);

        if ($citySearch->isSubmitted() && $citySearch->isValid()) {
            $city = $citySearch->get('search')->getData();

            return $this->redirectToRoute('browse_show', ['city' => $city]);
        }
        $shows = $this->getDoctrine()->getRepository(Spectacle::class)->findAll();

        return $this->render('home/index.html.twig', [
            'shows' => $shows,
            'search' => $citySearch->createView()
        ]);
    }
}
