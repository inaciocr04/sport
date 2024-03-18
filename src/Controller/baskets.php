<?php
namespace App\Controller;

use App\Repository\TailleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Basket;
use App\Entity\Category;
use App\Entity\Taille;
use App\Repository\BasketRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

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
    #[Route('/filter-by-tailles', name: 'filter_by_tailles', methods: ['POST'])]
    public function filterByTailles(Request $request, BasketRepository $basketRepository, TailleRepository $tailleRepository): Response
    {
        $selectedTailles = $request->request->get('tailles', []);

        // Récupérer les baskets qui correspondent aux tailles sélectionnées
        $baskets = $basketRepository->findByTailles($selectedTailles);

        // Renvoyer la réponse avec les baskets filtrées
        return $this->render('baskets/index.html.twig', [
            'baskets' => $baskets,
        ]);
    }



}