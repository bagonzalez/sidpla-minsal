<?php

namespace MinSal\SidPla\IndicadoresTemplateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\IndicadoresTemplateBundle\Entity\EvaluacionIndicador
 *
 * @ORM\Table(name="sidpla_evaluacionindicador")
 * @ORM\Entity
 */
class EvaluacionIndicador {

    /**
     * @var integer $codEvaInd
     *
     * @ORM\Column(name="evaind_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codEvaInd;

    /**
     * @var float $resEvaInd
     *
     * @ORM\Column(name="evaind_resultadoevaluacion", type="float")
     */
    private $resEvaInd;

    /**
     * @var integer $trimEvaInd
     *
     * @ORM\Column(name="evaind_trimestre", type="integer")
     */
    private $trimEvaInd;

    /**
     * @var date $fechEvaInd
     *
     * @ORM\Column(name="evaind_fechaevalua", type="date")
     */
    private $fechEvaInd;

    /**
     * @ORM\ManyToOne(targetEntity="IndicadorSalud", inversedBy="evaluacionesIndicador")
     * @ORM\JoinColumn(name="indsalu_codigo", referencedColumnName="indsalu_codigo")
     */
    private $indSalud;

    /**
     * @ORM\ManyToOne(targetEntity="EvaluacionResultado", inversedBy="evaIndi")
     * @ORM\JoinColumn(name="evares_codigo", referencedColumnName="evares_codigo")
     */
    private $evaResul;


    /**
     * Get codEvaInd
     *
     * @return integer 
     */
    public function getCodEvaInd()
    {
        return $this->codEvaInd;
    }

    /**
     * Set resEvaInd
     *
     * @param float $resEvaInd
     */
    public function setResEvaInd($resEvaInd)
    {
        $this->resEvaInd = $resEvaInd;
    }

    /**
     * Get resEvaInd
     *
     * @return float 
     */
    public function getResEvaInd()
    {
        return $this->resEvaInd;
    }

    /**
     * Set trimEvaInd
     *
     * @param integer $trimEvaInd
     */
    public function setTrimEvaInd($trimEvaInd)
    {
        $this->trimEvaInd = $trimEvaInd;
    }

    /**
     * Get trimEvaInd
     *
     * @return integer 
     */
    public function getTrimEvaInd()
    {
        return $this->trimEvaInd;
    }

    /**
     * Set fechEvaInd
     *
     * @param date $fechEvaInd
     */
    public function setFechEvaInd($fechEvaInd)
    {
        $date = new \DateTime($fechEvaInd);
        $this->fechEvaInd = $date;        
    }

    /**
     * Get fechEvaInd
     *
     * @return date 
     */
    public function getFechEvaInd()
    {
        return $this->fechEvaInd;
    }

    /**
     * Set indSalud
     *
     * @param MinSal\SidPla\IndicadoresTemplateBundle\Entity\IndicadorSalud $indSalud
     */
    public function setIndSalud(\MinSal\SidPla\IndicadoresTemplateBundle\Entity\IndicadorSalud $indSalud)
    {
        $this->indSalud = $indSalud;
    }

    /**
     * Get indSalud
     *
     * @return MinSal\SidPla\IndicadoresTemplateBundle\Entity\IndicadorSalud 
     */
    public function getIndSalud()
    {
        return $this->indSalud;
    }

    /**
     * Set evaResul
     *
     * @param MinSal\SidPla\IndicadoresTemplateBundle\Entity\EvaluacionResultado $evaResul
     */
    public function setEvaResul(\MinSal\SidPla\IndicadoresTemplateBundle\Entity\EvaluacionResultado $evaResul)
    {
        $this->evaResul = $evaResul;
    }

    /**
     * Get evaResul
     *
     * @return MinSal\SidPla\IndicadoresTemplateBundle\Entity\EvaluacionResultado 
     */
    public function getEvaResul()
    {
        return $this->evaResul;
    }
}