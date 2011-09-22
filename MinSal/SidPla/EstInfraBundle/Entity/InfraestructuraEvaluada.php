<?php

namespace MinSal\SidPla\EstInfraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\EstInfraBundle\Entity\InfraestructuraEvaluada
 *
 * @ORM\Table("sidpla_infraestructuraevaluada")
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
    
    //Llave de Uno a muchos con Evaluacion Elemento Infraestructura
    /**
     * @ORM\OneToMany(targetEntity="EvaluacionElementoInfra", mappedBy="infraEvaluada")
     */
    private $evaEleInfra;

    /**
     * Get idInfraEva
     *
     * @return integer 
     */
    public function getidInfraEva() {
        return $this->idInfraEva;
    }

    /**
     * Set paoInfraEva
     *
     * @param MinSal\SidPla\PaoBundle\Entity\Pao $paoInfraEva
     */
    public function setpaoInfraEva($paoInfraEva) {
        $this->paoInfraEva= $paoInfraEva;
    }

    /**
     * Get paoInfraEva
     *
     * @return MinSal\SidPla\PaoBundle\Entity\Pao
     */
    public function getpaoInfraEva() {
        return $this->paoInfraEva;
    }
    
    public function __construct()
    {
        $this->evaEleInfra  = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add evaEleInfra
     *
     * @param MinSal\SidPla\EstInfraBundle\Entity\EvaluacionElementoInfra $evaEleInfra
     */
    public function addevaEleInfra ($evaEleInfra)
    {
        $this->evaEleInfra[] = $evaEleInfra;
    }

    /**
     * Get evaEleInfra
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getevaEleInfra()
    {
        return $this->evaEleInfra;
    }
    

}