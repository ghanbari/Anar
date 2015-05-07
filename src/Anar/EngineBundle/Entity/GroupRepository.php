<?php

namespace Anar\EngineBundle\Entity;

use Doctrine\ORM\EntityRepository;

class GroupRepository extends EntityRepository
{
    public function get($groupId)
    {
        $qb = $this->createQueryBuilder('g')
            ->select(array('g', 'u', 'r'));

        return $qb->leftJoin('g.users', 'u')
            ->leftJoin('g.roles', 'r')
            ->where($qb->expr()->eq('g.id', '?1'))
            ->andWhere($qb->expr()->eq('g.locked', '?2'))
            ->setParameter(1, $groupId)
            ->setParameter(2, false)
            ->getQuery()->getSingleResult();
    }

    public function getAllFilterByBlog($blogId)
    {
        $qb = $this->createQueryBuilder('g')
            ->select(array('g', 'u', 'r'));

        return $qb->leftJoin('g.users', 'u')
            ->leftJoin('g.roles', 'r')
            ->where($qb->expr()->eq('g.blog', '?1'))
            ->andWhere($qb->expr()->eq('g.locked', '?2'))
            ->setParameter(1, $blogId)
            ->setParameter(2, false)
            ->getQuery()->getResult();
    }

    public function resetDefaultForBlog($blogId)
    {
        $this->createQueryBuilder('g')
            ->update()
            ->set('g.default', ':disable')
            ->where('g.blog = :blogId')
            ->setParameter('disable', false)
            ->setParameter('blogId', $blogId)
            ->getQuery()->execute();
    }
}