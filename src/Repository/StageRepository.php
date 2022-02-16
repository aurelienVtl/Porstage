<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }
	
	
	public function findToutLesStages()
    {
      return $this->createQueryBuilder('s')
			->select('s','e','f')
			->join('s.entreprise','e')
			->join('s.formations','f')
            ->getQuery()
            ->getResult()
        ;
    }
	
	public function findStagesDeLEntreprise($value)
    {
      return $this->createQueryBuilder('s')
			->join('s.entreprise','e')
            ->andWhere('e.nom =  :entreprise')
            ->setParameter('entreprise', $value)
            ->getQuery()
            ->getResult()
        ;
    }
	
	public function findStagesDeLaFormation($value)
    {
      $gestionnaireEntite=$this->getEntityManager();
	  $requete=$gestionnaireEntite->createQuery("
			SELECT s,f,e from App\Entity\Stage s join s.formations f join s.entreprise e where :nom = f.nom");
		
		$requete->setParameter('nom',$value);
		
		return $requete->execute();
        ;
    }

    // /**
    //  * @return Stage[] Returns an array of Stage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
