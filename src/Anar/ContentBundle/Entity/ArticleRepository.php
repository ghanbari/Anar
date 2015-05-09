<?php

namespace Anar\ContentBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository
{
    public function getFilterByBlogQueryBuilder($blogId)
    {
        $qb = $this->createQueryBuilder('a');

        return $qb->select('a')
            ->where($qb->expr()->eq('a.blog', ':blogId'))
            ->setParameter('blogId', $blogId);
    }

    public function getFilterByBlogQuery($blogId)
    {
        return $this->getFilterByBlogQueryBuilder($blogId)->getQuery();
    }

    public function getAllFullJoinFilterByBlogQuery($blogId)
    {
        return $this->getFilterByBlogQueryBuilder($blogId)
            ->select(array('a', 'c', 'author', 'editor'))
            ->leftJoin('a.author', 'author')
            ->leftJoin('a.editor', 'editor')
            ->leftJoin('a.category', 'c')
            ->getQuery();
    }

    public function getAllFullJoinFilterByBlogAndCategoryQuery($blogId, $categorySlug)
    {
        $qb = $this->getFilterByBlogQueryBuilder($blogId);
        return $qb->select(array('a', 'c', 'author', 'editor'))
            ->leftJoin('a.author', 'author')
            ->leftJoin('a.editor', 'editor')
            ->leftJoin('a.category', 'c')
            ->andWhere($qb->expr()->eq('c.slug', ':slug'))
            ->setParameter('slug', $categorySlug)
            ->getQuery();
    }
    public function getFilterByBlog($blogId, $limit=10, $offset=1)
    {
        return $this->getFilterByBlogQuery($blogId)
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getResult();
    }

    public function getAllJoinBlogFilterByBlog($blogId, $order, $limit=10, $offset=1)
    {
        $qb = $this->getFilterByBlogQueryBuilder($blogId)
            ->select(array('a', 'b'))
            ->join('a.blog', 'b')
            ->setMaxResults($limit)
            ->setFirstResult($offset);

        foreach ($order as $field => $dir) {
            $qb->addOrderBy($field, $dir);
        }
        return $qb->getQuery()->getResult();
    }

    public function getAllFilterByBlog($blogId)
    {
        return $this->getFilterByBlogQuery($blogId)
            ->getResult();
    }
}
