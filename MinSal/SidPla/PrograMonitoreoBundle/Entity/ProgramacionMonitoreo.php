<?php

namespace MinSal\SidPla\PrograMonitoreoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\PrograMonitoreoBundle\Entity\ProgramacionMonitoreo
 *
 * @ORM\Table(name="sidpla_programacionmonitoreo")
 * @ORM\Entity
 */
class ProgramacionMonitoreo
{
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
     * Set idPrograMon
     *
     * @param integer $idPrograMon
     */
    public function setIdPrograMon($idPrograMon)
    {
        $this->idPrograMon = $idPrograMon;
    }

    /**
     * Get idPrograMon
     *
     * @return integer 
     */
    public function getIdPrograMon()
    {
        return $this->idPrograMon;
    }

    /**
     * Set idPao
     *
     * @param integer $idPao
     */
    public function setIdPao($idPao)
    {
        $this->idPao = $idPao;
    }

    /**
     * Get idPao
     *
     * @return integer 
     */
    public function getIdPao()
    {
        return $this->idPao;
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