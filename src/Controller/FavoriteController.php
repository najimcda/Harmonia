<?php

namespace App\Controller;

use App\Entity\Favorite;
use App\Entity\Track;
use App\Repository\FavoriteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class FavoriteController extends AbstractController
{
    #[Route('/track/{id}/favorite', name: 'app_favorite', methods: ['POST', 'GET'])]
    #[IsGranted('ROLE_USER')]
    public function toggleFavorite(
        Track $track, 
        EntityManagerInterface $em, 
        FavoriteRepository $favoriteRepository,
        Request $request
    ): Response {
        $user = $this->getUser();

        // 1. On cherche si le favori existe déjà
        $existing = $favoriteRepository->findOneBy([
            'user' => $user, 
            'track' => $track
        ]);

        if ($existing) {
            // S'il existe -> On le SUPPRIME
            $em->remove($existing);
            $this->addFlash('info', 'Musique retirée de vos favoris.');
        } else {
            // S'il n'existe pas -> On l'AJOUTE
            $favorite = new Favorite();
            $favorite->setUser($user);
            $favorite->setTrack($track);
            $favorite->setCreatedAt(new \DateTimeImmutable());

            $em->persist($favorite);
            $this->addFlash('success', 'Musique ajoutée à vos favoris !');
        }

        $em->flush();

        // Redirige sur la page précédente (referer) ou vers la liste des tracks par défaut
        $referer = $request->headers->get('referer');
        return $this->redirect($referer ?: $this->generateUrl('app_track'));
    }
}