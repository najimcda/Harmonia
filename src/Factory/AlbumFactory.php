<?php

namespace App\Factory;

use App\Entity\Album;
use App\Factory\ArtistFactory;
use App\Repository\AlbumRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentObjectFactory<Album>
 */
final class AlbumFactory extends PersistentObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    #[\Override]
    public static function class(): string
    {
        return Album::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    #[\Override]
    protected function defaults(): array|callable
    {
            $type = [
                "ep",
                "album",
                "single",
            ];

            $jackets = [
        '1.jpeg',
        '2.jpeg',
        '3.jpeg',
        '4.jpeg',
        '5.jpeg',
        '6.jpeg',
        '7.jpeg',
        '8.jpeg',
        '9.jpeg',
        '10.jpeg',
    ];

        return [
            'artist' => ArtistFactory::new(),            
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'duration' => self::faker()->randomNumber(),
            'isExplicit' => self::faker()->boolean(),
            'pistNumber' => self::faker()->randomNumber(),
            'titre' => self::faker()->text(255),
            'type' => self::faker()->randomElement($type),
            'jacket' => "uploads/" . self::faker()->randomElement($jackets),
            
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Album $album): void {})
        ;
    }
}
