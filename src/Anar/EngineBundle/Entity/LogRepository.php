<?php

namespace Anar\EngineBundle\Entity;

use Doctrine\ORM\EntityRepository;

class LogRepository extends EntityRepository
{
    public function getFilterByBlogQueryBuilder($blogId)
    {
        $qb = $this->createQueryBuilder('l');

        return $qb->where($qb->expr()->eq('l.blog', '?1'))
            ->setParameter(1, $blogId);
    }
}