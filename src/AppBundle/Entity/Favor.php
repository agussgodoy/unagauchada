<?php

namespace AppBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;
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
     * @ORM\OneToMany(targetEntity="Comentario", mappedBy="favor",cascade={"remove"})
     */
    private $comentarios;

    /**
     * Un favor corresponde a una Categoria
     * @ORM\ManyToOne(targetEntity="Categoria")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     */
    private $categoria;
    
    /**
     * @ORM\Column(name="localidad", type="string", length=255)
     */
     private $localidad;
    
    
    /**
     * Un Favor corresponde a un Usuario, el que lo va a cumplir
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(name="usuario_elegido_id", referencedColumnName="id")
     */
    private $elegido;

    /**
     * Muchos Favores corresponden a un Usuario
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="favores")
     * @ORM\JoinColumn(name="usuario_autor_id", referencedColumnName="id")
     */
    private $autor;

    /**
     * @ORM\OneToMany(targetEntity="Postulacion", mappedBy="favor", cascade={"remove"})
     */
    private $candidatos;

    /**
     * @var boolean
     *
     * @ORM\Column(name="calificado", type="string", length=1)
     */
    private $calificado;

    /**
     * @ORM\Column(name="ruta_foto", type="string", length=255, nullable=true)
     */
    private $rutaFoto;

    
    private $foto;




    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comentarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->candidatos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->calificado = 'n';
    }

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

    /**
     * Get comentarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * Set categoria
     *
     * @param \AppBundle\Entity\Categoria $categoria
     * @return Favor
     */
    public function setCategoria(\AppBundle\Entity\Categoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \AppBundle\Entity\Categoria 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set elegido
     *
     * @param \AppBundle\Entity\Usuario $elegido
     * @return Favor
     */
    public function setElegido(\AppBundle\Entity\Usuario $elegido = null)
    {
        $this->elegido = $elegido;

        return $this;
    }

    /**
     * Get elegido
     *
     * @return \AppBundle\Entity\Usuario 
     */
    public function getElegido()
    {
        return $this->elegido;
    }

    /**
     * Set autor
     *
     * @param \AppBundle\Entity\Usuario $autor
     * @return Favor
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
     * Add candidatos
     *
     * @param \AppBundle\Entity\Postulacion $candidatos
     * @return Favor
     */
    public function addCandidato(\AppBundle\Entity\Postulacion $candidatos)
    {
        $this->candidatos[] = $candidatos;

        return $this;
    }

    /**
     * Remove candidatos
     *
     * @param \AppBundle\Entity\Postulacion $candidatos
     */
    public function removeCandidato(\AppBundle\Entity\Postulacion $candidatos)
    {
        $this->candidatos->removeElement($candidatos);
    }

    /**
     * Get candidatos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCandidatos()
    {
        return $this->candidatos;
    }

    /**
     * Set rutaFoto
     *
     * @param string $rutaFoto
     *
     * @return Favor
     */
    public function setRutaFoto($rutaFoto)
    {
        $this->rutaFoto = $rutaFoto;

        return $this;
    }

    /**
     * Get rutaFoto
     *
     * @return string
     */
    public function getRutaFoto()
    {
        return $this->rutaFoto;
    }

    /**
     * Set foto.
     *
     * @param UploadedFile $foto
     */
    public function setFoto(UploadedFile $foto = null)
    {
        $this->foto = $foto;
    }
    /**
     * Get foto.
     *
     * @return UploadedFile
     */
    public function getFoto()
    {
        return $this->foto;
    }

    public function __toString(){
        return $this->getDetalle();
    }

    /**
     * Uploads the profile photo
     *
     * @param string $dir
     */
    public function uploadFoto($dir)
    {
        if (null === $this->getFoto()) {
            return;
        }
        $photoFileName = uniqid('favor').'.'.$this->getFoto()->guessExtension();
        $this->getFoto()->move($dir, $photoFileName);
        $this->setRutaFoto($photoFileName);
    }
    

    /**
     * Set calificado
     *
     * @param boolean $calificado
     * @return Favor
     */
    public function setCalificado($calificado)
    {
        $this->calificado = $calificado;
    
        return $this;
    }

    /**
     * Get calificado
     *
     * @return boolean 
     */
    public function getCalificado()
    {
        return $this->calificado;
    }

}
