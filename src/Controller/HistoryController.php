<?php

namespace App\Controller;

use App\Entity\History;
use App\Entity\Track;
use App\Repository\HistoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class HistoryController extends AbstractController
{
    #[Route('/track/{id}/history', name: 'app_history')]
    #[IsGranted('ROLE_USER')]
    public function addHistory(Track $track, EntityManagerInterface $em, HistoryRepository $historyRepository): Response
    {
        $user = $this->getUser();

        $history = $historyRepository->findOneBy(['user' => $user]);

        if (!$history) {
            $history = new History();
            $history->setUser($user);
            $history->setCreatedAt(new \DateTimeImmutable());
            $em->persist($history);
        }

        $history->setTrack($track);
        $em->flush();

        return $this->redirectToRoute('app_track');
    }
}