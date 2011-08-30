<?php

namespace MinSal\SidPla\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\AdminBundle\Entity\Empleado
 *
 * @ORM\Table(name="sidpla_empleado")
 * @ORM\Entity
 */
class Empleado
{
    /**
     * @var integer $idEmpleado
     *
     * @ORM\Column(name="empleado_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */   
    private $idEmpleado;

    /**
     * @var string $primerNombre
     *
     * @ORM\Column(name="empleado_primernombre", type="string", length=32)
     */
    private $primerNombre;

    /**
     * @var string $segundoNombre
     *
     * @ORM\Column(name="empleado_segundonombre", type="string", length=35)
     */
    private $segundoNombre;

    /**
     * @var string $primerApellido
     *
     * @ORM\Column(name="empleado_primerapellido", type="string", length=35)
     */    
    private $primerApellido;

    /**
     * @var string $segundoApellido
     *
     * @ORM\Column(name="empleado_segundoapellido", type="string", length=35)
     */
    private $segundoApellido;

    /**
     * @var string $dui
     *
     * @ORM\Column(name="empleado_dui", type="string", length=10)
     */
    private $dui;
    
    /**
     * @ORM\ManyToOne(targetEntity="UnidadOrganizativa", inversedBy="empleados")
     * @ORM\JoinColumn(name="uniorg_codigo", referencedColumnName="uniorg_codigo")
     */
    protected $unidadOrganizativa;

    
    /**
     * Set idEmpleado
     *
     * @param integer $idEmpleado
     */
    public function setIdEmpleado($idEmpleado)
    {
        $this->idEmpleado = $idEmpleado;
    }

    /**
     * Get idEmpleado
     *
     * @return integer 
     */
    public function getIdEmpleado()
    {
        return $this->idEmpleado;
    }

    /**
     * Set primerNombre
     *
     * @param string $primerNombre
     */
    public function setPrimerNombre($primerNombre)
    {
        $this->primerNombre = $primerNombre;
    }

    /**
     * Get primerNombre
     *
     * @return string 
     */
    public function getPrimerNombre()
    {
        return $this->primerNombre;
    }

    /**
     * Set segundoNombre
     *
     * @param string $segundoNombre
     */
    public function setSegundoNombre($segundoNombre)
    {
        $this->segundoNombre = $segundoNombre;
    }

    /**
     * Get segundoNombre
     *
     * @return string 
     */
    public function getSegundoNombre()
    {
        return $this->segundoNombre;
    }

    /**
     * Set primerApellido
     *
     * @param string $primerApellido(35)
     */
    public function setPrimerApellido($primerApellido)
    {
        $this->primerApellido= $primerApellido;
    }

    /**
     * Get primerApellido(35)
     *
     * @return string 
     */
    public function getPrimerApellido()
    {
        return $this->primerApellido;
    }

    /**
     * Set segundoApellido
     *
     * @param string $segundoApellido
     */
    public function setSegundoApellido($segundoApellido)
    {
        $this->segundoApellido = $segundoApellido;
    }

    /**
     * Get segundoApellido
     *
     * @return string 
     */
    public function getSegundoApellido()
    {
        return $this->segundoApellido;
    }

    /**
     * Set dui
     *
     * @param string $dui
     */
    public function setDui($dui)
    {
        $this->dui = $dui;
    }

    /**
     * Get dui
     *
     * @return string 
     */
    public function getDui()
    {
        return $this->dui;
    }

    /**
     * Set unidadOrganizativa
     *
     * @param MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa $unidadOrganizativa
     */
    public function setUnidadOrganizativa(\MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa $unidadOrganizativa)
    {
        $this->unidadOrganizativa = $unidadOrganizativa;
    }

    /**
     * Get unidadOrganizativa
     *
     * @return MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa 
     */
    public function getUnidadOrganizativa()
    {
        return $this->unidadOrganizativa;
    }
}