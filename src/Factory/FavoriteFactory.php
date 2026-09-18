<?php

namespace App\Factory;

use App\Entity\Favorite;
use App\Repository\FavoriteRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;
use App\Factory\TrackFactory;
use App\Factory\UserFactory;

/**
 * @extends PersistentObjectFactory<Favorite>
 */
final class FavoriteFactory extends PersistentObjectFactory
{
    public function __construct()
    {
    }

    #[\Override]
    public static function class(): string
    {
        return Favorite::class;
    }

    #[\Override]
    protected function defaults(): array|callable
    {
        return [
            'track' => TrackFactory::random(),
            'user' => UserFactory::random(),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    #[\Override]
    protected function initialize(): static
    {
        return $this
        ;
    }
}