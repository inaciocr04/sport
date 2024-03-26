<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use App\Service\PanierLengthService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository,CategoryRepository $categoryRepository, PanierLengthService $panierLengthService): Response
    {
        $panierLength = $panierLengthService->getPanierLength();

        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
            'panierLength' =>$panierLength
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user, CategoryRepository $categoryRepository): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager,CategoryRepository $categoryRepository,PanierLengthService $panierLengthService): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        $panierLength = $panierLengthService->getPanierLength();


        if ($form->isSubmitted() && $form->isValid()) {
            // récupère le mot de passe saisi
            $plaintextPassword = $user-getPassword();

            // crypte le mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $plaintextPassword);

            // remplace le mot de passe saisi par le mot de passe crypté
            $user->setPassword($hashedPassword);

            // enregistre les informations
            $entityManager->persist($basket);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'categories' => $categoryRepository->findAll(),
            'panierLength' => $panierLength
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
