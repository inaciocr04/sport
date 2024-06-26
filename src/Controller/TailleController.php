<?php

namespace App\Controller;

use App\Entity\Taille;
use App\Form\TailleType;
use App\Repository\CategoryRepository;
use App\Repository\TailleRepository;
use App\Service\PanierLengthService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/taille')]
class TailleController extends AbstractController
{
    #[Route('/', name: 'app_taille_index', methods: ['GET'])]
    public function index(TailleRepository $tailleRepository,CategoryRepository $categoryRepository, PanierLengthService $panierLengthService): Response
    {
        $panierLength = $panierLengthService->getPanierLength();

        return $this->render('taille/index.html.twig', [
            'tailles' => $tailleRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
            'panierLength' => $panierLength

        ]);
    }

    #[Route('/new', name: 'app_taille_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository, PanierLengthService $panierLengthService): Response
    {
        $taille = new Taille();
        $form = $this->createForm(TailleType::class, $taille);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($taille);
            $entityManager->flush();

            return $this->redirectToRoute('app_taille_index', [], Response::HTTP_SEE_OTHER);
        }

        $panierLength = $panierLengthService->getPanierLength();

        return $this->render('taille/new.html.twig', [
            'taille' => $taille,
            'form' => $form,
            'categories' => $categoryRepository->findAll(),
            'panierLength' => $panierLength
        ]);
    }

    #[Route('/{id}', name: 'app_taille_show', methods: ['GET'])]
    public function show(Taille $taille, CategoryRepository $categoryRepository, PanierLengthService $panierLengthService): Response
    {
        $panierLength = $panierLengthService->getPanierLength();

        return $this->render('taille/show.html.twig', [
            'taille' => $taille,
            'categories' => $categoryRepository->findAll(),
            'panierLength' => $panierLength
        ]);
    }

    #[Route('/{id}/edit', name: 'app_taille_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Taille $taille, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository, PanierLengthService $panierLengthService): Response
    {
        $form = $this->createForm(TailleType::class, $taille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_taille_index', [], Response::HTTP_SEE_OTHER);
        }
        $panierLength = $panierLengthService->getPanierLength();


        return $this->render('taille/edit.html.twig', [
            'taille' => $taille,
            'form' => $form,
            'categories' => $categoryRepository->findAll(),
            'panierLength' => $panierLength
        ]);
    }

    #[Route('/{id}', name: 'app_taille_delete', methods: ['POST'])]
    public function delete(Request $request, Taille $taille, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taille->getId(), $request->request->get('_token'))) {
            $entityManager->remove($taille);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_taille_index', [], Response::HTTP_SEE_OTHER);
    }

}
