<?php

namespace Anar\EngineBundle\Entity;

use Doctrine\ORM\EntityRepository;

class GroupRepository extends EntityRepository
{
    public function get($groupId)
    {
        $qb = $this->createQueryBuilder('g')
            ->select(array('g', 'u', 'r'));

        return $qb->join('g.users', 'u')
            ->join('g.roles', 'r')
            ->where($qb->expr()->eq('g.id', '?1'))
            ->setParameter(1, $groupId)
            ->getQuery()->getSingleResult();
    }
}