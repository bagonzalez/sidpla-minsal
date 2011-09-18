<?php

namespace MinSal\SidPla\EstInfraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\EstInfraBundle\Entity\InfraestructuraEvaluada
 *
 * @ORM\Table("sidpla_infraestructuraevaluada")
 * @ORM\Entity
 */
class InfraestructuraEvaluada
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="infeva_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

     /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\PaoBundle\Entity\Pao", inversedBy="infraEvaluada")
     * @ORM\JoinColumn(name="pao_codigo", referencedColumnName="pao_codigo")
     */
    
    private $pao_codigo;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pao_codigo
     *
     * @param MinSal\SidPla\PaoBundle\Entity\Pao $paoCodigo
     */
    public function setPaoCodigo(MinSal\SidPla\PaoBundle\Entity\Pao $paoCodigo)
    {
        $this->pao_codigo = $paocodigo;
    }

    /**
     * Get pao_codigo
     *
     * @return MinSal\SidPla\PaoBundle\Entity\Pao
     */
    public function getPaoCodigo()
    {
        return $this->pao_codigo;
    }
}