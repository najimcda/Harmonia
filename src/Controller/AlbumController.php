<?php

namespace App\Controller;
use App\Entity\Album;
use App\Entity\Artist;
use App\Form\AlbumType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AlbumController extends AbstractController
{
    #[Route('/album/{id}', name: 'app_album_show')]
    public function show(Album $album): Response
    {
        return $this->render('album/show.html.twig', [
            'album' => $album,
        ]);

        
    }
    #[Route('/album-create/{artist_id}', name: 'app_album_item')]
    public function addAlbum(#[MapEntity(id: 'artist_id')] Artist $artist,
        EntityManagerInterface $em,
        Request $request): Response
    {

        $album = new Album();
        $album->setArtist($artist);

        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
               $album->setCreatedAt(new \DateTimeImmutable());

            $em->persist($album);
            $em->flush();

            return $this->redirectToRoute('app_artist_show' , ['id' => $artist->getId()]);
        }
        return $this->render('album/new.html.twig', [
        'form' => $form,
        'artist' => $artist,
    ]);
}
}
