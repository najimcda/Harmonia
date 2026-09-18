<?php

namespace App\Factory;

use App\Entity\Track;
use App\Repository\TrackRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;
use App\Factory\AlbumFactory;
use App\Factory\HistoryFactory;
use App\Factory\GenreFactory;

/**
 * @extends PersistentObjectFactory<Track>
 */
final class TrackFactory extends PersistentObjectFactory
{
    public function __construct()
    {
    }

    #[\Override]
    public static function class(): string
    {
        return Track::class;
    }

    #[\Override]
    protected function defaults(): array|callable
    {
        return [
            'album' => AlbumFactory::random(),
            'history' => HistoryFactory::new(),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'duration' => self::faker()->randomNumber(),
            'name' => self::faker()->text(30),
            'genres' => GenreFactory::randomRange(1, 3),
        ];
    }

    #[\Override]
    protected function initialize(): static
    {
        return $this
        ;
    }
}