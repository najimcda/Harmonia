<?php

namespace App\Controller;
use App\Entity\Album;
use App\Entity\Artist;
use App\Form\AlbumType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


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
        Request $request, SluggerInterface $slugger, #[Autowire('%kernel.project_dir%/public/uploads')]string $albumsDirectory): Response
    {

        $album = new Album();
        $album->setArtist($artist);

        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
               $album->setCreatedAt(new \DateTimeImmutable());
               

            

            $jacketFile = $form->get('jacketFile')->getData();
        

        if ($jacketFile) {
                $originalFilename = pathinfo($jacketFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$jacketFile->guessExtension();

                $jacketFile->move($albumsDirectory, $newFilename);

                $album->setJacket('uploads/' . $newFilename);
        }
        
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
