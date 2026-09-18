<?php

namespace App\Controller;

use App\Entity\Track;
use App\Form\TrackType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TrackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

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
    #[Route('/track-create', name: 'app_track_item')]
    public function addTrack(EntityManagerInterface $em, Request $request): Response
    {

        $track = new Track();
        $form = $this->createForm(TrackType::class, $track);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
               $track->setCreatedAt(new \DateTimeImmutable());
            $em->persist($track);
            $em->flush();

            return $this->redirectToRoute('app_track');
        }
        return $this->render('track/new.html.twig', [
        'form' => $form,
    ]);
}
}