<?php
namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticPages extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('home.html.twig', [
            'titre' => 'Bienvenue sur ma page d\'accueil',
            'description' => '',
            'categories' => $categories,

        ]);
    }
    #[Route('/apropos', name: 'apropos')]
    public function apropos(): Response
    {
        return $this->render('home.html.twig', [
            'titre' => 'Bienvenue sur ma page a propos',
            'description' => 'Voila une courte description'
        ]);
    }


}
