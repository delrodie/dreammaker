<?php

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findListASC(){
        return $this->createQueryBuilder('u')
            ->where('u.username <> :username')
            ->orderBy('u.username', 'ASC')
            ->setParameter('username', 'delrodie')
            ->getQuery()->getResult()
            ;
    }
}
