<?php

namespace MinSal\SidPla\TemplateUnisalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * MinSal\SidPla\TemplateUnisalBundle\Entity\ActividadUniSal
 *
 * @ORM\Table(name="sidpla_actividadunisal")
 * @ORM\Entity
 */
class ActividadUniSal {

    /**
     * @var integer $codActUni
     *
     * @ORM\Column(name="actuni_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codActUni;
    
    
    
     /**
     * @var date $fechaInicioAct
     *
     * @ORM\Column(name="actuni_fechainicio", type="date")
     */
    private $fechaInicioAct;
    
    /**
     * @var date $fechaFinAct
     *
     * @ORM\Column(name="actuni_fechafin", type="date")
     */
    private $fechaFinAct;
    
     /**
     * @var string $responsableActUni
     *
     * @ORM\Column(name="actuni_responsable", type="string", length=60)
     */
    private $responsableActUni;
    
   

    /**
     * @var string $beneActUni
     *
     * @ORM\Column(name="actuni_beneficiario", type="string", length=180)
     */
    private $beneActUni;

    /**
     * @var float $coberActUni
     *
     * @ORM\Column(name="actuni_cobertura", type="float")
     */
    private $coberActUni;


    /**
     * @var integer $metaAnualActUni
     *
     * @ORM\Column(name="actuni_metaanual", type="integer")
     */
    private $metaAnualActUni;

   
    
     /**
     * @ORM\OneToMany(targetEntity="MinSal\SidPla\TemplateUnisalBundle\Entity\ResultActUniSal", mappedBy="actividadUniSal")
     * @ORM\OrderBy({"mes" = "ASC"})
     */
    protected $resultadoactUniSal;
    
     /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\TemplateUnisalBundle\Entity\ActividadUnisalTemplate", inversedBy="actividadesUniSal")
     * @ORM\JoinColumn(name="actunitem_codigo", referencedColumnName="actunitem_codigo")
     */
    protected $actTemp;
    
       
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\PrograMonitoreoBundle\Entity\ProgramacionMonitoreo", inversedBy="actividadesUniSal")
     * @ORM\JoinColumn(name="promon_codigo", referencedColumnName="promon_codigo")
     */
    protected $programacionMonitoreo;

    public function __construct() {
        $this->resultadoactUniSal =new ArrayCollection();        
    }

    /**
     * Get codActUni
     *
     * @return integer 
     */
    public function getCodActUni() {
        return $this->codActUni;
    }

    /**
     * Set descActUni
     *
     * @param string $descActUni
     */
    public function setDescActUni($descActUni) {
        $this->descActUniTemp = $descActUni;
    }

    /**
     * Get descActUni
     *
     * @return string 
     */
    public function getDescActUni() {
        return $this->descActUni;
    }

    /**
     * Set metaAnualActUni
     *
     * @param integer $metaAnualActUni
     */
    public function setMetaAnualActUni($metaAnualActUni) {
        $this->metaAnualActUni = $metaAnualActUni;
    }

    /**
     * Get metaAnualActUni
     *
     * @return integer 
     */
    public function getMetaAnualActUni() {
        return $this->metaAnualActUni;
    }

    /**
     * Set responsableActUni
     *
     * @param string $responsableActUni
     */
    public function setResponsableActUni($responsableActUni) {
        $this->responsableActUni= $responsableActUni;
    }

    /**
     * Get responsableActUni
     *
     * @return string 
     */
    public function getResponsableActUni() {
        return $this->responsableActUni;
    }

    /**
     * Set beneActUni
     *
     * @param string $beneActUni
     */
    public function setBeneActUni($beneActUni) {
        $this->beneActUni = $beneActUni;
    }

    /**
     * Get beneActUni
     *
     * @return string 
     */
    public function getBeneActUni() {
        return $this->beneActUni;
    }

    /**
     * Set coberActUni
     *
     * @param float $coberActUni
     */
    public function setCoberActUni($coberActUni) {
        $this->coberActUni= $coberActUni;
    }

    /**
     * Get coberActUni
     *
     * @return float 
     */
    public function getCoberActUni() {
        return $this->coberActUni;
    }



    /**
     * Set fechaInicioAct
     *
     * @param date $fechaInicioAct
     */
    public function setFechaInicioAct($fechaInicioAct)
    {
        $this->fechaInicioAct = $fechaInicioAct;
    }

    /**
     * Get fechaInicioAct
     *
     * @return date 
     */
    public function getFechaInicioAct()
    {
        return $this->fechaInicioAct;
    }

    /**
     * Set fechaFinAct
     *
     * @param date $fechaFinAct
     */
    public function setFechaFinAct($fechaFinAct)
    {
        $this->fechaFinAct = $fechaFinAct;
    }

    /**
     * Get fechaFinAct
     *
     * @return date 
     */
    public function getFechaFinAct()
    {
        return $this->fechaFinAct;
    }

    /**
     * Add resultadoactUniSal
     *
     * @param MinSal\SidPla\TemplateUnisalBundle\Entity\ResultActUniSal $resultadoactUniSal
     */
    public function addResultActUniSal(\MinSal\SidPla\TemplateUnisalBundle\Entity\ResultActUniSal $resultadoactUniSal)
    {
        $this->resultadoactUniSal[] = $resultadoactUniSal;
    }

    /**
     * Get resultadoactUniSal
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getResultadoactUniSal()
    {
        return $this->resultadoactUniSal;
    }
    
     /**
     * Set programacionMonitoreo
     *
     * @param MinSal\SidPla\PrograMonitoreoBundle\Entity\ProgramacionMonitoreo $programacionMonitoreo
     */
    public function setProgramacionMonitoreo(\MinSal\SidPla\PrograMonitoreoBundle\Entity\ProgramacionMonitoreo $programacionMonitoreo)
    {
        $this->programacionMonitoreo = $programacionMonitoreo;
    }

    /**
     * Get programacionMonitoreo
     *
     * @return MinSal\SidPla\PrograMonitoreoBundle\Entity\ProgramacionMonitoreo 
     */
    public function getProgramacionMonitoreo()
    {
        return $this->programacionMonitoreo;
    }
    
    
    /**
     * Set actTemp
     *
     * @param MinSal\SidPla\TemplateUnisalBundle\Entity\ActividadUnisalTemplate $actTemp
     */
    public function setActTemp(\MinSal\SidPla\TemplateUnisalBundle\Entity\ActividadUnisalTemplate $actTemp)
    {
        $this->actTemp = $actTemp;
    }

    /**
     * Get actTemp
     *
     * @return MinSal\SidPla\TemplateUnisalBundle\Entity\ActividadUnisalTemplate 
     */
    public function getActTemp()
    {
        return $this->actTemp;
    }
    
    
     public function getPorcentajeCumplimiento()
    {
        $resultado=new ResultActUniSal();
        $metaAnual=$this->getMetaAnualActUni();
        $porcentaje=0;
        $porcentajeResul=0;
        
        foreach ($this->resultadoactUniSal as $resultado){            
                 $porcentajeResul=$resultado->getResulActRealizado()+$porcentajeResul;
                 
        }
        if($metaAnual>0)
            $porcentaje=$porcentajeResul/$metaAnual;
            
        return round($porcentaje*100,2);
    }

}