<?php
namespace App\Controller;

use App\Repository\CommentaireRepository;
use App\Repository\CouleurRepository;
use App\Repository\PanierRepository;
use App\Repository\TailleRepository;
use App\Service\PanierLengthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Basket;
use App\Entity\Taille;
use App\Repository\BasketRepository;
use App\Repository\CategoryRepository;


class baskets extends AbstractController
{

    #[Route('/baskets', name: 'baskets')]
    public function baskets(BasketRepository $basketRepository, CategoryRepository $categoryRepository, TailleRepository $tailleRepository, CouleurRepository $couleurRepository,PanierRepository $panierRepository, PanierLengthService $panierLengthService): Response
    {
        $baskets = $basketRepository->findAll();
        $categories = $categoryRepository->findAll();
        $tailles = $tailleRepository->findAll();
        $couleurs = $couleurRepository->findAll();
        $panierLength = $panierLengthService->getPanierLength();



        return $this->render('baskets.html.twig', [
            'baskets' => $baskets,
            'categories' => $categories,
            'tailles' => $tailles,
            'couleurs' => $couleurs,
            'panierLength' =>$panierLength

        ]);
    }

    #[Route('/baskett/{id}', name: 'basket', requirements: ['id' => '\d+'])]
    public function basket(BasketRepository $repository, CategoryRepository $categoryRepository,PanierLengthService $panierLengthService, CommentaireRepository $commentaireRepository , int $id): Response
    {
        $basket = $repository->find($id);
        $categories = $categoryRepository->findAll();
        $baskets = $repository->findAll();
        $panierLength = $panierLengthService->getPanierLength();
        $commentaire = $commentaireRepository->find($id);
        $commentaire = $basket->getCommentaire();


        return $this->render('basket.html.twig', [
            'basket' => $basket,
            'baskets' => $baskets,
            'categories' => $categories,
            'panierLength' => $panierLength,
            'commentaire' =>$commentaire,
        ]);
    }

    #[Route('/categorie/{id}', name: 'categorie', requirements: ['id' => '\d+'])]
    public function categorie(CategoryRepository $categoryRepository, TailleRepository $tailleRepository,CouleurRepository $couleurRepository,PanierLengthService $panierLengthService , int $id): Response
    {

        $categorie = $categoryRepository->find($id);
        $categories = $categoryRepository->findAll();
        $tailles = $tailleRepository->findAll();
        $couleurs = $couleurRepository->findAll();
        $baskets = $categorie->getBasket();
        $panierLength = $panierLengthService->getPanierLength();


        return $this->render('baskets.html.twig', [
            'baskets' => $baskets,
            'categorie' => $categorie,
            'categories' => $categories,
            'tailles' => $tailles,
            'couleurs' => $couleurs,
            'panierLength' => $panierLength
        ]);
    }
    #[Route('/baskets/taille/{tailleId}', name: 'baskets_taille')]
    public function basketsTaille($tailleId, TailleRepository $tailleRepository, CategoryRepository $categoryRepository, CouleurRepository $couleurRepository,PanierLengthService $panierLengthService)
    {
        $taille = $tailleRepository->find($tailleId);
        $tailles = $tailleRepository->findAll();
        $categories = $categoryRepository->findAll();
        $couleurs = $couleurRepository->findAll();
        $panierLength = $panierLengthService->getPanierLength();



        $baskets = $taille->getBasket();

        return $this->render('baskets.html.twig', [
            'taille' => $taille,
            'tailles' => $tailles,
            'baskets' => $baskets,
            'categories' => $categories,
            'couleurs' => $couleurs,
            'panierLength' =>$panierLength
        ]);
    }
    #[Route('/baskets/couleur/{couleurId}', name: 'baskets_couleur')]
    public function basketsCouleur($couleurId, CouleurRepository $couleurRepository, TailleRepository $tailleRepository, CategoryRepository $categoryRepository,PanierLengthService $panierLengthService)
    {
        $couleur = $couleurRepository->find($couleurId);
        $couleurs = $couleurRepository->findAll();
        $tailles = $tailleRepository->findAll();
        $categories = $categoryRepository->findAll();
        $panierLength = $panierLengthService->getPanierLength();

        $baskets = $couleur->getBasket();

        return $this->render('baskets.html.twig', [
            'couleur' => $couleur,
            'couleurs' => $couleurs,
            'tailles' => $tailles,
            'baskets' => $baskets,
            'categories' => $categories,
            'panierLength' =>$panierLength
        ]);
    }

}