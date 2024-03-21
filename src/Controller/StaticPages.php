<?php
namespace App\Controller;


use App\Repository\BasketRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticPages extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CategoryRepository $categoryRepository, BasketRepository $basketRepository): Response
    {
        $categories = $categoryRepository->findAll();
        $randomBaskets = $basketRepository->getRandomBaskets(3);

        return $this->render('home.html.twig', [
            'titre' => 'Bienvenue sur ma page d\'accueil',
            'description' => '',
            'categories' => $categories,
            'randomBaskets'=>$randomBaskets,

        ]);
    }

}
