<?php

namespace MinSal\SidPla\IndicadoresTemplateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\IndicadoresTemplateBundle\Entity\EvaluacionResultado
 *
 * @ORM\Table(name="sidpla_evaluacionresultado")
 * @ORM\Entity
 */
class EvaluacionResultado {

    /**
     * @var integer $codEvaRes
     *
     * @ORM\Column(name="evares_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codEvaRes;

    /**
     * @ORM\OneToMany(targetEntity="EvaluacionIndicador", mappedBy="evaResul")
     */
    private $evaIndi;

    /**
     * @ORM\OneToOne(targetEntity="MinSal\SidPla\PaoBundle\Entity\Pao", inversedBy="evaluacionResultado")
     * @ORM\JoinColumn(name="pao_codigo", referencedColumnName="pao_codigo")
     */
    private $paoEvaResul;

    public function __construct()
    {
        $this->evaIndi = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get codEvaRes
     *
     * @return integer 
     */
    public function getCodEvaRes()
    {
        return $this->codEvaRes;
    }

    /**
     * Add evaIndi
     *
     * @param MinSal\SidPla\IndicadoresTemplateBundle\Entity\EvaluacionIndicador $evaIndi
     */
    public function addEvaIndi(\MinSal\SidPla\IndicadoresTemplateBundle\Entity\EvaluacionIndicador $evaIndi)
    {
        $this->evaIndi[] = $evaIndi;
    }

    /**
     * Get evaIndi
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEvaIndi()
    {
        return $this->evaIndi;
    }

    /**
     * Set paoEvaResul
     *
     * @param MinSal\SidPla\PaoBundle\Entity\Pao $paoEvaResul
     */
    public function setPaoEvaResul(\MinSal\SidPla\PaoBundle\Entity\Pao $paoEvaResul)
    {
        $this->paoEvaResul = $paoEvaResul;
    }

    /**
     * Get paoEvaResul
     *
     * @return MinSal\SidPla\PaoBundle\Entity\Pao 
     */
    public function getPaoEvaResul()
    {
        return $this->paoEvaResul;
    }
}