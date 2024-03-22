<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Basket;
use App\Entity\User;
use App\Form\PanierType;
use App\Repository\PanierRepository;
use App\Repository\BasketRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;



class PanierController extends AbstractController
{
    #[Route('/admin/panier', name: 'app_panier_index', methods: ['GET'])]
    public function index(PanierRepository $panierRepository, CategoryRepository $categoryRepository): Response
    {
        return $this->render('panier/index.html.twig', [
            'paniers' => $panierRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/admin/panier/new', name: 'app_panier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $panier = new Panier();
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($panier);
            $entityManager->flush();

            return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('panier/new.html.twig', [
            'panier' => $panier,
            'form' => $form,
        ]);
    }

    #[Route('/admin/panier/{id}', name: 'app_panier_show', methods: ['GET'])]
    public function show(Panier $panier): Response
    {
        return $this->render('panier/show.html.twig', [
            'panier' => $panier,
        ]);
    }

    #[Route('/admin/panier/{id}/edit', name: 'app_panier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('panier/edit.html.twig', [
            'panier' => $panier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/supp', name: 'app_panier_delete', methods: ['POST'])]
    public function delete(Request $request, PanierRepository $panierRepository, EntityManagerInterface $entityManager, $id): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Récupérer le panier associé à l'utilisateur et à l'ID spécifié
        $panier = $panierRepository->findOneBy(['id' => $id, 'user' => $user]);

        if (!$panier) {
            throw $this->createNotFoundException('Panier non trouvé');
        }

        if ($this->isCsrfTokenValid('delete'.$panier->getId(), $request->request->get('_token'))) {
            $entityManager->remove($panier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('panier', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/panier', name: 'panier')]
    public function afficherPanier(BasketRepository $basketRepository, CategoryRepository $categoryRepository, PanierRepository $panierRepository): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        if (!$user) {
            // Gérer le cas où aucun utilisateur n'est connecté
            // Redirection vers la page de connexion par exemple
            return $this->redirectToRoute('app_login');
        }

        // Récupérer les paniers de l'utilisateur connecté
        $paniers = $panierRepository->findBy(['user' => $user]);

        // Récupérer toutes les baskets et catégories disponibles
        $baskets = $basketRepository->findAll();
        $categories = $categoryRepository->findAll();

        return $this->render('panier.html.twig', [
            'paniers' => $paniers,
            'baskets' => $baskets,
            'categories' => $categories,
        ]);
    }

    public function addToCart(Request $request, EntityManagerInterface $entityManager, $basketId): JsonResponse
    {
        $basket = $entityManager->getRepository(Basket::class)->find($basketId);
        $user = $this->getUser();

        if (!$basket) {
            throw $this->createNotFoundException('Basket not found');
        }

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('User not authenticated');
        }

        // Créer un nouvel objet Panier et associer le panier trouvé avec l'utilisateur
        $panier = new Panier();
        $panier->setBasket($basket); // Assurez-vous que la méthode setBasket existe dans la classe Panier
        $panier->setUser($user);

        $entityManager->persist($panier);
        $entityManager->flush();

        $basketId = $basket->getId();


        return new JsonResponse(['message' => 'Article ajouté au panier', 'basketId' => $basketId]);



        // Rediriger l'utilisateur vers la page de panier ou une autre page après l'ajout
        //return $this->redirectToRoute('baskett', ['id' => $basketId]);


    }

    public function suppElementPanier(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $elementPanier = $entityManager->getRepository(Panier::class)->find($id);

        if (!$elementPanier) {
            throw $this->createNotFoundException('Element du panier non trouvé');
        }

        // Supprimer l'élément du panier
        $entityManager->remove($elementPanier);
        $entityManager->flush();

        // Rediriger l'utilisateur vers la page du panier
        return $this->redirectToRoute('panier');
    }




}
