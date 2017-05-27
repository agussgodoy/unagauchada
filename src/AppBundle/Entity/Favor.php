<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Favor
 *
 * @ORM\Table(name="favor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FavorRepository")
 */
class Favor
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
     * @ORM\Column(name="titulo", type="string", length=100)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="detalle", type="string", length=255)
     */
    private $detalle;

    /**
     * Un favor tiene muchos comentarios
     * @ORM\OneToMany(targetEntity="Comentario", mappedBy="favor")
     */
    private $comentarios;

    /**
     * Un favor corresponde a una Categoria
     * @ORM\OneToOne(targetEntity="Categoria")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     */
    private $categoria;

    /**
     * Un favor corresponde a una Localidad
     * @ORM\OneToOne(targetEntity="Localidad")
     * @ORM\JoinColumn(name="localidad_id", referencedColumnName="id")
     */
    private $localidad;

    /**
     * Un Favor corresponde a un Partido
     * @ORM\OneToOne(targetEntity="Partido")
     * @ORM\JoinColumn(name="partido_id", referencedColumnName="id")
     */
    private $partido;

    /**
     * Un Favor corresponde a un Usuario, el que lo va a cumplir
     * @ORM\OneToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(name="usuario_elegido_id", referencedColumnName="id")
     */
    private $elegido;

    /**
     * Muchos Favores corresponden a un Usuario
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(name="usuario_autor_id", referencedColumnName="id")
     */
    private $autor;

    /**
     * Un Favor tiene muchos Usuarios 
     * @ORM\OneToMany(targetEntity="Usuario", mappedBy="postulaciones")
     */
    private $candidatos;


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
     * Set titulo
     *
     * @param string $titulo
     * @return Favor
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set detalle
     *
     * @param string $detalle
     * @return Favor
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
     * Set comentarios
     *
     * @param string $comentarios
     * @return Favor
     */
    public function setComentarios($comentarios)
    {
        $this->comentarios = $comentarios;

        return $this;
    }

    /**
     * Get comentarios
     *
     * @return string 
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * Set categoria
     *
     * @param string $categoria
     * @return Favor
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return string 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set localidad
     *
     * @param string $localidad
     * @return Favor
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return string 
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set partido
     *
     * @param string $partido
     * @return Favor
     */
    public function setPartido($partido)
    {
        $this->partido = $partido;

        return $this;
    }

    /**
     * Get partido
     *
     * @return string 
     */
    public function getPartido()
    {
        return $this->partido;
    }

    /**
     * Set elegido
     *
     * @param string $elegido
     * @return Favor
     */
    public function setElegido($elegido)
    {
        $this->elegido = $elegido;

        return $this;
    }

    /**
     * Get elegido
     *
     * @return string 
     */
    public function getElegido()
    {
        return $this->elegido;
    }

    /**
     * Set autor
     *
     * @param string $autor
     * @return Favor
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * Get autor
     *
     * @return string 
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Set candidatos
     *
     * @param string $candidatos
     * @return Favor
     */
    public function setCandidatos($candidatos)
    {
        $this->candidatos = $candidatos;

        return $this;
    }

    /**
     * Get candidatos
     *
     * @return string 
     */
    public function getCandidatos()
    {
        return $this->candidatos;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->candidatos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add candidatos
     *
     * @param \AppBundle\Entity\Usuario $candidatos
     * @return Favor
     */
    public function addCandidato(\AppBundle\Entity\Usuario $candidatos)
    {
        $this->candidatos[] = $candidatos;

        return $this;
    }

    /**
     * Remove candidatos
     *
     * @param \AppBundle\Entity\Usuario $candidatos
     */
    public function removeCandidato(\AppBundle\Entity\Usuario $candidatos)
    {
        $this->candidatos->removeElement($candidatos);
    }

    /**
     * Add comentarios
     *
     * @param \AppBundle\Entity\Comentario $comentarios
     * @return Favor
     */
    public function addComentario(\AppBundle\Entity\Comentario $comentarios)
    {
        $this->comentarios[] = $comentarios;

        return $this;
    }

    /**
     * Remove comentarios
     *
     * @param \AppBundle\Entity\Comentario $comentarios
     */
    public function removeComentario(\AppBundle\Entity\Comentario $comentarios)
    {
        $this->comentarios->removeElement($comentarios);
    }
}
