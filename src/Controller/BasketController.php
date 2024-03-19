<?php

namespace App\Controller;

use App\Entity\Basket;
use App\Entity\Category;
use App\Form\BasketType;
use App\Repository\BasketRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;



#[Route('/basket')]
class BasketController extends AbstractController
{
    #[Route('/', name: 'app_basket_index', methods: ['GET'])]
    public function index(BasketRepository $basketRepository, CategoryRepository $categoryRepository): Response
    {
        return $this->render('basket/index.html.twig', [
            'baskets' => $basketRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/admin/new', name: 'app_basket_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        $basket = new Basket();
        $form = $this->createForm(BasketType::class, $basket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                // Récupère les données téléchargées via le bouton "fichier-image"
            $image = $form->get('photo')->getData();
            $image2 = $form->get('photo2')->getData();
            $image3 = $form->get('photo3')->getData();
            $image4 = $form->get('photo4')->getData();

            // Si un fichier a été envoyé (l'usage du bouton est facultatif)
            if ($image) {
                $basket->setPhoto("tmp");
                $entityManager->persist($basket);
                $entityManager->flush();
                $filename = 'photo-'.$basket->getId().'.'.$image->guessExtension();
                $basket->setPhoto($filename);
                $image->move('uploads', $filename);
            }
            if ($image2) {
                $basket->setPhoto2("tmp");
                $entityManager->persist($basket);
                $entityManager->flush();
                $filename2 = 'photo2-'.$basket->getId().'.'.$image2->guessExtension();
                $basket->setPhoto2($filename2);
                $image2->move('uploads', $filename2);
            }
            if ($image3) {
                $basket->setPhoto3("tmp");
                $entityManager->persist($basket);
                $entityManager->flush();
                $filename3 = 'photo3-'.$basket->getId().'.'.$image3->guessExtension();
                $basket->setPhoto3($filename3);
                $image3->move('uploads', $filename3);
            }
            if ($image4) {
                $basket->setPhoto4("tmp");
                $entityManager->persist($basket);
                $entityManager->flush();
                $filename4 = 'photo4-'.$basket->getId().'.'.$image4->guessExtension();
                $basket->setPhoto4($filename4);
                $image4->move('uploads', $filename4);
            }
            // Enregistrement final (si aucun fichier n'est envoyé ou pour mettre à jour le nom du ficher)
            $entityManager->persist($basket);
            $entityManager->flush();

            return $this->redirectToRoute('app_basket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('basket/new.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'basket' => $basket,
            'form' => $form,
        ]);
    }

    #[Route('/admin/{id}', name: 'app_basket_show', methods: ['GET'])]
    public function show(Basket $basket, CategoryRepository $categoryRepository): Response
    {
        return $this->render('basket/show.html.twig', [
            'basket' => $basket,
            'categories' => $categoryRepository->findAll(),

        ]);
    }

    #[Route('/admin/{id}/edit', name: 'app_basket_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Basket $basket, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(BasketType::class, $basket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('photo')->getData();
            $image2 = $form->get('photo2')->getData();
            $image3 = $form->get('photo3')->getData();
            $image4 = $form->get('photo4')->getData();

            if ($image) {
                if (file_exists('uploads/' . $basket->getPhoto()))
                    unlink('uploads/' . $basket->getPhoto());

                $filename = 'photo-'.$basket->getId().'.'.$image->guessExtension();
                $basket->setPhoto($filename);
                $image->move('uploads', $filename);
            }
            if ($image2) {
                if (file_exists('uploads/' . $basket->getPhoto2()))
                    unlink('uploads/' . $basket->getPhoto2());

                $filename2 = 'photo2-'.$basket->getId().'.'.$image2->guessExtension();
                $basket->setPhoto2($filename2);
                $image2->move('uploads', $filename2);
            }
            if ($image3) {
                if (file_exists('uploads/' . $basket->getPhoto3()))
                    unlink('uploads/' . $basket->getPhoto3());

                $filename3 = 'photo3-'.$basket->getId().'.'.$image3->guessExtension();
                $basket->setPhoto3($filename3);
                $image3->move('uploads', $filename3);
            }
            if ($image4) {
                if (file_exists('uploads/' . $basket->getPhoto4()))
                    unlink('uploads/' . $basket->getPhoto4());

                $filename4 = 'photo4-'.$basket->getId().'.'.$image4->guessExtension();
                $basket->setPhoto4($filename4);
                $image4->move('uploads', $filename4);
            }
            $entityManager->persist($basket);
            $entityManager->flush();

            return $this->redirectToRoute('app_basket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('basket/edit.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'basket' => $basket,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/{id}', name: 'app_basket_delete', methods: ['POST'])]
    public function delete(Request $request, Basket $basket, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$basket->getId(), $request->request->get('_token'))) {
            if (is_file('uploads/' . $basket->getPhoto())) {
                unlink('uploads/' . $basket->getPhoto());
            }
            if (is_file('uploads/' . $basket->getPhoto2())) {
                unlink('uploads/' . $basket->getPhoto2());
            }
            if (is_file('uploads/' . $basket->getPhoto3())) {
                unlink('uploads/' . $basket->getPhoto3());
            }
            if (is_file('uploads/' . $basket->getPhoto4())) {
                unlink('uploads/' . $basket->getPhoto4());
            }
            // Supprime l'entité
            $entityManager->remove($basket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_basket_index', [], Response::HTTP_SEE_OTHER);
    }
}
