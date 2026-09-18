<?php

namespace App\Factory;

use App\Entity\History;
use App\Repository\HistoryRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;
use App\Factory\TrackFactory;
use App\Factory\UserFactory;

/**
 * @extends PersistentObjectFactory<History>
 */
final class HistoryFactory extends PersistentObjectFactory
{
    public function __construct()
    {
    }

    #[\Override]
    public static function class(): string
    {
        return History::class;
    }

    #[\Override]
    protected function defaults(): array|callable
    {
        return [
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'track' => TrackFactory::random(),
            'user' => UserFactory::random(),
        ];
    }

    #[\Override]
    protected function initialize(): static
    {
        return $this
        ;
    }
}