<?php

namespace App\Controller;

use App\Entity\Likes;
use App\Entity\Basket;
use App\Entity\User;
use App\Form\LikesType;
use App\Repository\LikesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/likes')]
class LikesController extends AbstractController
{
    #[Route('/', name: 'app_likes_index', methods: ['GET'])]
    public function index(LikesRepository $likesRepository): Response
    {
        return $this->render('likes/index.html.twig', [
            'likes' => $likesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_likes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $like = new Likes();
        $form = $this->createForm(LikesType::class, $like);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($like);
            $entityManager->flush();

            return $this->redirectToRoute('app_likes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('likes/new.html.twig', [
            'like' => $like,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_likes_show', methods: ['GET'])]
    public function show(Likes $like): Response
    {
        return $this->render('likes/show.html.twig', [
            'like' => $like,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_likes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Likes $like, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LikesType::class, $like);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_likes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('likes/edit.html.twig', [
            'like' => $like,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_likes_delete', methods: ['POST'])]
    public function delete(Request $request, Likes $like, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$like->getId(), $request->request->get('_token'))) {
            $entityManager->remove($like);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_likes_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/likes/{id}', name: 'add_likes', requirements: ['id' => '\d+'])]
    public function addLikes(Request $request, EntityManagerInterface $entityManager, Basket $basketId)
    {
        $basket = $entityManager->getRepository(Basket::class)->find($basketId);
        $user = $this->getUser();

        if (!$basket) {
            throw $this->createNotFoundException('basket not found');
        }

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('User not authenticated');
        }

        $existingLike = $entityManager->getRepository(Likes::class)->findOneBy(['user' => $user, 'basket' => $basket]);
        if ($existingLike) {

            $this->addFlash('error', 'Vous avez déjà aimé cette baskets.');
            return $this->redirectToRoute('mesLikes');
        }
        $like = new Likes();
        $like->setbasket($basket);
        $like->setUser($user);

        $entityManager->persist($like);
        $entityManager->flush();

        $basketId = $basket->getId();


        return $this->redirectToRoute('mesLikes', ['id' => $basketId]);

    }
    #[Route('/supp/likes/{id}', name: 'supp_likes', requirements: ['id' => '\d+'])]
    public function suppElementLikes(EntityManagerInterface $entityManager, int $id): Response
    {
        $elementLikes = $entityManager->getRepository(Likes::class)->find($id);

        // Supprimer l'élément du panier
        $entityManager->remove($elementLikes);
        $entityManager->flush();

        // Rediriger l'utilisateur vers la page du panier
        return $this->redirectToRoute('mesLikes');
    }
}
