<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class AdvertRepository extends EntityRepository
{

    /**
     * Ordered by ID.
     *
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('id' => 'DESC'));
    }

    /**
     * With documents.
     *
     * @return array
     */
    public function find($id)
    {
        $query = $this->createQueryBuilder('a')
                ->select('a', 'ad')
                ->leftJoin('a.advertDocuments', 'ad')
                ->where('a.id = :parameter')
                ->setParameter('parameter', $id)
                ->getQuery();

        return $query->getSingleResult();
    }

}
