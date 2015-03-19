<?php

namespace Anar\EngineBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class UserRepository extends EntityRepository
{
    public function getUsersFilterBy($filters)
    {
        $query = $this->getUsersQueryFilterBy($filters);
        return $query->getResult(Query::HYDRATE_ARRAY);
    }

    /**
     * @param $filters
     * @return Query
     */
    public function getUsersQueryFilterBy($filters)
    {
        $qb = $this->createQueryBuilder('u')->select(array('u', 'g'));
        $qb->innerJoin('u.grade', 'g');
        $qb->where($qb->expr()->eq('u.enabled', ':enabled'));
        $qb->andWhere($qb->expr()->eq('u.expired', ':expired'));

        $qb->setParameter('enabled', $filters['enabled']);
        $qb->setParameter('expired', $filters['expired']);

        if (!empty($filters['username']) or !empty($filters['email'])) {
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->eq('u.username', ':username'),
                $qb->expr()->eq('u.email', ':email')
            ));
            $qb->setParameter('username', $filters['username']);
            $qb->setParameter('email', $filters['email']);
        }

        if (!empty($filters['fname']) and !empty($filters['lname'])) {
            $qb->andWhere($qb->expr()->andX(
                $qb->expr()->eq('u.fname', ':fname'),
                $qb->expr()->eq('u.lname', ':lname')
            ));
            $qb->setParameter('fname', $filters['fname']);
            $qb->setParameter('lname', $filters['lname']);
        } elseif (!empty($filters['fname'])) {
            $qb->andWhere($qb->expr()->like('u.fname', ':fname'));
            $qb->setParameter('fname', $filters['fname']);
        } elseif (!empty($filters['lname'])) {
            $qb->andWhere($qb->expr()->like('u.lname', ':lname'));
            $qb->setParameter('lname', $filters['lname']);
        }

        return $qb->getQuery();
    }
}