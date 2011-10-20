<?php

namespace MinSal\SidPla\GesObjEspBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use SymfonyComponentValidatorConstraints as Assert; 
use SymfonyComponentValidatorMappingClassMetadata;
use SymfonyComponentValidatorConstraintsNotBlank;

/**
 * MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado
 *
 * @ORM\Table(name="sidpla_resultadoesperado")
 * @ORM\Entity
 */
class ResultadoEsperado
{
    /**
     * @var integer $idResEsp
     *
     * @ORM\Column(name="resesp_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idResEsp;
         
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico", inversedBy="resultadosEsperados", cascade={"remove"})
     * @ORM\JoinColumn(name="objesp_codigo", referencedColumnName="objesp_codigo")
     */
    private $idObjEsp;

    /**
     * @var integer $idResTempl
     *
     * @ORM\Column(name="restmp_codigo", type="integer")
     */
    private $idResTempl;

    
    /**
     * @var integer $idTipoMeta
     *
     * @ORM\Column(name="tipometa_codigo", type="integer")
     */
    private $idTipoMeta;

    /**
     * @var  $resEspeDesc
     *
     * @ORM\Column(name="reses_descripcion", type="text")
     */
    private $resEspeDesc;

    /**
     * @var string $resEspNomencl
     *
     * @ORM\Column(name="resesp_nomenclatura", type="string", length=15)
     */
    private $resEspNomencl;

    /**
     * @var string $resEspCondi
     *
     * @ORM\Column(name="resesp_condicionante", type="string", length=300)
     */
    private $resEspCondi;

    /**
     * @var decimal $resEspMetAnual
     *
     * @ORM\Column(name="resesp_metanual", type="integer")
     */
    private $resEspMetAnual;

    /**
     * @var string $resEspDescMetAnual
     *
     * @ORM\Column(name="resesp_descripmetanual", type="string", length=50)
     */
    private $resEspDescMetAnual;

    /**
     * @var string $resEspResponsable
     *
     * @ORM\Column(name="resesp_responsable", type="string", length=60)
     */
    private $resEspResponsable;

    /**
     * @var boolean $resEspEntidadControl
     *
     * @ORM\Column(name="resesp_entidadcontrol", type="boolean")
     */
    private $resEspEntidadControl;

    /**
     * @var string $resEspIndicador
     *
     * @ORM\Column(name="resesp_indicador", type="string", length=150)
     */
    private $resEspIndicador;

    /**
     * @var string $resEspIndicador
     *
     * @ORM\Column(name="resesp_medioverificacion", type="string", length=150)
     */
    protected $medioVerificacion;
    
    /**
     * @ORM\OneToMany(targetEntity="Actividad", mappedBy="idResEsp", cascade={"persist", "remove"})
     */
    protected $actividades;
    
    /**
     * @ORM\OneToMany(targetEntity="Resultadore", mappedBy="idResEsp", cascade={"persist", "remove"})
     */
    protected $Resultadore;
    
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa", inversedBy="resultadosEsperados")
     * @ORM\JoinColumn(name="uniorg_codigo", referencedColumnName="uniorg_codigo")
     */
    private $unidadOrganizativa;

    /**
     * Set idResEsp
     *
     * @param integer $idResEsp
     */
    public function setIdResEsp($idResEsp)
    {
        $this->idResEsp = $idResEsp;
    }

    /**
     * Get idResEsp
     *
     * @return integer 
     */
    public function getIdResEsp()
    {
        return $this->idResEsp;
    }

    /**
     * Set idObjEsp
     *
     * @param MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico $idObjEsp
     */
    public function setIdObjEsp(\MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico $idObjEsp)
    {
        $this->idObjEsp = $idObjEsp;
    }

    /**
     * Get idObjEsp
     *
     * @return MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico
     */
    public function getIdObjEsp()
    {
        return $this->idObjEsp;
    }

    /**
     * Set idResTempl
     *
     * @param integer $idResTempl
     */
    public function setIdResTempl($idResTempl)
    {
        $this->idResTempl = $idResTempl;
    }

    /**
     * Get idResTempl
     *
     * @return integer 
     */
    public function getIdResTempl()
    {
        return $this->idResTempl;
    }

    /**
     * Set idTipoMeta
     *
     * @param  integer $idTipoMeta
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
     * Set resEspeDesc
     *
     * @param $resEspeDesc
     */
    public function setResEspeDesc($resEspeDesc)
    {
        $this->resEspeDesc = $resEspeDesc;
    }

    /**
     * Get resEspeDesc
     *
     * @return 
     */
    public function getResEspeDesc()
    {
        return $this->resEspeDesc;
    }

    /**
     * Set resEspNomencl
     *
     * @param string $resEspNomencl
     */
    public function setResEspNomencl($resEspNomencl)
    {
        $this->resEspNomencl = $resEspNomencl;
    }

    /**
     * Get resEspNomencl
     *
     * @return string 
     */
    public function getResEspNomencl()
    {
        return $this->resEspNomencl;
    }

    /**
     * Set resEspCondi
     *
     * @param string $resEspCondi
     */
    public function setResEspCondi($resEspCondi)
    {
        $this->resEspCondi = $resEspCondi;
    }

    /**
     * Get resEspCondi
     *
     * @return string 
     */
    public function getResEspCondi()
    {
        return $this->resEspCondi;
    }

    /**
     * Set resEspMetAnual
     *
     * @param decimal $resEspMetAnual
     */
    public function setResEspMetAnual($resEspMetAnual)
    {
        $this->resEspMetAnual = $resEspMetAnual;
    }

    /**
     * Get resEspMetAnual
     *
     * @return decimal 
     */
    public function getResEspMetAnual()
    {
        return $this->resEspMetAnual;
    }

    /**
     * Set resEspDescMetAnual
     *
     * @param string $resEspDescMetAnual
     */
    public function setResEspDescMetAnual($resEspDescMetAnual)
    {
        $this->resEspDescMetAnual = $resEspDescMetAnual;
    }

    /**
     * Get resEspDescMetAnual
     *
     * @return string 
     */
    public function getResEspDescMetAnual()
    {
        return $this->resEspDescMetAnual;
    }

    /**
     * Set resEspResponsable
     *
     * @param string $resEspResponsable
     */
    public function setResEspResponsable($resEspResponsable)
    {
        $this->resEspResponsable = $resEspResponsable;
    }

    /**
     * Get resEspResponsable
     *
     * @return string 
     */
    public function getResEspResponsable()
    {
        return $this->resEspResponsable;
    }

    /**
     * Set resEspEntidadControl
     *
     * @param boolean $resEspEntidadControl
     */
    public function setResEspEntidadControl($resEspEntidadControl)
    {
        $this->resEspEntidadControl = $resEspEntidadControl;
    }

    /**
     * Get resEspEntidadControl
     *
     * @return boolean 
     */
    public function getResEspEntidadControl()
    {
        return $this->resEspEntidadControl;
    }

    /**
     * Set resEspIndicador
     *
     * @param string $resEspIndicador
     */
    public function setResEspIndicador($resEspIndicador)
    {
        $this->resEspIndicador = $resEspIndicador;
    }

    /**
     * Get resEspIndicador
     *
     * @return string 
     */
    public function getResEspIndicador()
    {
        return $this->resEspIndicador;
    }

     public function __construct()
    {
      $this->actividades= new ArrayCollection();  
      $this->Resultadore= new ArrayCollection();  
    }
    
   
   
    /**
     * Add actividades
     *
     * @param MinSal\SidPla\GesObjEspBundle\Entity\Actividad $actividades
     */
    public function addActividades(\MinSal\SidPla\GesObjEspBundle\Entity\Actividad $actividades)
    {
        $this->actividades[] = $actividades;
        
    }

    /**
     * Get actividades
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getActividades()
    {
        return $this->actividades;
    }
    
    /**
     * Add Resultadore
     *
     * @param MinSal\SidPla\GesObjEspBundle\Entity\Resultadore $Resultadore
     */
    public function addResultadore(\MinSal\SidPla\GesObjEspBundle\Entity\Resultadore $Resultadore)
    {
        $this->Resultadore[] = $Resultadore;
        
    }

    /**
     * Get Resultadore
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getResultadore()
    {
        return $this->Resultadore;
    }

    /**
     * Set medioVerificacion
     *
     * @param string $medioVerificacion
     */
    public function setMedioVerificacion($medioVerificacion)
    {
        $this->medioVerificacion = $medioVerificacion;
    }

    /**
     * Get medioVerificacion
     *
     * @return string 
     */
    public function getMedioVerificacion()
    {
        return $this->medioVerificacion;
    }

    /**
     * Add actividades
     *
     * @param MinSal\SidPla\GesObjEspBundle\Entity\Actividad $actividades
     */
    public function addActividad(\MinSal\SidPla\GesObjEspBundle\Entity\Actividad $actividades)
    {
        $this->actividades[] = $actividades;
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
    
    public function getPorcentajeCumplimiento()
    {
        $actividad=new Actividad();        
        $porcentajeResul=0;        
        $numAct=count($this->actividades );
        
        if($numAct>0)
            $razon=1/$numAct;
        
        foreach ($this->actividades as $actividad){
               $porcentajeResul= $actividad->getPorcentajeCumplimiento()*$razon+$porcentajeResul;                                                 
        }
            
        return round($porcentajeResul,2);
    }
    
     public function getCostoTotalReal()
    {
        $actividad=new Actividad();        
        $costo=0;        
        $numAct=count($this->actividades );
        
        foreach ($this->actividades as $actividad){
               $costo= $actividad->getCostoTotalReal()+$costo;                                              
        }
            
        return round($costo,2);
    }
    
    public function getCostoTotalProgramado()
    {
        $actividad=new Actividad();        
        $costo=0;        
        $numAct=count($this->actividades );
        
        foreach ($this->actividades as $actividad){
               $costo= $actividad->getCosto()+$costo;                                              
        }
        
        return round($costo,2);
    }
    
}