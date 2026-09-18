<?php

namespace App\Controller;
use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AlbumRepository $albumRepository): Response
    {

    

    $albums = $albumRepository->findBy(['type' => 'album']);
        $eps = $albumRepository->findBy(['type' => 'ep']);
        $singles = $albumRepository->findBy(['type' => 'single']);

    //albumEps = 

    $user = $this->getUser();
    dump($user);

        return $this->render('home/index.html.twig', [
            'albums' => $albums,
            'eps' => $eps,
            'singles' => $singles,
        ]);
    }
}
