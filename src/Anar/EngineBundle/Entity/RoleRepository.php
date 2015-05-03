<?php

namespace Anar\EngineBundle\Entity;

use Doctrine\ORM\EntityRepository;

class RoleRepository extends EntityRepository
{
    public function getRolesHierachy($roles)
    {
        $roleIds = array_map(function ($role) {return $role->getId();}, $roles);

        $qb = $this->createQueryBuilder('r');
        $qb->select('r')
            ->where($qb->expr()->in('r.parent', '?1'))
            ->setParameter(1, $roleIds);

        return array_merge($roles, $qb->getQuery()->getResult());
    }
}