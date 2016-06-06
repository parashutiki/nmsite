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
    public function findAllOrdered()
    {
        return $this->findBy(array(), array('id' => 'DESC'));
    }

}
