<?php

namespace App\Repository;

use App\Entity\Dto\User as DtoUser;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }

    /**
     * Get visiteur offre filter
     * @return PaginationInterface
     */
    public function adminSearch(DtoUser $search): PaginationInterface
    {
        $limit = 24;

        $query = $this->createQueryBuilder('u')
            ->orderBy('u.created', 'DESC');

        if (!empty($search->getQuery())) {
            $query = $query
                ->andWhere('u.nom LIKE :query')
                ->orWhere('u.prenom LIKE :prenom')
                ->orWhere('u.email LIKE :email')
                ->setParameters([
                    'query' => "%{$search->getQuery()}%",
                    'prenom' => "%{$search->getQuery()}%",
                    'email' => "%{$search->getQuery()}%",
                ]);
        }

        if (!empty($search->getIsVerified())) {
            $query = $query
                ->andWhere('u.isVerified = :isVerified')
                ->setParameter('isVerified', $search->getIsVerified());
        }

        if (!empty($search->getCompte())) {
            $query = $query
                ->andWhere('u.compte = :compte')
                ->setParameter('compte', $search->getCompte());
        }

        if (!empty($search->getLimit())) {
            $limit = $search->getLimit();
        }

        if (!empty($search->getMinDate())) {
            $query = $query
                ->where('u.created >= :from')
                ->setParameter('from', $search->getMinDate());
        }

        if (!empty($search->getMaxDate())) {
            $query = $query
                ->andWhere('u.created <= :to')
                ->setParameter('to', $search->getMaxDate());
        }

        return $this->paginator->paginate(
            $query,
            $search->page,
            $limit
        );
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
