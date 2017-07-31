<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Reputacion
 *
 * @ORM\Table(name="reputacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReputacionRepository")
 * @UniqueEntity("descripcion", message="La reputación que intenta ingresar ya existe.")
 * @UniqueEntity("maximo", message="Ya existe una reputación con ese puntaje.")
 */
class Reputacion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, unique=true)
     */
    private $descripcion;


    /**
     * @var int
     *
     * @ORM\Column(name="maximo", type="integer", unique=true)
     */
    private $maximo;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Reputacion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set maximo
     *
     * @param integer $maximo
     * @return Reputacion
     */
    public function setMaximo($maximo)
    {
        $this->maximo = $maximo;
    
        return $this;
    }

    /**
     * Get maximo
     *
     * @return integer 
     */
    public function getMaximo()
    {
        return $this->maximo;
    }
}
