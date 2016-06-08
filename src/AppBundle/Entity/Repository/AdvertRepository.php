<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\User;

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
     * Ordered by ID.
     *
     * @return array
     */
    public function findAllOwn(User $user)
    {
        return $this->findBy(array(
                    'user' => $user->getId(),
                        ), array(
                    'id' => 'DESC',
        ));
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
