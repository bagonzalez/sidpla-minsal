<?php

namespace MinSal\SidPla\RRMedicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\RRMedicoBundle\Entity\ResulPrograRRMed
 *
 * @ORM\Table(name="sidpla_resultadoprogrecurso")
 * @ORM\Entity
 */
class ResulPrograRRMed {

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
     * @ORM\ManyToOne(targetEntity="TipoHorario", inversedBy="resProTip")
     * @ORM\JoinColumn(name="tiphor_codigo", referencedColumnName="tiphor_codigo")
     */
    private $tipoHorario;

    /**
     * @ORM\ManyToOne(targetEntity="PrograRRMed", inversedBy="resProRRMed")
     * @ORM\JoinColumn(name="prorecmed_codigo", referencedColumnName="prorecmed_codigo")
     */
    private $prograRRHH;

    


    /**
     * Get codResproRR
     *
     * @return integer 
     */
    public function getCodResproRR()
    {
        return $this->codResproRR;
    }

    /**
     * Set cantRRMedDispo
     *
     * @param integer $cantRRMedDispo
     */
    public function setCantRRMedDispo($cantRRMedDispo)
    {
        $this->cantRRMedDispo = $cantRRMedDispo;
    }

    /**
     * Get cantRRMedDispo
     *
     * @return integer 
     */
    public function getCantRRMedDispo()
    {
        return $this->cantRRMedDispo;
    }

    /**
     * Set totalHorasRR
     *
     * @param float $totalHorasRR
     */
    public function setTotalHorasRR($totalHorasRR)
    {
        $this->totalHorasRR = $totalHorasRR;
    }

    /**
     * Get totalHorasRR
     *
     * @return float 
     */
    public function getTotalHorasRR()
    {
        return $this->totalHorasRR;
    }

    /**
     * Set ConsulasDispo
     *
     * @param integer $consulasDispo
     */
    public function setConsulasDispo($consulasDispo)
    {
        $this->ConsulasDispo = $consulasDispo;
    }

    /**
     * Get ConsulasDispo
     *
     * @return integer 
     */
    public function getConsulasDispo()
    {
        return $this->ConsulasDispo;
    }

    /**
     * Set tipoHorario
     *
     * @param MinSal\SidPla\RRMedicoBundle\Entity\TipoHorario $tipoHorario
     */
    public function settipoHorario(\MinSal\SidPla\RRMedicoBundle\Entity\TipoHorario $tipoHorario)
    {
        $this->tipoHorario = $tipoHorario;
    }

    /**
     * Get tipoHorario
     *
     * @return MinSal\SidPla\RRMedicoBundle\Entity\TipoHorario 
     */
    public function gettipoHorario()
    {
        return $this->tipoHorario;
    }

    /**
     * Set prograRRHH
     *
     * @param MinSal\SidPla\RRMedicoBundle\Entity\PrograRRMed $prograRRHH
     */
    public function setPrograRRHH(\MinSal\SidPla\RRMedicoBundle\Entity\PrograRRMed $prograRRHH)
    {
        $this->prograRRHH = $prograRRHH;
    }

    /**
     * Get prograRRHH
     *
     * @return MinSal\SidPla\RRMedicoBundle\Entity\PrograRRMed 
     */
    public function getPrograRRHH()
    {
        return $this->prograRRHH;
    }
}