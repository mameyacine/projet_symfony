<?php

namespace App\Repository;

use App\Entity\Course;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Course>
 *
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }
    public function findByThemes(array $themeIds): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.theme IN (:themes)')
            ->setParameter('themes', $themeIds)
            ->getQuery()
            ->getResult();
    }
    
    public function findCoursesByUser(User $user): array
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.users', 'u')
            ->where('u.id = :user_id')
            ->setParameter('user_id', $user->getId())
            ->getQuery()
            ->getResult();
    }
    public function findUserCourses(User $user): array
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.users', 'u')
            ->andWhere('u.id = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getResult();
    }

    public function searchByName(string $name): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.name LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->getQuery()
            ->getResult();
    }
    public function searchCoursesByUser(int $userId, string $query): array
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.users', 'u')
            ->andWhere('u.id = :userId')
            ->andWhere('c.name LIKE :query')
            ->setParameter('userId', $userId)
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
    }

    public function findSimilarCoursesByTheme(int $themeId): array
    {
        return $this->createQueryBuilder('c')
            ->join('c.theme', 't')
            ->where('t.id = :themeId')
            ->setParameter('themeId', $themeId)
            ->getQuery()
            ->getResult();
    }

    public function findCoursNonInscrits(User $user): array
    {
        // Récupérer les cours auxquels l'utilisateur est déjà inscrit
        $coursInscrits = $user->getCourses()->toArray();
    
        // Requête pour récupérer tous les cours auxquels l'utilisateur n'est pas encore inscrit
        $queryBuilder = $this->createQueryBuilder('c');
    
        if (!empty($coursInscrits)) {
            // Extraire les IDs des cours auxquels l'utilisateur est déjà inscrit
            $coursInscritIds = array_map(fn($course) => $course->getId(), $coursInscrits);
    
            // Exclure les cours auxquels l'utilisateur est déjà inscrit
            $queryBuilder->andWhere($queryBuilder->expr()->notIn('c.id', $coursInscritIds));
        }
    
        return $queryBuilder->getQuery()->getResult();
    }
    
    
//    /**
//     * @return Course[] Returns an array of Course objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Course
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }



}
