<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Service\PanierLengthService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/admin/category', name: 'app_category_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository, PanierLengthService $panierLengthService): Response
    {
        $panierLength = $panierLengthService->getPanierLength();

        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'panierLength' =>$panierLength
        ]);
    }

    #[Route('/admin/category/new', name: 'app_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/admin/category/{id}', name: 'app_category_show', methods: ['GET'])]
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/admin/category/{id}/edit', name: 'app_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/admin/category/{id}', name: 'app_category_delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
