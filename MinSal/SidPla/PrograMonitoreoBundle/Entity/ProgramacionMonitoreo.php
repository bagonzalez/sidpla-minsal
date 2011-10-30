<?php

namespace MinSal\SidPla\PrograMonitoreoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * MinSal\SidPla\PrograMonitoreoBundle\Entity\ProgramacionMonitoreo
 *
 * @ORM\Table(name="sidpla_programacionmonitoreo")
 * @ORM\Entity
 */
class ProgramacionMonitoreo {

    /**
     * @var integer $idPrograMon
     *
     * @ORM\Column(name="promon_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idPrograMon;

    /**
     * @var integer $idPao
     *
     * @ORM\Column(name="pao_codigo", type="integer")
     */
    private $idPao;

    /**
     * @ORM\OneToOne(targetEntity="MinSal\SidPla\PaoBundle\Entity\Pao", inversedBy="programacionMonitoreo")
     * @ORM\JoinColumn(name="pao_codigo", referencedColumnName="pao_codigo")
     */
    private $pao;

    /**
     * @ORM\OneToMany(targetEntity="MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico", mappedBy="programacionMonitoreo")
     */
    protected $objetivosEspec;

    /**
     * @ORM\OneToMany(targetEntity="MinSal\SidPla\GesObjEspBundle\Entity\Resultadore", mappedBy="programacionMonitoreo")
     */
    protected $resultadores;

    /**
     * @ORM\OneToMany(targetEntity="MinSal\SidPla\GesObjEspBundle\Entity\ResulActividad", mappedBy="programacionMonitoreo")
     */
    protected $resultadoact;
    
    /**
     * @ORM\OneToMany(targetEntity="MinSal\SidPla\TemplateUnisalBundle\Entity\ResultActUniSal", mappedBy="programacionMonitoreo")
     */
    protected $resultadoactUniSal;
    
    /**
     * @ORM\OneToMany(targetEntity="MinSal\SidPla\TemplateUnisalBundle\Entity\ActividadUniSal", mappedBy="programacionMonitoreo")
     */
    protected $actividadesUniSal;
    
      /**
     * @ORM\OneToMany(targetEntity="MinSal\SidPla\GesObjEspBundle\Entity\ActividadVinculada", mappedBy="programacionMonitoreoOrigen")
     */
    protected $actvinculadasOrigen;
    
    /**
     * @ORM\OneToMany(targetEntity="MinSal\SidPla\GesObjEspBundle\Entity\ActividadVinculada", mappedBy="programacionMonitoreoDestino")
     */
    protected $actvinculadasDestino;
    

    public function __construct() {
        $this->objetivosEspec = new ArrayCollection();
        $this->resultadores = new ArrayCollection();
        $this->resultadoact = new ArrayCollection();
        $this->resultadoactUniSal =new ArrayCollection();
        $this->actividadesUniSal =new ArrayCollection();
    }

    /**
     * Add resultadoact
     *
     * @param MinSal\SidPla\GesObjEspBundle\Entity\ResulActividad  $resultadoact
     */
    public function addResultadoact(\MinSal\SidPla\GesObjEspBundle\Entity\ResulActividad $resultadoact) {
        $this->resultadoact[] = $resultadoact;
    }
    
     /**
     * Add resultadoactUniSal
     *
     * @param MinSal\SidPla\TemplateUnisalBundle\Entity\ResultActUniSal resultadoactUniSal
     */
    public function addResultadoactUniSal(\MinSal\SidPla\TemplateUnisalBundle\Entity\ResultActUniSal $resultadoactUniSal) {
        $this->resultadoactUniSal[] = resultadoactUniSal;
    }

    /**
     * Get resultadoact
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getResultadoact() {
        return $this->resultadoact;
    }

    /**
     * Add objetivosEspec
     *
     * @param MinSal\SidPla\AdminBundle\Entity\Municipio $objetivosEspec
     */
    public function addObjetivosEspec(\MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico $objetivosEspec) {
        $this->objetivosEspec[] = $objetivosEspec;
    }

    /**
     * Get objetivosEspec
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getObjetivosEspec() {
        return $this->objetivosEspec;
    }

    /**
     * Add resultadores
     *
     * @param MinSal\SidPla\GesObjEspBundle\Entity\Resultadore $resultadores
     */
    public function addResultadores(\MinSal\SidPla\GesObjEspBundle\Entity\Resultadore $resultadores) {
        $this->resultadores[] = $resultadores;
    }

    /**
     * Get resultadores
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getResultadores() {
        return $this->resultadores;
    }

    /**
     * Set idPrograMon
     *
     * @param integer $idPrograMon
     */
    public function setIdPrograMon($idPrograMon) {
        $this->idPrograMon = $idPrograMon;
    }

    /**
     * Get idPrograMon
     *
     * @return integer 
     */
    public function getIdPrograMon() {
        return $this->idPrograMon;
    }

    /**
     * Set idPao
     *
     * @param integer $idPao
     */
    public function setIdPao($idPao) {
        $this->idPao = $idPao;
    }

    /**
     * Get idPao
     *
     * @return integer 
     */
    public function getIdPao() {
        return $this->idPao;
    }

    /**
     * Set pao
     *
     * @param MinSal\SidPla\PaoBundle\Entity\Pao $pao
     */
    public function setPao(\MinSal\SidPla\PaoBundle\Entity\Pao $pao) {
        $this->pao = $pao;
    }

    /**
     * Get pao
     *
     * @return MinSal\SidPla\PaoBundle\Entity\Pao 
     */
    public function getPao() {
        return $this->pao;
    }


    /**
     * Add objetivosEspec
     *
     * @param MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico $objetivosEspec
     */
    public function addObjetivoEspecifico(\MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico $objetivosEspec)
    {
        $this->objetivosEspec[] = $objetivosEspec;
    }

    /**
     * Add resultadores
     *
     * @param MinSal\SidPla\GesObjEspBundle\Entity\Resultadore $resultadores
     */
    public function addResultadore(\MinSal\SidPla\GesObjEspBundle\Entity\Resultadore $resultadores)
    {
        $this->resultadores[] = $resultadores;
    }

    /**
     * Add resultadoact
     *
     * @param MinSal\SidPla\GesObjEspBundle\Entity\ResulActividad $resultadoact
     */
    public function addResulActividad(\MinSal\SidPla\GesObjEspBundle\Entity\ResulActividad $resultadoact)
    {
        $this->resultadoact[] = $resultadoact;
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
     * Add actividadesUniSal
     *
     * @param MinSal\SidPla\TemplateUnisalBundle\Entity\ActividadUniSal $actividadesUniSal
     */
    public function addActividadUniSal(\MinSal\SidPla\TemplateUnisalBundle\Entity\ActividadUniSal $actividadesUniSal)
    {
        $this->actividadesUniSal[] = $actividadesUniSal;
    }

    /**
     * Get actividadesUniSal
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getActividadesUniSal()
    {
        return $this->actividadesUniSal;
    }

    /**
     * Add actvinculadas
     *
     * @param MinSal\SidPla\GesObjEspBundle\Entity\ActividadVinculada $actvinculadas
     */
    public function addActividadVinculadaOrigen(\MinSal\SidPla\GesObjEspBundle\Entity\ActividadVinculada $actvinculadas)
    {
        $this->actvinculadasOrigen[] = $actvinculadas;
    }

    /**
     * Get actvinculadas
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getActvinculadasOrigen()
    {
        return $this->actvinculadasOrigen;
    }

    /**
     * Add actvinculadasOrigen
     *
     * @param MinSal\SidPla\GesObjEspBundle\Entity\ActividadVinculada $actvinculadasOrigen
     */
    public function addActividadVinculadaDestino(\MinSal\SidPla\GesObjEspBundle\Entity\ActividadVinculada $actvinculadasOrigen)
    {
        $this->actvinculadasDestino[] = $actvinculadasOrigen;
    }

    /**
     * Get actvinculadasDestino
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getActvinculadasDestino()
    {
        return $this->actvinculadasDestino;
    }
}