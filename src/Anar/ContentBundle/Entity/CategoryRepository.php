<?php

namespace Anar\ContentBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function getQueryFilterByBlog($blogId)
    {
        $qb = $this->createQueryBuilder('c');

        return $qb->select('c')
            ->where($qb->expr()->eq('c.blog', ':blogId'))
            ->setParameter('blogId', $blogId)
            ->getQuery();
    }

    public function getFilterByBlog($blogId, $limit = 10, $offset = 1)
    {
        return $this->getQueryFilterByBlog($blogId)
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getResult();
    }

    public function getAllFilterByBlog($blogid)
    {
        return $this->getQueryFilterByBlog($blogid)
            ->getResult();
    }
}