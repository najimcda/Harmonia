<?php

namespace App\Controller;
use App\Entity\Artist;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ArtistRepository;
use App\Form\ArtistType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class ArtistController extends AbstractController
{
    #[Route('/artist', name: 'app_artist')]
    public function index(ArtistRepository $artistRepository): Response
    {
        $artists = $artistRepository->findAll();

        return $this->render('artist/index.html.twig', [
            'artists' => $artists,
        ]);
    }

    #[Route('/artist/{id}', name: 'app_artist_show')]
    public function show(Artist $artist): Response
    {
        return $this->render('artist/show.html.twig', [
            'artist' => $artist,
        ]);
    }

    #[Route('/artist-create', name: 'app_artist_item')]
    public function addArtist(EntityManagerInterface $em, Request $request): Response
    {

        $artist = new Artist();
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
               $artist->setCreatedAt(new \DateTimeImmutable());
            $em->persist($artist);
            $em->flush();

            return $this->redirectToRoute('app_artist');
        }

        return $this->render('artist/new.html.twig', [
        'form' => $form,
    ]);
}

#[Route('/artist/{id}/edit', name: 'app_artist_edit')]
public function edit(Artist $artist, Request $request, EntityManagerInterface $em): Response
{
    $form = $this->createForm(ArtistType::class, $artist);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();

        return $this->redirectToRoute('app_artist_show', ['id' => $artist->getId()]);
    }

    return $this->render('artist/edit.html.twig', [
        'form' => $form,
        'artist' => $artist,
    ]);
}
}