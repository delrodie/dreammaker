<?php

namespace AppBundle\Repository;

/**
 * ArtisteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArtisteRepository extends \Doctrine\ORM\EntityRepository
{
    public function findArtiste($limit = null)
    {
        if ($limit){
            return $this->createQueryBuilder('a')
                ->orderBy('a.id', 'DESC')
                ->setMaxResults($limit)
                ->getQuery()->getResult()
                ;
        }else{
            return $this->createQueryBuilder('a')
                ->orderBy('a.id', 'DESC')
                ->getQuery()->getResult()
                ;
        }
    }

    /**
     * Liste alphabetique des artistes
     */
    public function findList()
    {
        return $this->liste()
                    ->getQuery()->getResult()
            ;
    }

    /**
     * Requete de la liste des artistes
     */
    public function liste()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.pseudonyme', 'ASC')
            ;
    }
}
