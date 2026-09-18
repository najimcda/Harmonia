<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TrackRepository;

final class TrackController extends AbstractController
{
    #[Route('/track', name: 'app_track')]
    public function index(TrackRepository $trackRepository): Response
    {
        $tracks = $trackRepository->findAll();

        return $this->render('track/index.html.twig', [
            'tracks' => $tracks,
        ]);
    }
}