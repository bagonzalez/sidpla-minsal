<?php

namespace MinSal\SidPla\RRMedicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\RRMedicoBundle\Entity\ResulPrograRRMed
 *
 * @ORM\Table(name="sidpla_resultadoprogrecurso")
 * @ORM\Entity
 */
class ResulPrograRRMed
{
    /**
     * @var integer $codResproRR
     *
     * @ORM\Column(name="resprorec_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codResproRR;

    /**
     * @var integer $cantRRMedDispo
     *
     * @ORM\Column(name="resprorec_cantidadrecurso", type="integer")
     */
    private $cantRRMedDispo;

    /**
     * @var integer $totalHorasRR
     *
     * @ORM\Column(name="resprorec_totalhorasrecurso", type="float")
     */
    private $totalHorasRR;

    /**
     * @var integer $ConsulasDispo
     *
     * @ORM\Column(name="resprorec_consultasdisponibles", type="integer")
     */
    private $ConsulasDispo;


    /**
     * Get codResproRR
     *
     * @return integer 
     */
    public function getcodResproRR(){
        return $this->codResproRR;
    }

    /**
     * Set cantRRMedDispo
     *
     * @param integer $cantRRMedDispo
     */
    public function setCantRRMedDispo($cantRRMedDispo){
        $this->cantRRMedDispo = $cantRRMedDispo;
    }

    /**
     * Get cantRRMedDispo
     *
     * @return integer 
     */
    public function getCantRRMedDispo(){
        return $this->cantRRMedDispo;
    }

    /**
     * Set totalHorasRR
     *
     * @param integer $totalHorasRR
     */
    public function setTotalHorasRR($totalHorasRR){
        $this->totalHorasRR = $totalHorasRR;
    }

    /**
     * Get totalHorasRR
     *
     * @return integer 
     */
    public function getTotalHorasRR(){
        return $this->totalHorasRR;
    }

    /**
     * Set ConsulasDispo
     *
     * @param integer $consulasDispo
     */
    public function setConsulasDispo($consulasDispo){
        $this->ConsulasDispo = $consulasDispo;
    }

    /**
     * Get ConsulasDispo
     *
     * @return integer 
     */
    public function getConsulasDispo(){
        return $this->ConsulasDispo;
    }
}