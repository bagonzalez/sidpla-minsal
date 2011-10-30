<?php

namespace MinSal\SidPla\PrograMonitoreoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\PrograMonitoreoBundle\Entity\Reprogramacion
 *
 * @ORM\Table(name="sidpla_reprogramacion")
 * @ORM\Entity
 */
class Reprogramacion {

    /**
     * @var integer $codReprogra
     *
     * @ORM\Column(name="reprogra_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codReprogra;

    /**
     * @var date $iniFechOr
     *
     * @ORM\Column(name="reprogra_inifecho", type="date")
     */
    private $iniFechOr;

    /**
     * @var date $finFechOr
     *
     * @ORM\Column(name="reprogra_finfecho", type="date")
     */
    private $finFechOr;

    /**
     * @var date $iniFechNu
     *
     * @ORM\Column(name="reprogra_inifecn", type="date")
     */
    private $iniFechNu;

    /**
     * @var date $finFechNu
     *
     * @ORM\Column(name="reprogra_finfechn", type="date")
     */
    private $finFechNu;

    /**
     * @var float $prograOr
     *
     * @ORM\Column(name="reprogra_valoro", type="float")
     */
    private $prograOr;

    /**
     * @var float $prograNu
     *
     * @ORM\Column(name="reprogra_valorn", type="float")
     */
    private $prograNu;

    /**
     * @var integer $trimestre
     *
     * @ORM\Column(name="reprogra_trimestre", type="integer")
     */
    private $trimestre;

    /**
     * @ORM\ManyToOne(targetEntity="CompromisoCumplimiento", inversedBy="reprogramaciones")
     * @ORM\JoinColumn(name="comcum_codigo", referencedColumnName="comcum_codigo")
     */
    private $compromisoCumplimiento;

    /**
     * Get codReprogra
     *
     * @return integer 
     */
    public function getCodReprogra() {
        return $this->codReprogra;
    }

    /**
     * Set iniFechOr
     *
     * @param date $iniFechOr
     */
    public function setIniFechOr($iniFechOr) {
        $this->iniFechOr = $iniFechOr;
    }

    /**
     * Get iniFechOr
     *
     * @return date 
     */
    public function getIniFechOr() {
        return $this->iniFechOr;
    }

    /**
     * Set finFechOr
     *
     * @param date $finFechOr
     */
    public function setFinFechOr($finFechOr) {
        $this->finFechOr = $finFechOr;
    }

    /**
     * Get finFechOr
     *
     * @return date 
     */
    public function getFinFechOr() {
        return $this->finFechOr;
    }

    /**
     * Set iniFechNu
     *
     * @param date $iniFechNu
     */
    public function setIniFechNu($iniFechNu) {
        $this->iniFechNu = $iniFechNu;
    }

    /**
     * Get iniFechNu
     *
     * @return date 
     */
    public function getIniFechNu() {
        return $this->iniFechNu;
    }

    /**
     * Set finFechNu
     *
     * @param date $finFechNu
     */
    public function setFinFechNu($finFechNu) {
        $this->finFechNu = $finFechNu;
    }

    /**
     * Get finFechNu
     *
     * @return date 
     */
    public function getFinFechNu() {
        return $this->finFechNu;
    }

    /**
     * Set prograOr
     *
     * @param float $prograOr
     */
    public function setPrograOr($prograOr) {
        $this->prograOr = $prograOr;
    }

    /**
     * Get prograOr
     *
     * @return float 
     */
    public function getPrograOr() {
        return $this->prograOr;
    }

    /**
     * Set prograNu
     *
     * @param float $prograNu
     */
    public function setPrograNu($prograNu) {
        $this->prograNu = $prograNu;
    }

    /**
     * Get prograNu
     *
     * @return float 
     */
    public function getPrograNu() {
        return $this->prograNu;
    }

    /**
     * Set trimestre
     *
     * @param integer $trimestre
     */
    public function setTrimestre($trimestre) {
        $this->trimestre = $trimestre;
    }

    /**
     * Get trimestre
     *
     * @return integer 
     */
    public function getTrimestre() {
        return $this->trimestre;
    }

    /**
     * Set compromisoCumplimiento
     *
     * @param MinSal\SidPla\PrograMonitoreoBundle\Entity\CompromisoCumplimiento $compromisoCumplimiento
     */
    public function setCompromisoCumplimiento(\MinSal\SidPla\PrograMonitoreoBundle\Entity\CompromisoCumplimiento $compromisoCumplimiento) {
        $this->compromisoCumplimiento = $compromisoCumplimiento;
    }

    /**
     * Get compromisoCumplimiento
     *
     * @return MinSal\SidPla\PrograMonitoreoBundle\Entity\CompromisoCumplimiento 
     */
    public function getCompromisoCumplimiento() {
        return $this->compromisoCumplimiento;
    }

}