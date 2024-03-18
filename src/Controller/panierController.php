<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Panier;
use App\Entity\Basket;
use Symfony\Component\Routing\Annotation\Route;


class panierController extends AbstractController
{
    /**
     * Affiche le contenu du panier.
     */
    #[Route('/panier', name: 'panier')]
    public function vuePanier(): Response
    {
        // Récupérer le panier de l'utilisateur actuel (vous devez implémenter la logique d'authentification)
        $panierItems = $this->getUser()->getBasketsId();

        return $this->render('panier.html.twig', [
            'panierItems' => $panierItems,
        ]);
    }

    /**
     * Ajoute un produit au panier.
     */
    #[Route('/add-to-panier/{id}', name: 'add_to_panier', methods: ['POST'])]
    public function addToPanier(Request $request, int $id): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Vérifier si l'utilisateur est connecté
        if (!$user) {
            return new Response('Utilisateur non connecté', Response::HTTP_UNAUTHORIZED);
        }

        // Récupérer l'e-mail de l'utilisateur
        $email = $user->getEmail();

        // Récupérer le panier de l'utilisateur
        $panier = $user->getPanier();

        // Si l'utilisateur n'a pas encore de panier, vous pouvez choisir de le créer ici
        if (!$panier) {
            // Créer un nouveau panier
            $panier = new Panier();
            // Associer le panier à l'utilisateur
            $panier->setUser($user);
            // Stocker l'e-mail de l'utilisateur dans le panier
            $panier->setUserEmail($email);
            // Enregistrer le panier dans la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($panier);
            $entityManager->flush();
        }

        return new Response('Article ajouté au panier avec succès', Response::HTTP_OK);


    }


    /**
     * Supprime un produit du panier.
     */
    public function removeFromPanier(Request $request, int $panierItemId): Response
    {
        // Récupérer l'élément de panier à partir de son ID
        $panierItem = $this->getDoctrine()->getRepository(Panier::class)->find($panierItemId);

        // Vérifier si l'élément de panier existe
        if (!$panierItem) {
            throw $this->createNotFoundException('L\'élément de panier n\'existe pas.');
        }

        // Supprimer l'élément de panier de la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($panierItem);
        $entityManager->flush();

        // Rediriger vers la page du panier
        return $this->redirectToRoute('view_panier');
    }
}
