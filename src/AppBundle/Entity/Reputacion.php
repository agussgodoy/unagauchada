<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reputacion
 *
 * @ORM\Table(name="reputacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReputacionRepository")
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
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var int
     *
     * @ORM\Column(name="minimo", type="integer")
     */
    private $minimo;

    /**
     * @var int
     *
     * @ORM\Column(name="maximo", type="integer")
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
     * Set minimo
     *
     * @param integer $minimo
     * @return Reputacion
     */
    public function setMinimo($minimo)
    {
        $this->minimo = $minimo;
    
        return $this;
    }

    /**
     * Get minimo
     *
     * @return integer 
     */
    public function getMinimo()
    {
        return $this->minimo;
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
