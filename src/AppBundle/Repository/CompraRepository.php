<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CompraRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CompraRepository extends EntityRepository
{

	public function buscar($desde, $hasta)
	{
		$query = $this->createQueryBuilder('c')
		->where('c.fecha between :f1 and :f2')
		->setParameter('f1', $desde)
		->setParameter('f2', $hasta);

		return $query->getQuery()->getResult();
	}
}
