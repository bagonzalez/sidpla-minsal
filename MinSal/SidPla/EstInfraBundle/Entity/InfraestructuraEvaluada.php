<?php

namespace MinSal\SidPla\EstInfraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\EstInfraBundle\Entity\InfraestructuraEvaluada
 *
 * @ORM\Table(name="sidpla_infraestructuraevaluada")
 * @ORM\Entity
 */
class InfraestructuraEvaluada {

    /**
     * @var integer $idInfraEva
     *
     * @ORM\Column(name="infeva_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idInfraEva;

    /**
     * @ORM\OneToOne(targetEntity="MinSal\SidPla\PaoBundle\Entity\Pao", mappedBy="infraEvaluadaPao")
     * @ORM\JoinColumn(name="pao_codigo", referencedColumnName="pao_codigo")
     */
    private $paoInfraEva;
    
     /**
     * @ORM\OneToMany(targetEntity="EvaluacionElementoInfra", mappedBy="infraEvaluada")
     */
    private $evaEleInfra;

     /**
     * Get idInfraEva
     *
     * @return integer 
     */
    public function getIdInfraEva()
    {
        return $this->idInfraEva;
    }
    public function __construct()
    {
        $this->evaEleInfra = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set paoInfraEva
     *
     * @param MinSal\SidPla\PaoBundle\Entity\Pao $paoInfraEva
     */
    public function setPaoInfraEva(\MinSal\SidPla\PaoBundle\Entity\Pao $paoInfraEva)
    {
        $this->paoInfraEva = $paoInfraEva;
    }

    /**
     * Get paoInfraEva
     *
     * @return MinSal\SidPla\PaoBundle\Entity\Pao 
     */
    public function getPaoInfraEva()
    {
        return $this->paoInfraEva;
    }

    /**
     * Add evaEleInfra
     *
     * @param MinSal\SidPla\EstInfraBundle\Entity\EvaluacionElementoInfra $evaEleInfra
     */
    public function addEvaEleInfra(\MinSal\SidPla\EstInfraBundle\Entity\EvaluacionElementoInfra $evaEleInfra)
    {
        $this->evaEleInfra[] = $evaEleInfra;
    }

    /**
     * Get evaEleInfra
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEvaEleInfra()
    {
        return $this->evaEleInfra;
    }
}