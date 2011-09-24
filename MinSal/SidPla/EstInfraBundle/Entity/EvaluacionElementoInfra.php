<?php

namespace MinSal\SidPla\EstInfraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\EstInfraBundle\Entity\EvaluacionElementoInfra
 *
 * @ORM\Table(name="sidpla_evaluacionelementoinfra")
 * @ORM\Entity
 */
class EvaluacionElementoInfra {

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
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\EstInfraBundle\Entity\EstadoInfraestructura", inversedBy="id")
     * @ORM\JoinColumn(name="estinf_codigo", referencedColumnName="estinf_codigo")
     */
    private $EstInfCodigo;

    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\EstInfraBundle\Entity\ElementoInfraestructura", inversedBy="IdElemInfra")
     * @ORM\JoinColumn(name="eleminf_codigo", referencedColumnName="eleminf_codigo")
     */
    private $ElemInfCodigo;

    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\EstInfraBundle\Entity\InfraestructuraEvaluada", inversedBy="evaEleInfra")
     * @ORM\JoinColumn(name="infeva_codigo", referencedColumnName="infeva_codigo")
     */
    private $infraEvaluada;

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
    public function getIdEvaEleInfra() {
        return $this->idEvaEleInfra;
    }

    /**
     * Set fechaEvaluacion
     *
     * @param datetime $fechaEvaluacion
     */
    public function setFechaEvaluacion($fechaEvaluacion) {
        $this->fechaEvaluacion = $fechaEvaluacion;
    }

    /**
     * Get fechaEvaluacion
     *
     * @return datetime 
     */
    public function getFechaEvaluacion() {
        return $this->fechaEvaluacion;
    }

    /**
     * Set cantElemt
     *
     * @param float $cantElemt
     */
    public function setCantElemt($cantElemt) {
        $this->cantElemt = $cantElemt;
    }

    /**
     * Get cantElemt
     *
     * @return float 
     */
    public function getCantElemt() {
        return $this->cantElemt;
    }

   

    /**
     * Set EstInfCodigo
     *
     * @param MinSal\SidPla\EstInfraBundle\Entity\EstadoInfraestructura $estInfCodigo
     */
    public function setEstInfCodigo(\MinSal\SidPla\EstInfraBundle\Entity\EstadoInfraestructura $estInfCodigo)
    {
        $this->EstInfCodigo = $estInfCodigo;
    }

    /**
     * Get EstInfCodigo
     *
     * @return MinSal\SidPla\EstInfraBundle\Entity\EstadoInfraestructura 
     */
    public function getEstInfCodigo()
    {
        return $this->EstInfCodigo;
    }

    /**
     * Set ElemInfCodigo
     *
     * @param MinSal\SidPla\EstInfraBundle\Entity\ElementoInfraestructura $elemInfCodigo
     */
    public function setElemInfCodigo(\MinSal\SidPla\EstInfraBundle\Entity\ElementoInfraestructura $elemInfCodigo)
    {
        $this->ElemInfCodigo = $elemInfCodigo;
    }

    /**
     * Get ElemInfCodigo
     *
     * @return MinSal\SidPla\EstInfraBundle\Entity\ElementoInfraestructura 
     */
    public function getElemInfCodigo()
    {
        return $this->ElemInfCodigo;
    }

    /**
     * Set infraEvaluada
     *
     * @param MinSal\SidPla\EstInfraBundle\Entity\InfraestructuraEvaluada $infraEvaluada
     */
    public function setInfraEvaluada(\MinSal\SidPla\EstInfraBundle\Entity\InfraestructuraEvaluada $infraEvaluada)
    {
        $this->infraEvaluada = $infraEvaluada;
    }

    /**
     * Get infraEvaluada
     *
     * @return MinSal\SidPla\EstInfraBundle\Entity\InfraestructuraEvaluada 
     */
    public function getInfraEvaluada()
    {
        return $this->infraEvaluada;
    }
}