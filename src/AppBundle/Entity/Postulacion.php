<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Postulacion
 *
 * @ORM\Table(name="postulacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostulacionRepository")
 */
class Postulacion
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
     * @ORM\Column(name="comentario", type="string", length=255)
     */
    private $comentario;


    /**
     * @ORM\ManyToOne(targetEntity="Favor", inversedBy="candidatos")
     * @ORM\JoinColumn(name="favor", referencedColumnName="id")
     */
     private $favor;


     /**
      * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="postulaciones")
      * @ORM\JoinColumn(name="autor", referencedColumnName="id")
      */
      private $autor;


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
     * Set comentario
     *
     * @param string $comentario
     * @return Postulacion
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario
     *
     * @return string 
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Set favor
     *
     * @param \AppBundle\Entity\Favor $favor
     * @return Postulacion
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

    /**
     * Set autor
     *
     * @param \AppBundle\Entity\Usuario $autor
     * @return Postulacion
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
}
