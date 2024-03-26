<?php

namespace App\Controller;

use App\Entity\Basket;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CategoryRepository;
use App\Repository\CommentaireRepository;
use App\Service\PanierLengthService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentaireController extends AbstractController
{
    #[Route('/admin/commentaires', name: 'app_commentaire_index', methods: ['GET'])]
    public function index(CommentaireRepository $commentaireRepository, CategoryRepository $categoryRepository, PanierLengthService $panierLengthService): Response
    {
        $panierLength = $panierLengthService->getPanierLength();

        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaireRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
            'panierLength' => $panierLength,

        ]);
    }

    #[Route('/comentaire/new/{basketId}', name: 'app_commentaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,CategoryRepository $categoryRepository,PanierLengthService $panierLengthService,$basketId): Response
    {

        $basket = $entityManager->getRepository(Basket::class)->find($basketId);
        $user = $this->getUser();

        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setBasket($basket);
            $commentaire->setUser($user);
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('basket', ['id' => $basketId], Response::HTTP_SEE_OTHER);
        }

        $panierLength = $panierLengthService->getPanierLength();

        return $this->render('commentaire/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
            'categories' => $categoryRepository->findAll(),
            'panierLength' => $panierLength,
            'basketId' => $basketId,
        ]);
    }
    #[Route('/admin/commentaires/new', name: 'app_commentaire_new_admin', methods: ['GET', 'POST'])]
    public function newAdmin(Request $request, EntityManagerInterface $entityManager,CategoryRepository $categoryRepository,PanierLengthService $panierLengthService): Response
    {

        $user = $this->getUser();

        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setUser($user);
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        $panierLength = $panierLengthService->getPanierLength();

        return $this->render('commentaire/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
            'categories' => $categoryRepository->findAll(),
            'panierLength' => $panierLength,
        ]);
    }

    #[Route('/admin/commentaires/{id}', name: 'app_commentaire_show', methods: ['GET'])]
    public function show(Commentaire $commentaire, PanierLengthService $panierLengthService, CategoryRepository $categoryRepository): Response
    {
        $panierLength = $panierLengthService->getPanierLength();

        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
            'panierLength' => $panierLength,
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/admin/commentaires/{id}/edit', name: 'app_commentaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager,CategoryRepository $categoryRepository,PanierLengthService $panierLengthService): Response
    {
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }
        $panierLength = $panierLengthService->getPanierLength();


        return $this->render('commentaire/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
            'categories' => $categoryRepository->findAll(),
            'panierLength' =>$panierLength
        ]);
    }

    #[Route('/admin/commentaires/{id}/delete', name: 'app_commentaire_delete', methods: ['POST'])]
    public function delete(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
