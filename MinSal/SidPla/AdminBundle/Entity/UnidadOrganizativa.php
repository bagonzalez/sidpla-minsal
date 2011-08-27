<?php

namespace MinSal\SidPla\AdminBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa
 *
 * @ORM\Table(name="sidpla_unidadorganizativa")
 * @ORM\Entity
 */
class UnidadOrganizativa {
    
    /**
     * @var integer $idUnidadOrg
     *
     * @ORM\Column(name="uniorg_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
     private $idUnidadOrg;
     
     
     /**
     * @var string $nombreUnidad
     *
     * @ORM\Column(name="uniorg_nombre", type="string", length=150)
     */
     private $nombreUnidad;    
     
     
     /**
     * @var string $descripcionUnidad
     *
     * @ORM\Column(name="uniorg_descripcion", type="string", length=200)
     */
     private $descripcionUnidad;
     
     /**
     * @var string $tipoUnidad
     *
     * @ORM\Column(name="uniorg_tipounidad", type="string", length=15)
     */
     private $tipoUnidad;
     
             
     /**
     * @var integer $idMunicipio
     *
     * @ORM\Column(name="muni_codigo", type="integer")
     */
     private $idMunicipio;  
     
     
    /**
     * @ORM\OneToMany(targetEntity="UnidadOrganizativa", mappedBy="parent")
     */
    protected $subUnidades;
    
    /**
     * @ORM\ManyToOne(targetEntity="UnidadOrganizativa", inversedBy="subUnidades")
     * @ORM\JoinColumn(name="uniorg_codigo1", referencedColumnName="uniorg_codigo")
     */
    private $parent;
    
    
    public function __construct()
    {
        $this->subUnidades = new ArrayCollection();
    }
    
    /**
     * Add subUnidades
     *
     * @param \MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa $subUnidades
     */
    public function addSubUnidades(\MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa $subUnidades)
    {
        $this->subUnidades[] = $subUnidades;
    }

    /**
     * Get subUnidades
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSubUnidades()
    {
        return $this->subUnidades;
    }
    
     public function getParent()
    {
        return $this->parent;
    }
    
    public function setParent($parent)
    {
        $this->parent = $parent;
    }
    
     
     
     /**
     * Get idUnidadOrg
     *
     * @return integer 
     */
    public function getIdUnidadOrg()
    {
        return $this->idUnidadOrg;
    }
    
    public function getNombreUnidad()
    {
        return $this->nombreUnidad;
    }
    
    public function setNombreUnidad($nombreUnidad)
    {
        $this->nombreUnidad = $nombreUnidad;
    }
    
    public function getDescripcionUnidad()
    {
        return $this->descripcionUnidad;
    }
    
    public function setDescripcionUnidad($descripcionUnidad)
    {
        $this->descripcionUnidad = $descripcionUnidad;
    }
    
    public function getTipoUnidad()
    {
        return $this->tipoUnidad;
    }
    
     public function setTipoUnidad($tipoUnidad)
    {
        $this->tipoUnidad = $tipoUnidad;
    }
    
   
    
    public function getIdMunicipio()
    {
        return $this->idMunicipio;
    }
    
    public function setIdMunicipio($idMunicipio)
    {
        $this->idMunicipio = $idMunicipio;
    }
   
}