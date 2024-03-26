<?php
namespace App\Controller;


use App\Repository\BasketRepository;
use App\Repository\CategoryRepository;
use App\Service\PanierLengthService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Panier;
use App\Entity\Basket;



class StaticPages extends AbstractController
{

    #[Route('/', name: 'home')]
    public function index(CategoryRepository $categoryRepository, BasketRepository $basketRepository, PanierLengthService $panierLengthService): Response
    {
        $categories = $categoryRepository->findAll();
        $randomBaskets = $basketRepository->getRandomBaskets(21);

        $panierLength = $panierLengthService->getPanierLength();

        return $this->render('home.html.twig', [
            'categories' => $categories,
            'randomBaskets'=>$randomBaskets,
            'panierLength' => $panierLength,
        ]);
    }

    #[Route('/admin', name: 'admin')]
    public function admin(CategoryRepository $categoryRepository, BasketRepository $basketRepository, PanierLengthService $panierLengthService): Response
    {
        $categories = $categoryRepository->findAll();
        $randomBaskets = $basketRepository->getRandomBaskets(21);

        $panierLength = $panierLengthService->getPanierLength();

        return $this->render('admin.html.twig', [
            'categories' => $categories,
            'randomBaskets'=>$randomBaskets,
            'panierLength' => $panierLength,
        ]);
    }


}
