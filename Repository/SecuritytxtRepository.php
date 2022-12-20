<?php
/*
 * This file is part of the Sulu Securitytxt bundle.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace BitExpert\Sulu\SecuritytxtBundle\Repository;

use BitExpert\Sulu\SecuritytxtBundle\Entity\Securitytxt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Securitytxt>
 */
class SecuritytxtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Securitytxt::class);
    }

    public function create(): Securitytxt
    {
        $entity = new Securitytxt();

        $this->getEntityManager()->persist($entity);

        return $entity;
    }

    /**
     * @throws ORMException
     */
    public function remove(int $id): void
    {
        /** @var object $entity */
        $entity = $this->getEntityManager()->getReference(
            $this->getClassName(),
            $id,
        );

        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    public function save(Securitytxt $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function findById(int $id): ?Securitytxt
    {
        return $this->find($id);
    }

    public function findByWebspaceKey(string $webspaceKey): ?Securitytxt
    {
        return $this->findOneBy(['webspace_key' => $webspaceKey]);
    }
}
