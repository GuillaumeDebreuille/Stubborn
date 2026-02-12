<?php

namespace App\Controller;

use App\Repository\StockRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CheckoutController extends AbstractController
{
    #[Route('/checkout', name: 'app_checkout', methods: ['POST', 'GET'])]
    public function index(Request $request, StockRepository $stockRepository, EntityManagerInterface $entityManager): Response
    {
        $session = $request->getSession();
        $items = $session->get('cart', []);
        $stockErrors = [];

        // Vérification du stock
        foreach ($items as $item) {
            if (
                (is_array($item) && isset($item['sweat'], $item['size'], $item['qty'])) ||
                (is_object($item) && isset($item->sweat, $item->size, $item->qty))
            ) {
                $sweat = is_array($item) ? $item['sweat'] : $item->sweat;
                $size = is_array($item) ? $item['size'] : $item->size;
                $qty = is_array($item) ? $item['qty'] : $item->qty;

                $sweatId = is_object($sweat) ? $sweat->getId() : $sweat;
                $sweatName = is_object($sweat) ? $sweat->getName() : $sweat;

                $stock = $entityManager->getRepository(\App\Entity\Stock::class)
                    ->createQueryBuilder('s')
                    ->andWhere('s.sweat = :sweatId')
                    ->andWhere('s.size = :size')
                    ->setParameter('sweatId', $sweatId)
                    ->setParameter('size', $size)
                    ->getQuery()
                    ->getOneOrNullResult();

                if (!$stock || $stock->getQuantity() < $qty) {
                    $stockErrors[] = $sweatName . ' (' . $size . ') : stock insuffisant';
                }
            }
        }

        // Traitement du paiement simulé
        if ($request->isMethod('POST') && empty($stockErrors)) {
            foreach ($items as $item) {
                if (
                    (is_array($item) && isset($item['sweat'], $item['size'], $item['qty'])) ||
                    (is_object($item) && isset($item->sweat, $item->size, $item->qty))
                ) {
                    $sweat = is_array($item) ? $item['sweat'] : $item->sweat;
                    $size = is_array($item) ? $item['size'] : $item->size;
                    $qty = is_array($item) ? $item['qty'] : $item->qty;

                    $sweatId = is_object($sweat) ? $sweat->getId() : $sweat;

                    $stock = $entityManager->getRepository(\App\Entity\Stock::class)
                        ->createQueryBuilder('s')
                        ->andWhere('s.sweat = :sweatId')
                        ->andWhere('s.size = :size')
                        ->setParameter('sweatId', $sweatId)
                        ->setParameter('size', $size)
                        ->getQuery()
                        ->getOneOrNullResult();

                    if ($stock && $stock->getQuantity() >= $qty) {
                        $stock->setQuantity($stock->getQuantity() - $qty);
                        $entityManager->persist($stock);
                    }
                }
            }
            $entityManager->flush();
            $session->set('cart', []);
            return $this->redirectToRoute('app_home');
        }

        return $this->render('checkout/index.html.twig', [
            'stockErrors' => $stockErrors,
            'items' => $items,
        ]);
    }
}