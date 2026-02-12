<?php

namespace App\Controller;

use App\Repository\SweatShirtRepository;
use App\Repository\StockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

final class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_show')]
    public function show(SessionInterface $session, SweatShirtRepository $repo): Response
    {
        $cart = $session->get('cart', []);
        $items = [];

        foreach ($cart as $key => $qty) {
            [$id, $size] = explode('|', $key);
            $sweat = $repo->find((int) $id);
            if ($sweat) {
                $items[] = ['sweat' => $sweat, 'size' => $size, 'qty' => $qty];
            }
        }

        return $this->render('cart/index.html.twig', ['items' => $items]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add', methods: ['POST'])]
    public function add(int $id, Request $request, SessionInterface $session, StockRepository $stockRepo): RedirectResponse
    {
        $size = (string) $request->request->get('taille');
        $stock = $stockRepo->findOneBy(['sweat' => $id, 'size' => $size]);

        if (!$stock || $stock->getQuantity() <= 0) {
            $this->addFlash('error', 'Stock insuffisant.');
            return $this->redirectToRoute('shop_show', ['id' => $id]);
        }

        $key = $id.'|'.$size;
        $cart = $session->get('cart', []);
        $cart[$key] = ($cart[$key] ?? 0) + 1;
        $session->set('cart', $cart);

        $this->addFlash('success', 'Article ajouté au panier');
        return $this->redirectToRoute('app_shop');
    }

    #[Route('/cart/remove/{id}/{size}', name: 'cart_remove')]
    public function remove(int $id, string $size, SessionInterface $session): RedirectResponse
    {
        $key = $id.'|'.$size;
        $cart = $session->get('cart', []);
        unset($cart[$key]);
        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_show');
    }

    #[Route('/cart/clear', name: 'cart_clear')]
    public function clear(SessionInterface $session): RedirectResponse
    {
        $session->remove('cart');
        return $this->redirectToRoute('cart_show');
    }
}