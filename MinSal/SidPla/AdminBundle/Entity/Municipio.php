<?php

/*
 * Entidad que persiste los municipios
 * 
 */

namespace MinSal\SidPla\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\AdminBundle\Entity\Municipio
 *
 * @ORM\Table(name="sidpla_municipio")
 * @ORM\Entity
 */
class Municipio
{
    /**
     * @var integer $idMunicipio
     *
     * @ORM\Column(name="muni_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    private $idMunicipio;

    /**
     * @var string $nombreMunicipio
     *
     * @ORM\Column(name="muni_nombre", type="string", length=100)
     */
    private $nombreMunicipio;

       
    
    /**
     * @ORM\ManyToOne(targetEntity="DepartamentoPais", inversedBy="municipios")
     * @ORM\JoinColumn(name="depa_codigo", referencedColumnName="depa_codigo")
     */
    protected $idDepto;


    /**
     * Set idMunicipio
     *
     * @param integer $idMunicipio
     */
    public function setIdMunicipio($idMunicipio)
    {
        $this->idMunicipio = $idMunicipio;
    }

    /**
     * Get idMunicipio
     *
     * @return integer 
     */
    public function getIdMunicipio()
    {
        return $this->idMunicipio;
    }

    /**
     * Set nombreMunicipio
     *
     * @param string $nombreMunicipio
     */
    public function setNombreMunicipio($nombreMunicipio)
    {
        $this->nombreMunicipio = $nombreMunicipio;
    }

    /**
     * Get nombreMunicipio
     *
     * @return string 
     */
    public function getNombreMunicipio()
    {
        return $this->nombreMunicipio;
    }

    /**
     * Set idDepto
     *
     * @param integer $idDepto
     */
    public function setIdDepto($idDepto)
    {
        $this->idDepto = $idDepto;
    }

    /**
     * Get idDepto
     *
     * @return integer 
     */
    public function getIdDepto()
    {
        return $this->idDepto;
    }
    
    
    
}