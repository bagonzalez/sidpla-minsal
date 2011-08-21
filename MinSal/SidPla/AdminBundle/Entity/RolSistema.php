<?php

namespace MinSal\SidPla\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
}