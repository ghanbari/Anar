<?php

namespace Anar\LinkBundle\Entity;

use Doctrine\ORM\EntityRepository;

class LinkRepository extends EntityRepository
{
    public function getFilterByBlogQueryBuilder($blogId)
    {
        $qb = $this->createQueryBuilder('l');
        $qb
            ->select(array('l', 'c'))
            ->join('l.category', 'c')
            ->where($qb->expr()->eq('c.blog', ':blogId'))
            ->setParameter('blogId', $blogId);

        return $qb;
    }

    public function getAllFilterByPosition($blogId, array $positions=array())
    {
        $qb = $this->createQueryBuilder('l');
        $qb
            ->select(array('l', 'c'))
            ->join('l.category', 'c')
            ->where($qb->expr()->eq('c.blog', ':blogId'))
            ->setParameter('blogId', $blogId);

        if (!empty($positions)) {
            $qb->andWhere($qb->expr()->in('c.position', ':positions'))
                ->setParameter('positions', $positions);
        }

        return $qb->getQuery()->getResult();
    }
}