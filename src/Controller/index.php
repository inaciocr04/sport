<?php
namespace App\Controller;


use App\Entity\Panier;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\BasketRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentaireRepository;
use App\Repository\CouleurRepository;
use App\Repository\LikesRepository;
use App\Repository\PanierRepository;
use App\Repository\TailleRepository;
use App\Service\PanierLengthService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class index extends AbstractController
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


    #[Route('/baskets', name: 'baskets')]
    public function baskets(Request $request,BasketRepository $basketRepository, CategoryRepository $categoryRepository, TailleRepository $tailleRepository, CouleurRepository $couleurRepository,PanierRepository $panierRepository, PanierLengthService $panierLengthService): Response
    {
        $baskets = $basketRepository->findAll();
        $categories = $categoryRepository->findAll();
        $tailles = $tailleRepository->findAll();
        $couleurs = $couleurRepository->findAll();
        $panierLength = $panierLengthService->getPanierLength();

        $searchData = new SearchData();

        $searchData->q = $request->query->get('q', '');

        $form = $this->createForm(SearchType::class, $searchData);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $baskets = $basketRepository->findBySearch($searchData);

            return $this->render('baskets.html.twig', [
                'form' => $form->createView(),
                'baskets' => $baskets,
                'categories' => $categories,
                'tailles' => $tailles,
                'couleurs' => $couleurs,
                'panierLength' =>$panierLength
            ]);
        }


        return $this->render('baskets.html.twig', [
            'form' => $form->createView(),
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
        $commentaires = $basket->getCommentaire();


        return $this->render('basket.html.twig', [
            'basket' => $basket,
            'baskets' => $baskets,
            'categories' => $categories,
            'panierLength' => $panierLength,
            'commentaire' =>$commentaire,
            'commentaires' =>$commentaires
        ]);
    }

    #[Route('/categorie/{id}', name: 'categorie', requirements: ['id' => '\d+'])]
    public function categorie(Request $request,BasketRepository $basketRepository,CategoryRepository $categoryRepository, TailleRepository $tailleRepository,CouleurRepository $couleurRepository,PanierLengthService $panierLengthService , int $id): Response
    {

        $categorie = $categoryRepository->find($id);
        $categories = $categoryRepository->findAll();
        $tailles = $tailleRepository->findAll();
        $couleurs = $couleurRepository->findAll();
        $baskets = $categorie->getBasket();
        $panierLength = $panierLengthService->getPanierLength();

        $searchData = new SearchData();

        $searchData->q = $request->query->get('q', '');

        $form = $this->createForm(SearchType::class, $searchData);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $baskets = $basketRepository->findBySearch($searchData);

            return $this->render('baskets.html.twig', [
                'form' => $form->createView(),
                'baskets' => $baskets,
                'categories' => $categories,
                'tailles' => $tailles,
                'couleurs' => $couleurs,
                'panierLength' =>$panierLength
            ]);
        }

        return $this->render('baskets.html.twig', [
            'form' => $form->createView(),
            'baskets' => $baskets,
            'categorie' => $categorie,
            'categories' => $categories,
            'tailles' => $tailles,
            'couleurs' => $couleurs,
            'panierLength' => $panierLength
        ]);
    }
    #[Route('/baskets/taille/{tailleId}', name: 'baskets_taille')]
    public function basketsTaille(Request $request, BasketRepository $basketRepository,$tailleId, TailleRepository $tailleRepository, CategoryRepository $categoryRepository, CouleurRepository $couleurRepository,PanierLengthService $panierLengthService): Response
    {
        $taille = $tailleRepository->find($tailleId);
        $tailles = $tailleRepository->findAll();
        $categories = $categoryRepository->findAll();
        $couleurs = $couleurRepository->findAll();
        $panierLength = $panierLengthService->getPanierLength();

        $baskets = $taille->getBasket();

        $searchData = new SearchData();

        $searchData->q = $request->query->get('q', '');

        $form = $this->createForm(SearchType::class, $searchData);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $baskets = $basketRepository->findBySearch($searchData);

            return $this->render('baskets.html.twig', [
                'form' => $form->createView(),
                'baskets' => $baskets,
                'categories' => $categories,
                'tailles' => $tailles,
                'couleurs' => $couleurs,
                'panierLength' =>$panierLength
            ]);
        }

        return $this->render('baskets.html.twig', [
            'form' => $form->createView(),
            'taille' => $taille,
            'tailles' => $tailles,
            'baskets' => $baskets,
            'categories' => $categories,
            'couleurs' => $couleurs,
            'panierLength' =>$panierLength
        ]);
    }
    #[Route('/baskets/couleur/{couleurId}', name: 'baskets_couleur')]
    public function basketsCouleur(Request $request, BasketRepository $basketRepository,$couleurId, CouleurRepository $couleurRepository, TailleRepository $tailleRepository, CategoryRepository $categoryRepository,PanierLengthService $panierLengthService)
    {
        $couleur = $couleurRepository->find($couleurId);
        $couleurs = $couleurRepository->findAll();
        $tailles = $tailleRepository->findAll();
        $categories = $categoryRepository->findAll();
        $panierLength = $panierLengthService->getPanierLength();

        $baskets = $couleur->getBasket();

        $searchData = new SearchData();

        $searchData->q = $request->query->get('q', '');

        $form = $this->createForm(SearchType::class, $searchData);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $baskets = $basketRepository->findBySearch($searchData);

            return $this->render('baskets.html.twig', [
                'form' => $form->createView(),
                'baskets' => $baskets,
                'categories' => $categories,
                'tailles' => $tailles,
                'couleurs' => $couleurs,
                'panierLength' =>$panierLength
            ]);
        }

        return $this->render('baskets.html.twig', [
            'form' => $form->createView(),
            'couleur' => $couleur,
            'couleurs' => $couleurs,
            'tailles' => $tailles,
            'baskets' => $baskets,
            'categories' => $categories,
            'panierLength' =>$panierLength
        ]);
    }
    #[Route('/mesLikes', name: 'mesLikes')]
    public function showMesLikes(LikesRepository $likesRepository, CategoryRepository $categoryRepository, PanierLengthService $panierLengthService): Response
    {
        $user = $this->getUser();
        $categories = $categoryRepository->findAll();
        $panierLength = $panierLengthService->getPanierLength();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $likes = $likesRepository->findBy(['user'=>$user]);
        return $this->render('likes.html.twig',[
            'likes' => $likes,
            'categories' => $categories,
            'panierLength' =>$panierLength,
        ]);
    }
    #[Route('/valider-panier', name: 'valider_panier')]
    public function validerPanier(EntityManagerInterface $entityManager, CategoryRepository $categoryRepository, PanierLengthService $panierLengthService): Response
    {
        $user = $this->getUser();
        $panierRepository = $entityManager->getRepository(Panier::class);
        $paniers = $panierRepository->findBy(['user' => $user]);

        foreach ($paniers as $panier) {
            $entityManager->remove($panier);
        }

        $entityManager->flush();
        $categories = $categoryRepository->findAll();
        $panierLength = $panierLengthService->getPanierLength();

        return $this->render('validation_panier.html.twig', [
            'categories' => $categories,
            'panierLength' => $panierLength,
            'paniers' => $paniers,
        ]);
    }

}
