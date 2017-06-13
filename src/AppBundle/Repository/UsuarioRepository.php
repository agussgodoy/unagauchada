<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * UsuarioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UsuarioRepository extends EntityRepository
{
	public function existeUsuario($mail, $apellido, $nombre)
	{
		$query = $this->createQueryBuilder('u')
			->select('COUNT(u)')
		    ->where('u.email = :mail')
		    ->orWhere('u.apellido = :ape and u.nombre = :nom')
		    ->setParameter('mail', $mail)
		    ->setParameter('ape', $apellido)
		    ->setParameter('nom', $nombre);
	    
	    return $query->getQuery()->getSingleScalarResult();
	}
}
