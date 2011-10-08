<?php

namespace MinSal\SidPla\UnidadOrgBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use SymfonyComponentValidatorConstraints as Assert;
use DoctrineCommonCollectionsArrayCollection; 
/**
 * MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico
 *
 * @ORM\Table(name="sidpla_objetivoespecifico")
 * @ORM\Entity
 */
class ObjetivoEspecifico
{
    /**
     * @var integer $idObjEspec
     *
     * @ORM\Column(name="objesp_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    private $idObjEspec;

    /**
     * @var text $descripcion
     *
     * @ORM\Column(name="objesp_descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var string $nomenclatura
     *
     * @ORM\Column(name="objesp_nomenclatura", type="string", length=15)
     */
    private $nomenclatura;

    /**
     * @var string $tipoObj
     *
     * @ORM\Column(name="objesp_tipo", type="string", length=5)
     */
    private $tipoObj;

    /**
     * @var boolean $activo
     *
     * @ORM\Column(name="objesp_activo", type="boolean")
     */
    private $activo;
    
     /**
     * @ORM\ManyToOne(targetEntity="CaractOrg", inversedBy="objEspec")
     * @ORM\JoinColumn(name="carorg_codigo", referencedColumnName="carorg_codigo")
     */
    protected $caractOrg;

     /**
     * @ORM\OneToMany(targetEntity="MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado", mappedBy="idObjEsp", cascade={"persist", "remove"})
     */
    protected $resultadosEsperados;
    
    /**
     * Set idObjEspec
     *
     * @param integer $idObjEspec
     */
    public function setIdObjEspec($idObjEspec)
    {
        $this->idObjEspec = $idObjEspec;
    }

    /**
     * Get idObjEspec
     *
     * @return integer 
     */
    public function getIdObjEspec()
    {
        return $this->idObjEspec;
    }

    /**
     * Set descripcion
     *
     * @param text $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * Get descripcion
     *
     * @return text 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set nomenclatura
     *
     * @param string $nomenclatura
     */
    public function setNomenclatura($nomenclatura)
    {
        $this->nomenclatura = $nomenclatura;
    }

    /**
     * Get nomenclatura
     *
     * @return string 
     */
    public function getNomenclatura()
    {
        return $this->nomenclatura;
    }

    /**
     * Set tipoObj
     *
     * @param string $tipoObj
     */
    public function setTipoObj($tipoObj)
    {
        $this->tipoObj = $tipoObj;
    }

    /**
     * Get tipoObj
     *
     * @return string 
     */
    public function getTipoObj()
    {
        return $this->tipoObj;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    /**
     * Get activo
     *
     * @return boolean 
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set caractOrg
     *
     * @param MinSal\SidPla\UnidadOrgBundle\Entity\CaractOrg $caractOrg
     */
    public function setCaractOrg(\MinSal\SidPla\UnidadOrgBundle\Entity\CaractOrg $caractOrg)
    {
        $this->caractOrg = $caractOrg;
    }

    /**
     * Get caractOrg
     *
     * @return MinSal\SidPla\UnidadOrgBundle\Entity\CaractOrg 
     */
    public function getCaractOrg()
    {
        return $this->caractOrg;
    }
    
    
    public function __construct()
    {
        $this->resultadosEsperados= new ArrayCollection();
    }
    
    /**
     * Add resultadosEsperados
     *
     * @param MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado $resultadosEsperados
     */
    public function addResultadoEsperado(\MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado $resultadosEsperados)
    {
        $this->resultadosEsperados[] = $resultadosEsperados;
    }

    /**
     * Get resultadosEsperados
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getResultadoEsperado()
    {
        return $this->resultadosEsperados;
    }
    
    
}