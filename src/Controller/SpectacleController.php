<?php

namespace App\Controller;

use App\Entity\Price;
use App\Entity\Spectacle;
use App\Entity\Ticket;
use App\Form\CityFormType;
use App\Form\TicketType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/spectacle")
 */
class SpectacleController extends AbstractController
{
    /**
     * @Route("/shows/city/{city}", name="browse_show")
     */
    public function browseShows(Request $request, ObjectManager $em, string $city = null)
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
    public function booking(Spectacle $spectacle, Request $request, ObjectManager $objectManager, Session $session)
    {
        $weekend = ['Sun', 'Sat', 'Fri'];
        if (in_array($spectacle->getDate()->format('D'), $weekend)) {
            $prices = $objectManager->getRepository(Price::class)->findBy(['weekend' => true]);
        } else {
            $prices = $objectManager->getRepository(Price::class)->findBy(['weekend' => false]);
        }

        $ticketForm = $this->createForm(TicketType::class, null, ['prices' => $prices]);

        $ticketForm->handleRequest($request);


        if ($ticketForm->isSubmitted() && $ticketForm->isValid()) {
            $quantity = $ticketForm->get('quantity')->getData();
            $priceObj = $ticketForm->get('price')->getData();
            $price = $quantity * $priceObj->getPrice();
            $type = $priceObj->getName();

            $cart = $session->get('cart', []);

            $ticket = new Ticket();
            $ticket->setPrice($priceObj);
            $ticket->setQuantity($quantity);

            if (!array_key_exists('total', $cart)) {
                $cart['total'] = 0;
            }
            $cart['tickets'][] = $ticket;
            $cart['total'] += $price;
            $session->set('cart', $cart);

            $this->addFlash('success', "$quantity $type tickets have been added to your cart");
            return $this->redirectToRoute('book_show', ['id' => $spectacle->getId()]);
        }

        return $this->render('spectacle/book.html.twig', [
            'show' => $spectacle,
            'form' => $ticketForm->createView()
        ]);

    }
}
