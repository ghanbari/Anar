<?php

namespace Anar\LinkBundle\Entity;

use Doctrine\ORM\EntityRepository;

class LinkRepository extends EntityRepository
{
    public function getFilterByBlogQueryBuilder($blogId)
    {
        $qb = $this->createQueryBuilder('l');
        $qb
            ->select('l')
            ->where($qb->expr()->eq('l.blog', ':blogId'))
            ->setParameter('blogId', $blogId);

        return $qb;
    }
}