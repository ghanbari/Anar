<?php

namespace Anar\EngineBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;

class UserRepository extends EntityRepository
{
    public function getUsersFilterBy($filters)
    {
        $query = $this->getUsersQueryFilterBy($filters);
        return $query->getResult(Query::HYDRATE_ARRAY);
    }

    /**
     * @param array $filters array('enabled', 'expired', 'username', 'email', 'fname', 'lname')
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

        if (!empty($filters['grade'])) {
            $qb->andWhere($qb->expr()->eq('u.grade', ':grade'))
                ->setParameter('grade', $filters['grade']);
        }

        if (!empty($filters['staffCode'])) {
            $qb->andWhere($qb->expr()->eq('u.staffCode', ':staffCode'))
                ->setParameter('staffCode', $filters['staffCode']);
        }

        return $qb->getQuery();
    }

    /**
     * @param int $userId
     * @param bool $onlyOwner
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getBlogsQueryBuilder($userId, $onlyOwner=true)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('b')
            ->from('AnarEngineBundle:Blog', 'b')
            ->join('b.groups', 'g')
            ->join('g.roles', 'r')
            ->where($qb->expr()->isMemberOf(':userId', 'g.users'))
            ->setParameter('userId', $userId);

        if ($onlyOwner) {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->eq('r.role', "'ROLE_ADMIN'"),
                    $qb->expr()->isNotNull('r.app')
                )
            );
        }

        return $qb;
    }

    /**
     * @param int $userId
     * @param bool $onlyOwner
     * @return Query
     */
    public function getBlogsQuery($userId, $onlyOwner=true)
    {
        return $this->getBlogsQueryBuilder($userId, $onlyOwner)->getQuery();
    }

    public function getRolesQueryBuilderFilterByBlog($userId, $blogId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        return $qb->select('r.role')
            ->from('AnarEngineBundle:Role', 'r')
            ->join('r.groups', 'g')
            ->join('g.users', 'u')
            ->join('g.blog', 'b')
            ->where($qb->expr()->eq('g.blog', ':blogId'))
            ->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->isMemberOf('r.app', 'b.apps'),
                    $qb->expr()->isNull('r.app')
                )
            )
            ->andWhere($qb->expr()->eq('u.id', ':userId'))
            ->setParameter('blogId', $blogId)
            ->setParameter('userId', $userId);
    }

    public function getRolesQueryFilterByBlog($userId, $blogId)
    {
        return $this->getRolesQueryBuilderFilterByBlog($userId, $blogId)->getQuery();
    }

    public function getRolesFilterByBlog($userId, $blogId)
    {
        $roles = array();
        foreach ($this->getRolesQueryFilterByBlog($userId, $blogId)->getArrayResult() as $role) {
            $roles[] = $role['role'];
        }
        return $roles;
    }
}