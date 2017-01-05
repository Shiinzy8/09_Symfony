<?php

namespace AppBundle\Repository;

/**
 * ItemRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ItemRepository extends \Doctrine\ORM\EntityRepository
{
    public function findMy($id)
    {
//        $this->createQueryBuilder('a');
        $query = $this
            ->createQueryBuilder('i')
            ->where('i.id > :id')
            ->orderBy('i.name','DESC')
            ->setParameter('id',$id)
            ->getQuery()
        ;
        return $query->getResult();
    }

}
