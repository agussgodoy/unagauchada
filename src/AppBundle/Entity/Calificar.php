<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Calificar
 *
 * @ORM\Table(name="calificar")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CalificarRepository")
 * @UniqueEntity("descripcion", message="Ya existe una calificación con ese nombre.")
 * @UniqueEntity("puntos", message="Ya existe una calificación con ese puntaje.")
 */
class Calificar
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
     * @ORM\Column(name="puntos", type="integer", unique=true)
     */
    private $puntos;


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
     * @return Calificar
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
     * Set puntos
     *
     * @param integer $puntos
     * @return Calificar
     */
    public function setPuntos($puntos)
    {
        $this->puntos = $puntos;
    
        return $this;
    }

    /**
     * Get puntos
     *
     * @return integer 
     */
    public function getPuntos()
    {
        return $this->puntos;
    }

    public function __toString(){
        return $this->getDescripcion();
    }
}
