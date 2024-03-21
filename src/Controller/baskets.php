<?php
namespace App\Controller;

use App\Repository\CouleurRepository;
use App\Repository\TailleRepository;
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
    public function baskets(BasketRepository $basketRepository, CategoryRepository $categoryRepository, TailleRepository $tailleRepository): Response
    {
        $baskets = $basketRepository->findAll();
        $categories = $categoryRepository->findAll();
        $tailles = $tailleRepository->findAll();

        return $this->render('baskets.html.twig', [
            'baskets' => $baskets,
            'categories' => $categories,
            'tailles' => $tailles
        ]);
    }

    #[Route('/baskett/{id}', name: 'basket', requirements: ['id' => '\d+'])]
    public function basket(BasketRepository $repository, CategoryRepository $categoryRepository, int $id): Response
    {
        $basket = $repository->find($id);
        $categories = $categoryRepository->findAll();
        $baskets = $repository->findAll();

        return $this->render('basket.html.twig', [
            'basket' => $basket,
            'baskets' => $baskets,
            'categories' => $categories,
        ]);
    }

    #[Route('/categorie/{id}', name: 'categorie', requirements: ['id' => '\d+'])]
    public function categorie(CategoryRepository $categoryRepository, TailleRepository $tailleRepository, int $id): Response
    {

        $categorie = $categoryRepository->find($id);
        $categories = $categoryRepository->findAll();
        $tailles = $tailleRepository->findAll();
        $baskets = $categorie->getBasket();

        return $this->render('baskets.html.twig', [
            'baskets' => $baskets,
            'categorie' => $categorie,
            'categories' => $categories,
            'tailles' => $tailles,
        ]);
    }
    #[Route('/baskets/{tailleId}', name: 'baskets_taille')]
    public function basketsTaille($tailleId, TailleRepository $tailleRepository, CategoryRepository $categoryRepository)
    {
        $taille = $tailleRepository->find($tailleId);
        $tailles = $tailleRepository->findAll();
        $categories = $categoryRepository->findAll();

        $baskets = $taille->getBasket();

        return $this->render('baskets.html.twig', [
            'taille' => $taille,
            'tailles' => $tailles,
            'baskets' => $baskets,
            'categories' => $categories,
        ]);
    }
    #[Route('/baskets/{couleurId}', name: 'baskets_couleur')]
    public function basketsCouleur($couleurId, CouleurRepository $couleurRepository, TailleRepository $tailleRepository, CategoryRepository $categoryRepository)
    {
        $couleur = $couleurRepository->find($couleurId);
        $couleurs = $couleurRepository->findAll();
        $tailles = $tailleRepository->findAll();
        $categories = $categoryRepository->findAll();

        $baskets = $couleur->getBasket();

        return $this->render('baskets.html.twig', [
            'couleur' => $couleur,
            'couleurs' => $couleurs,
            'tailles' => $tailles,
            'baskets' => $baskets,
            'categories' => $categories,
        ]);
    }

}