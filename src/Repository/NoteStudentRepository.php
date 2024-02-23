<?php

namespace App\Repository;

use App\Entity\NoteStudent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NoteStudent>
 *
 * @method NoteStudent|null find($id, $lockMode = null, $lockVersion = null)
 * @method NoteStudent|null findOneBy(array $criteria, array $orderBy = null)
 * @method NoteStudent[]    findAll()
 * @method NoteStudent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteStudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NoteStudent::class);
    }
    public function countAttemptsByUserAndQCM(int $userId, int $qcmId): int
    {
        return $this->createQueryBuilder('ns')
            ->select('COUNT(ns)')
            ->andWhere('ns.users = :userId')
            ->andWhere('ns.QCMs = :qcmId') // Utilisez le nom correct de la propriété associée à QCM
            ->setParameter('userId', $userId)
            ->setParameter('qcmId', $qcmId)
            ->getQuery()
            ->getSingleScalarResult();
    }
    public function findScoreByUserAndQCM(int $userId, int $qcmId): ?float
    {
        $result = $this->createQueryBuilder('ns')
            ->select('ns.score') // Sélectionnez uniquement le score
            ->andWhere('ns.users = :userId')
            ->andWhere('ns.QCMs = :qcmId')
            ->setParameter('userId', $userId)
            ->setParameter('qcmId', $qcmId)
            ->getQuery()
            ->getOneOrNullResult();
    
        // Assurez-vous que le résultat retourné est un nombre flottant
        if ($result !== null) {
            // Si le résultat est un objet NoteStudent, accédez à la propriété score
            if (is_object($result) && method_exists($result, 'getScore')) {
                return (float) $result->getScore();
            }
            // Si le résultat est un tableau associatif, accédez directement à la valeur du score
            if (is_array($result) && isset($result['score'])) {
                return (float) $result['score'];
            }
        }
    
        return null;
    }
    
    
    
    

//    /**
//     * @return NoteStudent[] Returns an array of NoteStudent objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NoteStudent
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
