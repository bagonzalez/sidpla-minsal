<?php

namespace MinSal\SidPla\GesObjEspBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * MinSal\SidPla\GesObjEspBundle\Entity\Actividad
 *
 * @ORM\Table(name="sidpla_actividad")
 * @ORM\Entity
 */
class Actividad
{
    /**
     * @var integer $idAct
     *
     * @ORM\Column(name="actividad_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idAct;

    
    /**
     * @var integer $idTipoMeta
     *
     * @ORM\Column(name="tipometa_codigo", type="integer")
     */
    private $idTipoMeta;

    /**
     * @var integer $idTipoMedVeri
     *
     * @ORM\Column(name="actividad_medioverificacion", type="string", length=50)
     */
    private $idTipoMedVeri;

    /**
     * @ORM\ManyToOne(targetEntity="ResultadoEsperado", inversedBy="actividades", cascade={"remove"})
     * @ORM\JoinColumn(name="resesp_codigo", referencedColumnName="resesp_codigo")
     */
    private $idResEsp;

    /**
     * @var string $actDescMetaAnu
     *
     * @ORM\Column(name="actividad_descripmetanual", type="string", length=50)
     */
    private $actDescMetaAnu;

    /**
     * @var string $actResponsable
     *
     * @ORM\Column(name="activiadad_responsable", type="string", length=60)
     */
    private $actResponsable;

    /**
     * @var string $actDescripcion
     *
     * @ORM\Column(name="actividad_descripcion", type="string", length=300)
     */
    private $actDescripcion;

    /**
     * @var integer $actMetaAnual
     *
     * @ORM\Column(name="actividad_metanual", type="integer")
     */
    private $actMetaAnual;

    /**
     * @var string $actNomenclatura
     *
     * @ORM\Column(name="actividad_nomenclatura", type="string", length=255)
     */
    private $actNomenclatura;


    /**
     * @var string $supuestosFactores
     *
     * @ORM\Column(name="actividad_supuestosfactores", type="string", length=300)
     */
    private $supuestosFactores;
    
    /**
     * @var string $actIndicador
     *
     * @ORM\Column(name="actividad_indicador", type="string", length=150)
     */
    private $actIndicador;
    
    /**
     * @ORM\OneToMany(targetEntity="ResulActividad", mappedBy="idActividad", cascade={"persist", "remove"})
     * @ORM\OrderBy({"resulActTrimestre" = "ASC"})
     */
    protected $resulAct;
    
     /**
     * @ORM\OneToMany(targetEntity="ActividadVinculada", mappedBy="idDepto")
     */
    protected $actvinculadasorigen;
    
     /**
     * @ORM\OneToMany(targetEntity="ActividadVinculada", mappedBy="idDepto")
     */
    protected $actdestinos;
    
    
    /**
     * @var float $costo
     *
     * @ORM\Column(name="actividad_costo", type="float")
     */
    private $costo;
      
    /**
     * Set idAct
     *
     * @param integer $idAct
     */
    public function setIdAct($idAct)
    {
        $this->idAct = $idAct;
    }

    /**
     * Get idAct
     *
     * @return integer 
     */
    public function getIdAct()
    {
        return $this->idAct;
    }

    /**
     * Set idTipoMeta
     *
     * @param integer $idTipoMeta
     */
    public function setIdTipoMeta($idTipoMeta)
    {
        $this->idTipoMeta = $idTipoMeta;
    }

    /**
     * Get idTipoMeta
     *
     * @return integer 
     */
    public function getIdTipoMeta()
    {
        return $this->idTipoMeta;
    }

    /**
     * Set idTipoMedVeri
     *
     * @param string $idTipoMedVeri
     */
    public function setIdTipoMedVeri($idTipoMedVeri)
    {
        $this->idTipoMedVeri = $idTipoMedVeri;
    }

    /**
     * Get idTipoMedVeri
     *
     * @return string 
     */
    public function getIdTipoMedVeri()
    {
        return $this->idTipoMedVeri;
    }

    /**
     * Set idResEsp  
     *
     * @param MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado $idResEsp
     */
    public function setIdResEsp(\MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado $idResEsp)
    {
        $this->idResEsp = $idResEsp;
    }

    /**
     * Get idResEsp
     *
     * @return MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado 
     */
    public function getIdResEsp()
    {
        return $this->idResEsp;
    }

    /**
     * Set actDescMetaAnu
     *
     * @param string $actDescMetaAnu
     */
    public function setActDescMetaAnu($actDescMetaAnu)
    {
        $this->actDescMetaAnu = $actDescMetaAnu;
    }

    /**
     * Get actDescMetaAnu
     *
     * @return string 
     */
    public function getActDescMetaAnu()
    {
        return $this->actDescMetaAnu;
    }

    /**
     * Set actResponsable
     *
     * @param string $actResponsable
     */
    public function setActResponsable($actResponsable)
    {
        $this->actResponsable = $actResponsable;
    }

    /**
     * Get actResponsable
     *
     * @return string 
     */
    public function getActResponsable()
    {
        return $this->actResponsable;
    }

    /**
     * Set actDescripcion
     *
     * @param string $actDescripcion
     */
    public function setActDescripcion($actDescripcion)
    {
        $this->actDescripcion = $actDescripcion;
    }

    /**
     * Get actDescripcion
     *
     * @return string 
     */
    public function getActDescripcion()
    {
        return $this->actDescripcion;
    }

    /**
     * Set actMetaAnual
     *
     * @param integer $actMetaAnual
     */
    public function setActMetaAnual($actMetaAnual)
    {
        $this->actMetaAnual = $actMetaAnual;
    }

    /**
     * Get actMetaAnual
     *
     * @return integer 
     */
    public function getActMetaAnual()
    {
        return $this->actMetaAnual;
    }

    /**
     * Set actNomenclatura
     *
     * @param string $actNomenclatura
     */
    public function setActNomenclatura($actNomenclatura)
    {
        $this->actNomenclatura = $actNomenclatura;
    }
    
     /**
     * Set costo
     *
     * @param float $costo
     */
    public function setCosto($costo)
    {
        $this->costo = round($costo,2);
    }
    
       /**
     * Get costo
     *
     * @return float 
     */
    public function getCosto()
    {
        return round($this->costo, 2);
    }
    
     

    /**
     * Get actNomenclatura
     *
     * @return string 
     */
    public function getActNomenclatura()
    {
        return $this->actNomenclatura;
    }
    
     /**
     * Set supuestosFactores
     *
     * @param string $supuestosFactores
     */
    public function setSupuestosFactores($supuestosFactores)
    {
        $this->supuestosFactores = $supuestosFactores;
    }

    /**
     * Get supuestosFactores
     *
     * @return string 
     */
    public function getSupuestosFactores()
    {
        return $this->supuestosFactores;
    }
    
      /**
     * Set actIndicador
     *
     * @param string $actIndicador
     */
    public function setActIndicador($actIndicador)
    {
        $this->actIndicador = $actIndicador;
    }

    /**
     * Get actIndicador
     *
     * @return string 
     */
    public function getActIndicador()
    {
        return $this->actIndicador;
    }
    
    public function __construct()
    {
      $this->resulAct= new ArrayCollection();  
        
    }
    
    /**
     * Add resulAct
     *
     * @param MinSal\SidPla\GesObjEspBundle\Entity\ResulActividad $resulAct
     */
    public function addResulAct(\MinSal\SidPla\GesObjEspBundle\Entity\ResulActividad $resulAct)
    {
        $this->resulAct[] = $resulAct;
        
    }

    /**
     * Get resulAct
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getResulAct()
    {
        return $this->resulAct;
    }

    /**
     * Add resulAct
     *
     * @param MinSal\SidPla\GesObjEspBundle\Entity\ResulActividad $resulAct
     */
    public function addResulActividad(\MinSal\SidPla\GesObjEspBundle\Entity\ResulActividad $resulAct)
    {
        $this->resulAct[] = $resulAct;
    }

    /**
     * Add actvinculadasorigen
     *
     * @param MinSal\SidPla\GesObjEspBundle\Entity\ActividadVinculada $actvinculadasorigen
     */
    public function addActividadVinculada(\MinSal\SidPla\GesObjEspBundle\Entity\ActividadVinculada $actvinculadasorigen)
    {
        $this->actvinculadasorigen[] = $actvinculadasorigen;
    }

    /**
     * Get actvinculadasorigen
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getActvinculadasorigen()
    {
        return $this->actvinculadasorigen;
    }

    /**
     * Get actdestinos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getActdestinos()
    {
        return $this->actdestinos;
    }
    
    public function getPorcentajeCumplimiento()
    {
        $resultado=new ResulActividad();
        $metaAnual=$this->getActMetaAnual();
        $porcentaje=0;
        $porcentajeResul=0;
        
        foreach ($this->resulAct as $resultado){            
                 $porcentajeResul=$resultado->getResulActRealizado()+$porcentajeResul;
                 
        }
        if($metaAnual>0)
            $porcentaje=$porcentajeResul/$metaAnual;
            
        return round($porcentaje*100,2);
    }
    
    public function getCostoTotalReal()
    {
        $resultado=new ResulActividad();
        $metaAnual=$this->getActMetaAnual();
        $costoReal=0;
        
        foreach ($this->resulAct as $resultado){            
                 $costoReal=$resultado->getCostoReal()+$costoReal;
        }
        
        return round($costoReal,2);
    }
}