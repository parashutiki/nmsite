<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class AdvertDocumentRepository extends EntityRepository
{

    /**
     * With advert.
     *
     * @return array
     */
    public function find($id)
    {
        $query = $this->createQueryBuilder('ad')
                ->innerJoin('ad.advert', 'a')
                ->innerJoin('a.user', 'u')
                ->where('a.uuid = :parameter')
                ->setParameter('parameter', $id)
                ->getQuery();

        return $query->getSingleResult();
    }

}
