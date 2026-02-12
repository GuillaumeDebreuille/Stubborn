<?php

namespace App\Controller;

use App\Entity\SweatShirt;
use App\Form\SweatShirtType;
use App\Repository\SweatShirtRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/shirt')]
final class SweatShirtController extends AbstractController
{
    #[Route(name: 'app_sweat_shirt_index', methods: ['GET'])]
    public function index(SweatShirtRepository $sweatShirtRepository): Response
    {
        return $this->render('sweat_shirt/index.html.twig', [
            'sweat_shirts' => $sweatShirtRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sweat_shirt_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sweatShirt = new SweatShirt();
        $form = $this->createForm(SweatShirtType::class, $sweatShirt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sweatShirt);
            $entityManager->flush();

            return $this->redirectToRoute('app_sweat_shirt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sweat_shirt/new.html.twig', [
            'sweat_shirt' => $sweatShirt,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sweat_shirt_show', methods: ['GET'])]
    public function show(SweatShirt $sweatShirt): Response
    {
        return $this->render('sweat_shirt/show.html.twig', [
            'sweat_shirt' => $sweatShirt,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sweat_shirt_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SweatShirt $sweatShirt, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SweatShirtType::class, $sweatShirt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_sweat_shirt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sweat_shirt/edit.html.twig', [
            'sweat_shirt' => $sweatShirt,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sweat_shirt_delete', methods: ['POST'])]
    public function delete(Request $request, SweatShirt $sweatShirt, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sweatShirt->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($sweatShirt);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sweat_shirt_index', [], Response::HTTP_SEE_OTHER);
    }
}
