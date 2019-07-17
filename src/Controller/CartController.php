<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function checkCart(Session $session)
    {
        $em = $this->getDoctrine()->getManager();
        $cart = $session->get('cart');

        return $this->render('cart/cart.html.twig', [
            'cart' => $cart
        ]);
    }

    /**
     * @Route("/cart/clear", name="cart_clear")
     */
    public function clearCart(Session $session)
    {
        $session->set('cart', []);

        return $this->redirectToRoute("browse_show");
    }
}
