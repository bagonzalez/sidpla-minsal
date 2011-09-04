<?php

namespace MinSal\SidPla\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * MinSal\SidPla\AdminBundle\Entity\DepartamentoPais
 *
 * @ORM\Table(name="sidpla_departamento")
 * @ORM\Entity
 */
class DepartamentoPais
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="depa_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idDepto;
   
    
    public function __construct()
    {
        $this->municipios = new ArrayCollection();
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

    /**
     * Set nombreDepto
     *
     * @param string $nombreDepto
     */
    public function setNombreDepto($nombreDepto)
    {
        $this->nombreDepto = $nombreDepto;
    }

    /**
     * Get nombreDepto
     *
     * @return string 
     */
    public function getNombreDepto()
    {
        return $this->nombreDepto;
    }
    
    /**
     * @var string $nombreDepto
     *
     * @ORM\Column(name="depa_nombre", type="string", length=150)
     */
    private $nombreDepto;
    
     /**
     * @ORM\OneToMany(targetEntity="Municipio", mappedBy="idDepto")
     */
    protected $municipios;

    /**
     * Add municipios
     *
     * @param MinSal\SidPla\AdminBundle\Entity\Municipio $municipios
     */
    public function addMunicipios(\MinSal\SidPla\AdminBundle\Entity\Municipio $municipios)
    {
        $this->municipios[] = $municipios;
    }

    /**
     * Get municipios
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMunicipios()
    {
        return $this->municipios;
    }
}