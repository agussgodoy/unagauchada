<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 */
class Usuario implements AdvancedUserInterface, \Serializable
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
     * @ORM\Column(name="email", type="string", length=100, unique=true)
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=100)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="rol", type="string", length=20)
     */
    private $rol;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=100)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="documento", type="string", length=10)
     */
    private $documento;

    /**
     * @var int
     *
     * @ORM\Column(name="creditos", type="integer")
     */
    private $creditos;

    /**
     * @var int
     *
     * @ORM\Column(name="puntaje", type="integer", nullable=true)
     */
    private $puntaje;


    /**
     * Un usuario tiene muchas calificaciones dadas
     * @ORM\OneToMany(targetEntity="Calificacion", mappedBy="usuarioAutor")
     */
    private $calificacionesDadas;

    /**
     * Un usuario tiene muchas calificaciones recibidas
     * @ORM\OneToMany(targetEntity="Calificacion", mappedBy="usuarioCalificado")
     */
    private $calificacionesRecibidas;

    /**
     * muchos usuarios pueden postularse al mismo favor 
     * @ORM\ManyToMany(targetEntity="Favor", inversedBy="candidatos")
     * @ORM\JoinTable(name="candidatos_favor")
     */
    private $postulaciones;

    /**
     * Un Usuario tiene muchos Favores
     * @ORM\OneToMany(targetEntity="Favor", mappedBy="autor")
     */
    private $favores;

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
     * Set email
     *
     * @param string $email
     * @return Usuario
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Usuario
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set rol
     *
     * @param string $rol
     * @return Usuario
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return string 
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Usuario
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Usuario
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     * @return Usuario
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set documento
     *
     * @param string $documento
     * @return Usuario
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return string 
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * Set creditos
     *
     * @param integer $creditos
     * @return Usuario
     */
    public function setCreditos($creditos)
    {
        $this->creditos = $creditos;

        return $this;
    }

    /**
     * Get creditos
     *
     * @return integer 
     */
    public function getCreditos()
    {
        return $this->creditos;
    }

    /**
     * Set puntaje
     *
     * @param integer $puntaje
     * @return Usuario
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

    public function getSalt()
    {
        return null;
    }

    public function isAccountNonExpired()
    {
        return true;
    }
    public function isAccountNonLocked()
    {
        return true;
    }
    public function isCredentialsNonExpired()
    {
        return true;
    }
    public function isEnabled()
    {
        return $this->getIsActive();
    }

    function eraseCredentials()
    {
    }

    function getRoles(){
        return array($this->getRol());
    }

     /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            $this->isActive
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            $this->isActive
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }

    public function getUserName()
    {
        return $this->email;
    }


    /**
     * Add calificacionesDadas
     *
     * @param \AppBundle\Entity\Calificacion $calificacionesDadas
     * @return Usuario
     */
    public function addCalificacionesDada(\AppBundle\Entity\Calificacion $calificacionesDadas)
    {
        $this->calificacionesDadas[] = $calificacionesDadas;

        return $this;
    }

    /**
     * Remove calificacionesDadas
     *
     * @param \AppBundle\Entity\Calificacion $calificacionesDadas
     */
    public function removeCalificacionesDada(\AppBundle\Entity\Calificacion $calificacionesDadas)
    {
        $this->calificacionesDadas->removeElement($calificacionesDadas);
    }

    /**
     * Get calificacionesDadas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCalificacionesDadas()
    {
        return $this->calificacionesDadas;
    }

    /**
     * Add calificacionesRecibidas
     *
     * @param \AppBundle\Entity\Calificacion $calificacionesRecibidas
     * @return Usuario
     */
    public function addCalificacionesRecibida(\AppBundle\Entity\Calificacion $calificacionesRecibidas)
    {
        $this->calificacionesRecibidas[] = $calificacionesRecibidas;

        return $this;
    }

    /**
     * Remove calificacionesRecibidas
     *
     * @param \AppBundle\Entity\Calificacion $calificacionesRecibidas
     */
    public function removeCalificacionesRecibida(\AppBundle\Entity\Calificacion $calificacionesRecibidas)
    {
        $this->calificacionesRecibidas->removeElement($calificacionesRecibidas);
    }

    /**
     * Get calificacionesRecibidas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCalificacionesRecibidas()
    {
        return $this->calificacionesRecibidas;
    }


    public function __toString(){
        return $this->getNombre();
    }

    /**
     * Add favores
     *
     * @param \AppBundle\Entity\Favor $favores
     * @return Usuario
     */
    public function addFavore(\AppBundle\Entity\Favor $favores)
    {
        $this->favores[] = $favores;
    
        return $this;
    }

    /**
     * Remove favores
     *
     * @param \AppBundle\Entity\Favor $favores
     */
    public function removeFavore(\AppBundle\Entity\Favor $favores)
    {
        $this->favores->removeElement($favores);
    }

    /**
     * Get favores
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFavores()
    {
        return $this->favores;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->calificacionesDadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->calificacionesRecibidas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->favores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->postulaciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setIsActive(true);
        $this->setRol('ROLE_USER');
        $this->setCreatedAt(new \DateTime);
        $this->setCreditos(1);
    }


    /**
     * Add postulaciones
     *
     * @param \AppBundle\Entity\Favor $postulaciones
     * @return Usuario
     */
    public function addPostulacione(\AppBundle\Entity\Favor $postulaciones)
    {
        $this->postulaciones[] = $postulaciones;

        return $this;
    }

    /**
     * Remove postulaciones
     *
     * @param \AppBundle\Entity\Favor $postulaciones
     */
    public function removePostulacione(\AppBundle\Entity\Favor $postulaciones)
    {
        $this->postulaciones->removeElement($postulaciones);
    }

    /**
     * Get postulaciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPostulaciones()
    {
        return $this->postulaciones;
    }
}
