<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\UserFactory;
use App\Factory\AlbumFactory;
use App\Factory\ArtistFactory;
use App\Factory\GenreFactory;
use App\Factory\TrackFactory;
use App\Factory\PlaylistFactory;
use App\Factory\FavoriteFactory;
use App\Factory\HistoryFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createMany(100);
        AlbumFactory::createMany(30);
        ArtistFactory::createMany(100);

        $genres = [
            'Rock', 'Pop', 'Hip-Hop', 'Rap', 'Jazz', 'Blues', 'Reggae',
            'Metal', 'Punk', 'Electro', 'House', 'Techno', 'Funk',
            'Soul', 'RnB', 'Country', 'Classique', 'Folk', 'Disco',
        ];
       

        foreach ($genres as $genre) {
            GenreFactory::createOne([
                'name' => $genre,
            ]);
        }

        

        

        TrackFactory::createMany(50);
        PlaylistFactory::createMany(50);
        FavoriteFactory::createMany(80);
        HistoryFactory::createMany(50);

        $manager->flush();
    }
}