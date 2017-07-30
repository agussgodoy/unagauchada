<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calificacion
 *
 * @ORM\Table(name="calificacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CalificacionRepository")
 */
class Calificacion
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
     * @var int
     *
     * @ORM\Column(name="puntaje", type="integer", nullable=true)
     */
    private $puntaje;


     /**
     * Muchas calificaciones pueden ser de un mismo usuario
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="calificacionesDadas")
     * @ORM\JoinColumn(name="usuario_autor_id", referencedColumnName="id")
     */
    private $usuarioAutor;


    /**
     * Muchas calificaciones pueden ser de un mismo usuario
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="calificacionesRecibidas")
     * @ORM\JoinColumn(name="usuario_calificado_id", referencedColumnName="id")
     */
    private $usuarioCalificado;

    /**
     * Una calificacion corresponde a un Favor
     * @ORM\OneToOne(targetEntity="Favor")
     * @ORM\JoinColumn(name="favor_id", referencedColumnName="id")
     */
    private $favor;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", nullable=true)
     */
    private $descripcion;

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
     * Set puntaje
     *
     * @param integer $puntaje
     * @return Calificacion
     */
    public function setPuntaje($puntaje)
    {
        $this->puntaje = $puntaje;

        return $this;
    }

    /**
     * Get puntaje
     *
     * @return integer 
     */
    public function getPuntaje()
    {
        return $this->puntaje;
    }

    /**
     * Set usuarioAutor
     *
     * @param \AppBundle\Entity\Usuario $usuarioAutor
     * @return Calificacion
     */
    public function setUsuarioAutor(\AppBundle\Entity\Usuario $usuarioAutor = null)
    {
        $this->usuarioAutor = $usuarioAutor;

        return $this;
    }

    /**
     * Get usuarioAutor
     *
     * @return \AppBundle\Entity\Usuario 
     */
    public function getUsuarioAutor()
    {
        return $this->usuarioAutor;
    }

    /**
     * Set usuarioCalificado
     *
     * @param \AppBundle\Entity\Usuario $usuarioCalificado
     * @return Calificacion
     */
    public function setUsuarioCalificado(\AppBundle\Entity\Usuario $usuarioCalificado = null)
    {
        $this->usuarioCalificado = $usuarioCalificado;

        return $this;
    }

    /**
     * Get usuarioCalificado
     *
     * @return \AppBundle\Entity\Usuario 
     */
    public function getUsuarioCalificado()
    {
        return $this->usuarioCalificado;
    }

    /**
     * Set favor
     *
     * @param \AppBundle\Entity\Favor $favor
     * @return Calificacion
     */
    public function setFavor(\AppBundle\Entity\Favor $favor = null)
    {
        $this->favor = $favor;

        return $this;
    }

    /**
     * Get favor
     *
     * @return \AppBundle\Entity\Favor 
     */
    public function getFavor()
    {
        return $this->favor;
    }

    public function __toString(){
        return $this->getDescripcion();
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Calificacion
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
}
