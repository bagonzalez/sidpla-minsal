<?php

namespace MinSal\SidPla\RRMedicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\RRMedicoBundle\Entity\PrograRRMed
 *
 * @ORM\Table(name="sidpla_prograrecursomedico")
 * @ORM\Entity
 */
class PrograRRMed
{
    /**
     * @var integer $codPrograRRMed
     *
     * @ORM\Column(name="prorecmed_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codPrograRRMed;

    /**
     * @var float $totaHoras
     *
     * @ORM\Column(name="prorecmed_totalhoras", type="float")
     */
    private $totaHoras;

    /**
     * @var float $totalConsul
     *
     * @ORM\Column(name="precmed_totalconsultas", type="float")
     */
    private $totalConsul;

    /**
     * @var float $totalMinutos
     *
     * @ORM\Column(name="prorecmed_totalminutos", type="float")
     */
    private $totalMinutos;

    /**
     * @ORM\OneToMany(targetEntity="ResulPrograRRMed", mappedBy="prograRRHH")
     */
    private $resProRRMed;
   
    public function __construct()
    {
        $this->resProRRMed = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get codPrograRRMed
     *
     * @return integer 
     */
    public function getCodPrograRRMed()
    {
        return $this->codPrograRRMed;
    }

    /**
     * Set totaHoras
     *
     * @param float $totaHoras
     */
    public function setTotaHoras($totaHoras)
    {
        $this->totaHoras = $totaHoras;
    }

    /**
     * Get totaHoras
     *
     * @return float 
     */
    public function getTotaHoras()
    {
        return $this->totaHoras;
    }

    /**
     * Set totalConsul
     *
     * @param float $totalConsul
     */
    public function setTotalConsul($totalConsul)
    {
        $this->totalConsul = $totalConsul;
    }

    /**
     * Get totalConsul
     *
     * @return float 
     */
    public function getTotalConsul()
    {
        return $this->totalConsul;
    }

    /**
     * Set totalMinutos
     *
     * @param float $totalMinutos
     */
    public function setTotalMinutos($totalMinutos)
    {
        $this->totalMinutos = $totalMinutos;
    }

    /**
     * Get totalMinutos
     *
     * @return float 
     */
    public function getTotalMinutos()
    {
        return $this->totalMinutos;
    }

    /**
     * Add resProRRMed
     *
     * @param MinSal\SidPla\RRMedicoBundle\Entity\ResulPrograRRMed $resProRRMed
     */
    public function addResProRRMed(\MinSal\SidPla\RRMedicoBundle\Entity\ResulPrograRRMed $resProRRMed)
    {
        $this->resProRRMed[] = $resProRRMed;
    }

    /**
     * Get resProRRMed
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getResProRRMed()
    {
        return $this->resProRRMed;
    }
}