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
}