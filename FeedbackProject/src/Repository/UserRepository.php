<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
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
    public function createUserBasic ($username, $email, $password) 
    {
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER']);

        $this->saveChanges($user);
    }
    public function saveChanges (User $user, bool $flush = true): void
    {
        $this->getEntityManager()->persist($user);
        if ($flush) 
        {
            $this->getEntityManager()->flush();
        }
    }
    public function getUserDataARR(User $user): array
    {
        return [
            'id'=> $user->getId(),
            'username'=> $user->getUsername(),
            'email'=> $user->getEmail(),
            'name'=> $user->getName(),
            'phoneNumber' => $user->getPhoneNumber(),
        ];
    }


    public function getUserSDataFlexible(User $users, array $fields = null): array
    {
        if ($fields === null) 
        {
            $fields = ['id', 'username', 'emai', 'name', 'phoneNumber'];
        }
        if ($users instanceof User)
        {
            $users = [$users];
        }
        $result = [];
        foreach ($users as $user)
        {
            $userData = [];
            foreach ($fields as $field)
            {
                $getter = 'get'. ucfirst($field);
                if (method_exists($user, $getter))
                {
                    $userData[$field] = $user->$getter();
                }
            }
            $result[] = $userData;
        }
        return ($users instanceof User) ? $result[0] : $result;
    }

    public function removeUser (User $user, bool $flush = true): void
    {
        $this->getEntityManager()->remove($user);
        if ($flush)
        {
            $this->getEntityManager()->flush();
        }
    }

    public function findByemail(string $email): ?User
    {
        return $this->createQueryBuilder('u')
        ->where('u.email = :email')
        ->setParameter('email', $email)
        ->getQuery()
        ->getOneOrNullResult();
    }
    public function findByRole(string $roles): ?User
    {
        return $this->createQueryBuilder('u')
            ->where('u.roles = :r')
            ->setParameter('email', $roles)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
