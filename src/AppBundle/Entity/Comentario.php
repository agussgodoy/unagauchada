<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comentario
 *
 * @ORM\Table(name="comentario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ComentarioRepository")
 */
class Comentario
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
     * @ORM\Column(name="detalle", type="string", length=255)
     */
    private $detalle;

    /**
     * Un comentario corresponde a un Usuario
     * @ORM\OneToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(name="usuario_autor_id", referencedColumnName="id")
     */
    private $autor;

    /**
     * Un comentario tiene muchas respuestas
     * @ORM\OneToMany(targetEntity="Comentario", mappedBy="respondeA")
     */
    private $respuestas;


    /**
     * Muchas comentarios responden a un Comentario
     * @ORM\ManyToOne(targetEntity="Comentario", inversedBy="respuestas")
     * @ORM\JoinColumn(name="respondeA_comentario_id", referencedColumnName="id")
     */
    private $respondeA;

     /**
     * Muchos Comentarios corresponden a un mismo Favor 
     * @ORM\ManyToOne(targetEntity="Favor", inversedBy="comentarios")
     * @ORM\JoinColumn(name="favor_id", referencedColumnName="id")
     */
    private $favor;

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
     * Set detalle
     *
     * @param string $detalle
     * @return Comentario
     */
    public function setDetalle($detalle)
    {
        $this->detalle = $detalle;

        return $this;
    }

    /**
     * Get detalle
     *
     * @return string 
     */
    public function getDetalle()
    {
        return $this->detalle;
    }

    /**
     * Set autor
     *
     * @param \AppBundle\Entity\Usuario $autor
     * @return Comentario
     */
    public function setAutor(\AppBundle\Entity\Usuario $autor = null)
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * Get autor
     *
     * @return \AppBundle\Entity\Usuario 
     */
    public function getAutor()
    {
        return $this->autor;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->respuestas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add respuestas
     *
     * @param \AppBundle\Entity\Comentario $respuestas
     * @return Comentario
     */
    public function addRespuesta(\AppBundle\Entity\Comentario $respuestas)
    {
        $this->respuestas[] = $respuestas;

        return $this;
    }

    /**
     * Remove respuestas
     *
     * @param \AppBundle\Entity\Comentario $respuestas
     */
    public function removeRespuesta(\AppBundle\Entity\Comentario $respuestas)
    {
        $this->respuestas->removeElement($respuestas);
    }

    /**
     * Get respuestas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRespuestas()
    {
        return $this->respuestas;
    }

    /**
     * Set respondeA
     *
     * @param \AppBundle\Entity\Comentario $respondeA
     * @return Comentario
     */
    public function setRespondeA(\AppBundle\Entity\Comentario $respondeA = null)
    {
        $this->respondeA = $respondeA;

        return $this;
    }

    /**
     * Get respondeA
     *
     * @return \AppBundle\Entity\Comentario 
     */
    public function getRespondeA()
    {
        return $this->respondeA;
    }

    /**
     * Set favor
     *
     * @param \AppBundle\Entity\Favor $favor
     * @return Comentario
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
}
