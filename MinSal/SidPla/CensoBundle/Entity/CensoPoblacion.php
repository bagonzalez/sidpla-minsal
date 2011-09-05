<?php

namespace MinSal\SidPla\CensoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\CensoBundle\Entity\CensoPoblacion
 *
 * @ORM\Table(name="sidpla_censopoblacion")
 * @ORM\Entity
 */
class CensoPoblacion
{
    /**
     * @var integer $idCensoPoblacion
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
   
    private $idCensoPoblacion;
    
    
      /**
     * @ORM\OneToOne(targetEntity="MinSal\SidPla\PaoBundle\Entity\Pao", inversedBy="cesopoblacion")
     * @ORM\JoinColumn(name="pao_codigo", referencedColumnName="pao_codigo")
     */
    private $pao;


    /**
     * Set idCensoPoblacion
     *
     * @param integer $idCensoPoblacion
     */
    public function setIdCensoPoblacion($idCensoPoblacion)
    {
        $this->idCensoPoblacion = $idCensoPoblacion;
    }

    /**
     * Get idCensoPoblacion
     *
     * @return integer 
     */
    public function getIdCensoPoblacion()
    {
        return $this->idCensoPoblacion;
    }

    /**
     * Set pao
     *
     * @param MinSal\SidPla\PaoBundle\Entity\Pao $pao
     */
    public function setPao(\MinSal\SidPla\PaoBundle\Entity\Pao $pao)
    {
        $this->pao = $pao;
    }

    /**
     * Get pao
     *
     * @return MinSal\SidPla\PaoBundle\Entity\Pao 
     */
    public function getPao()
    {
        return $this->pao;
    }
}