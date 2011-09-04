<?php

namespace MinSal\SidPla\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\AdminBundle\Entity\InformacionGeneral
 *
 * @ORM\Table(name="sidpla_informaciongeneral")
 * @ORM\Entity
 */
class InformacionGeneral
{
    /**
     * @var integer $ididInformacionGeneral
     *
     * @ORM\Column(name="infgen_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    private $idInformacionGeneral;

    /**
     * @var string $telefono
     *
     * @ORM\Column(name="infgen_telefono", type="string", length=10)
     */
    private $telefono;

    /**
     * @var string $fax
     *
     * @ORM\Column(name="infgen_fax", type="string", length=10)
     */
    private $fax;

    /**
     * @var date $fechaActualizacion
     *
     * @ORM\Column(name="infgen_fechaactualizacion", type="date")
     */
    private $fechaActualizacion;

    /**
     * @var string $direccion
     *
     * @ORM\Column(name="infgen_direccion", type="string", length=10)
     */
    private $direccion;
    
    
    /**
     * @ORM\OneToOne(targetEntity="UnidadOrganizativa", inversedBy="informacionGeneral")
     * @ORM\JoinColumn(name="uniorg_codigo", referencedColumnName="uniorg_codigo")
     */
    private $unidadOrganizativa;

    

    /**
     * Set idInformacionGeneral
     *
     * @param integer $idInformacionGeneral
     */
    public function setIdInformacionGeneral($idInformacionGeneral)
    {
        $this->idInformacionGeneral = $idInformacionGeneral;
    }

    /**
     * Get idInformacionGeneral
     *
     * @return integer 
     */
    public function getIdInformacionGeneral()
    {
        return $this->idInformacionGeneral;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set fax
     *
     * @param string $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set fechaActualizacion
     *
     * @param date $fechaActualizacion
     */
    public function setFechaActualizacion($fechaActualizacion)
    {
        $this->fechaActualizacion = $fechaActualizacion;
    }

    /**
     * Get fechaActualizacion
     *
     * @return date 
     */
    public function getFechaActualizacion()
    {
        return $this->fechaActualizacion;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
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