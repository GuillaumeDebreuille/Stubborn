<?php

namespace App\Controller;

use App\Repository\SweatShirtRepository;
use App\Repository\StockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShopController extends AbstractController
{
    #[Route('/shop', name: 'app_shop')]
    public function index(SweatShirtRepository $sweatShirtRepository): Response
    {
        $sweats = $sweatShirtRepository->findAll();

        return $this->render('shop/index.html.twig', [
            'sweats' => $sweats,
        ]);
    }

    #[Route('/shop/{id}', name: 'shop_show')]
    public function show(int $id, SweatShirtRepository $sweatShirtRepository, StockRepository $stockRepository): Response
    {
        $sweat = $sweatShirtRepository->find($id);

        if (!$sweat) {
            throw $this->createNotFoundException('Sweat-shirt non trouvé.');
        }

        $stocks = $stockRepository->findBy(['sweat' => $sweat]);

        return $this->render('shop/show.html.twig', [
            'sweat' => $sweat,
            'stocks' => $stocks,
        ]);
    }
}