<?php


namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PanierRepository;
use Symfony\Component\Security\Core\Security;
use App\Entity\Panier;

class PanierLengthService
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function getPanierLength(): int
    {
        $user = $this->security->getUser();
        if (!$user) {
            return 0;
        }

        $panierRepository = $this->entityManager->getRepository(Panier::class);
        return $panierRepository->countBasketDansPanier($user);
    }
}
