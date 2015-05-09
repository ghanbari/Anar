<?php

namespace Anar\ContentBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function getFilterByBlogQuery($blogId)
    {
        $qb = $this->createQueryBuilder('c');

        return $qb->select('c')
            ->where($qb->expr()->eq('c.blog', ':blogId'))
            ->setParameter('blogId', $blogId)
            ->getQuery();
    }

    public function getFilterByBlog($blogId, $limit = 10, $offset = 1)
    {
        return $this->getFilterByBlogQuery($blogId)
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getResult();
    }

    public function getAllFilterByBlog($blogid)
    {
        return $this->getFilterByBlogQuery($blogid)
            ->getResult();
    }
}