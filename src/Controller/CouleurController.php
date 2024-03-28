<?php

namespace App\Controller;

use App\Entity\Couleur;
use App\Form\CouleurType;
use App\Repository\CategoryRepository;
use App\Repository\CouleurRepository;
use App\Service\PanierLengthService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/couleur')]
class CouleurController extends AbstractController
{
    #[Route('/', name: 'app_couleur_index', methods: ['GET'])]
    public function index(CouleurRepository $couleurRepository, CategoryRepository $categoryRepository, PanierLengthService $panierLengthService): Response
    {
        $panierLength = $panierLengthService->getPanierLength();

        return $this->render('couleur/index.html.twig', [
            'couleurs' => $couleurRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
            'panierLength' => $panierLength

        ]);
    }

    #[Route('/new', name: 'app_couleur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository, PanierLengthService $panierLengthService): Response
    {
        $couleur = new Couleur();
        $form = $this->createForm(CouleurType::class, $couleur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($couleur);
            $entityManager->flush();

            return $this->redirectToRoute('app_couleur_index', [], Response::HTTP_SEE_OTHER);
        }

        $panierLength = $panierLengthService->getPanierLength();

        return $this->render('couleur/new.html.twig', [
            'couleur' => $couleur,
            'form' => $form,
            'categories' => $categoryRepository->findAll(),
            'panierLength' => $panierLength
        ]);
    }

    #[Route('/{id}', name: 'app_couleur_show', methods: ['GET'])]
    public function show(Couleur $couleur, CategoryRepository $categoryRepository, PanierLengthService $panierLengthService): Response
    {
        $panierLength = $panierLengthService->getPanierLength();

        return $this->render('couleur/show.html.twig', [
            'couleur' => $couleur,
            'categories' => $categoryRepository->findAll(),
            'panierLength' => $panierLength
        ]);
    }

    #[Route('/{id}/edit', name: 'app_couleur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Couleur $couleur, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository, PanierLengthService $panierLengthService): Response
    {
        $form = $this->createForm(CouleurType::class, $couleur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_couleur_index', [], Response::HTTP_SEE_OTHER);
        }
        $panierLength = $panierLengthService->getPanierLength();


        return $this->render('couleur/edit.html.twig', [
            'couleur' => $couleur,
            'form' => $form,
            'categories' => $categoryRepository->findAll(),
            'panierLength' => $panierLength
        ]);
    }

    #[Route('/{id}', name: 'app_couleur_delete', methods: ['POST'])]
    public function delete(Request $request, Couleur $couleur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$couleur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($couleur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_couleur_index', [], Response::HTTP_SEE_OTHER);
    }
}
