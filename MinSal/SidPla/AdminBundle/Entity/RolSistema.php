<?php

namespace MinSal\SidPla\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * MinSal\SidPla\AdminBundle\Entity\RolSistema
 *
 * @ORM\Table(name="sidpla_rol")
 * @ORM\Entity
 */
class RolSistema
{
     /**
     * @var integer $idRol
     *
     * @ORM\Column(name="rol_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idRol;

    /**
     * @var string $nombreRol
     *
     * @ORM\Column(name="rol_nombre", type="string", length=10)
     */
    private $nombreRol;

    /**
     * @var string $funcionesRol
     *
     * @ORM\Column(name="rol_funciones", type="string", length=300)
     */
    private $funcionesRol; 
    
    
     /**
     * @ORM\OneToMany(targetEntity="MinSal\SidPla\UsersBundle\Entity\User", mappedBy="rol")
     */
    protected $usuarios;
    
    /**
     * @ORM\ManyToMany(targetEntity="OpcionSistema")
     * @ORM\JoinTable(name="sidpla_rol_opcion",
     *      joinColumns={@ORM\JoinColumn(name="rol_codigo", referencedColumnName="rol_codigo")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="opcionsistema_codigo", referencedColumnName="opcionsistema_codigo")}
     *      )
     * @ORM\OrderBy({"idOpcionSistema" = "ASC"})
     */
    private $opcionesSistema;
    
    
     public function __construct()
    {
        $this->usuarios = new ArrayCollection();
        $this->opcionesSistema = new ArrayCollection();
    }

    

    /**
     * Get idRol
     *
     * @return integer 
     */
    public function getIdRol()
    {
        return $this->idRol;
    }

    /**
     * Set nombreRol
     *
     * @param string $nombreRol
     */
    public function setNombreRol($nombreRol)
    {
        $this->nombreRol = $nombreRol;
    }
    
    
     public function setIdRol($idRol)
    {
        $this->idRol=$idRol;
    }

    /**
     * Get nombreRol
     *
     * @return string 
     */
    public function getNombreRol()
    {
        return $this->nombreRol;
    }

    /**
     * Set funcionesRol
     *
     * @param string $funcionesRol
     */
    public function setFuncionesRol($funcionesRol)
    {
        $this->funcionesRol = $funcionesRol;
    }

    /**
     * Get funcionesRol
     *
     * @return string 
     */
    public function getFuncionesRol()
    {
        return $this->funcionesRol;
    }

    /**
     * Add usuarios
     *
     * @param MinSAl\SidPla\UsersBundle\Entity\User $usuarios
     */
    public function addUsuarios(\MinSAl\SidPla\UsersBundle\Entity\User $usuarios)
    {
        $this->usuarios[] = $usuarios;
    }

    /**
     * Get usuarios
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }
    
    
     public function __toString()
    {
       return $this->getNombreRol();
    }
    

    /**
     * Add opcionesSistema
     *
     * @param MinSal\SidPla\AdminBundle\Entity\OpcionSistema $opcionesSistema
     */
    public function addOpcionesSistema(\MinSal\SidPla\AdminBundle\Entity\OpcionSistema $opcionesSistema)
    {
        $this->opcionesSistema[] = $opcionesSistema;
    }

    /**
     * Get opcionesSistema
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getOpcionesSistema()
    {
        return $this->opcionesSistema;
    }

    /**
     * Add usuarios
     *
     * @param MinSal\SidPla\UsersBundle\Entity\User $usuarios
     */
    public function addUser(\MinSal\SidPla\UsersBundle\Entity\User $usuarios)
    {
        $this->usuarios[] = $usuarios;
    }

    /**
     * Add opcionesSistema
     *
     * @param MinSal\SidPla\AdminBundle\Entity\OpcionSistema $opcionesSistema
     */
    public function addOpcionSistema(\MinSal\SidPla\AdminBundle\Entity\OpcionSistema $opcionesSistema)
    {
        $this->opcionesSistema[] = $opcionesSistema;
    }
}