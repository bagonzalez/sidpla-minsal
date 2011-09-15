<?php

namespace MinSal\SidPla\EstInfraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\EstInfraBundle\Entity\EvaluacionElementoInfra
 *
 * @ORM\Table(name="sidpla_evaluacionelementoinfra)
 * @ORM\Entity
 */
class EvaluacionElementoInfra
{
    /**
     * @var integer $idEvaEleInfra
     *
     * @ORM\Column(name="evaleleifr_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
 
    private $idEvaEleInfra;

    // llaves foranes de evaluacionelementoinfra
   
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\EstInfraBundle\Entity\EstadoInfraestructura", inversedBy="evaluacionelementoinfo")
     * @ORM\JoinColumn(name="estinf_codigo", referencedColumnName="estinf_codigo")
     */
    private $EstInf_Codigo;
    
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\EstInfraBundle\Entity\ElementoInfraestructura", inversedBy="evaluacionelementoinfo2")
     * @ORM\JoinColumn(name="eleminf_codigo", referencedColumnName="eleminf_codigo")
     */
    private $ElemInf_Codigo; 
    
     /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\EstInfraBundle\Entity\InfraestructuraEvaluada", inversedBy="evaluacionelementoinfo3")
     * @ORM\JoinColumn(name="infeva_codigo", referencedColumnName="infeva_codigo")
     */
    private $InfEva_Codigo;
    
  //fin de llaves foraneas  
    
    
    
    /**
     * @var datetime $fechaEvaluacion
     *
     * @ORM\Column(name="evaleleifr_fechaevaluacion", type="datetime")
     */
    private $fechaEvaluacion;

    /**
     * @var float $cantElemt
     *
     * @ORM\Column(name="evaleleifr_cantidadelemento", type="float")
     */
    private $cantElemt;



    /**
     * Get idEvaEleInfra
     *
     * @return integer 
     */
    public function getIdEvaEleInfra()
    {
        return $this->idEvaEleInfra;
    }

    /**
     * Set fechaEvaluacion
     *
     * @param datetime $fechaEvaluacion
     */
    public function setFechaEvaluacion($fechaEvaluacion)
    {
        $this->fechaEvaluacion = $fechaEvaluacion;
    }

    /**
     * Get fechaEvaluacion
     *
     * @return datetime 
     */
    public function getFechaEvaluacion()
    {
        return $this->fechaEvaluacion;
    }

    /**
     * Set cantElemt
     *
     * @param float $cantElemt
     */
    public function setCantElemt($cantElemt)
    {
        $this->cantElemt = $cantElemt;
    }

    /**
     * Get cantElemt
     *
     * @return float 
     */
    public function getCantElemt()
    {
        return $this->cantElemt;
    }
    

    
    
    
    /**
     * Set EstInf_Codigo
     *
     * @param MinSal\SidPla\EstInfraBundle\Entity\EstadoInfraestructura $EstInf_Codigo
     */
    public function setEstInf_Codigo(MinSal\SidPla\EstInfraBundle\Entity\EstadoInfraestructura $EstInf_Codigo)
    {
        $this->EstInf_Codigo = $EstInf_Codigo;
    }
    
     /**
     * Get EstInf_Codigo
     *
     * @return MinSal\SidPla\EstInfraBundle\Entity\EstadoInfraestructura
     */
    public function getEstInf_Codigo()
    {
        return $this->EstInf_Codigo;
    }
    
          
     /**
     * Set ElemInf_Codigo
     *
     * @param MinSal\SidPla\EstInfraBundle\Entity\ElementoInfraestructura $ElemInf_Codigo
     */
    public function setElemInf_Codigo(MinSal\SidPla\EstInfraBundle\Entity\ElementoInfraestructura $ElemInf_Codigo)
    {
        $this->ElemInf_Codigo = $ElemInf_Codigo;
    }
    
    /**
     * Get ElemInf_Codigo
     *
     * @return MinSal\SidPla\EstInfraBundle\Entity\ElementoInfraestructura
     */
    public function getElemInf_Codigo()
    {
        return $this->ElemInf_Codigo;
    }
    
    
    
     /**
     * Set InfEva_Codigo
     *
     * @param MinSal\SidPla\EstInfraBundle\Entity\InfraestructuraEvaluada $InfEva_Codigo
     */
    public function setInfEva_Codigo(MinSal\SidPla\EstInfraBundle\Entity\InfraestructuraEvaluada $InfEva_Codigo)
    {
        $this->InfEva_Codigo = $InfEva_Codigo;
    }
    
    
    /**
     * Get InfEva_Codigo
     *
     * @return MinSal\SidPla\EstInfraBundle\Entity\InfraestructuraEvaluada
     */
    public function getInfEva_Codigo()
    {
        return $this->InfEva_Codigo;
    }
    
    
 
    
    
}