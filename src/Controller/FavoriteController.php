<?php

namespace App\Controller;

use App\Entity\Favorite;
use App\Entity\Track;
use App\Repository\FavoriteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class FavoriteController extends AbstractController
{
    #[Route('/track/{id}/favorite', name: 'app_favorite')]
    #[IsGranted('ROLE_USER')]
    public function addFavorite(Track $track, EntityManagerInterface $em, FavoriteRepository $favoriteRepository): Response
    {

        $user = $this->getUser();

        $existing = $favoriteRepository->findOneBy(['user' => $user, 'track' => $track]);

    if (!$existing) {
    $favorite = new Favorite();
    $favorite->setUser($user);
    $favorite->setTrack($track);
    $favorite->setCreatedAt(new \DateTimeImmutable());

    $em->persist($favorite);
    $em->flush();
    }

        return $this->redirectToRoute('app_track');
    }
}
