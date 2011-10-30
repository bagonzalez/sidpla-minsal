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
     * @var date $iniFechOrSeg
     *
     * @ORM\Column(name="reprogra_inifechoseg", type="date")
     */
    private $iniFechOrSeg;

    /**
     * @var date $finFechOrSeg
     *
     * @ORM\Column(name="reprogra_finfechoseg", type="date")
     */
    private $finFechOrSeg;

    /**
     * @var date $iniFechNuSeg
     *
     * @ORM\Column(name="reprogra_inifechnseg", type="date")
     */
    private $iniFechNuSeg;

    /**
     * @var date $finFechNuSeg
     *
     * @ORM\Column(name="reprogra_finfechnseg", type="date")
     */
    private $finFechNuSeg;

    /**
     * @var float $prograOrSeg
     *
     * @ORM\Column(name="reprogra_valoroseg", type="float")
     */
    private $prograOrSeg;

    /**
     * @var float $prograNuSeg
     *
     * @ORM\Column(name="reprogra_valornseg", type="float")
     */
    private $prograNuSeg;

    /**
     * @var date $iniFechOrTer
     *
     * @ORM\Column(name="reprogra_inifechoter", type="date")
     */
    private $iniFechOrTer;

    /**
     * @var date $finFechOrTer
     *
     * @ORM\Column(name="reprogra_finfechoter", type="date")
     */
    private $finFechOrTer;

    /**
     * @var date $iniFechNuTer
     *
     * @ORM\Column(name="reprogra_inifechnter", type="date")
     */
    private $iniFechNuTer;

    /**
     * @var date $finFechNuTer
     *
     * @ORM\Column(name="reprogra_finfechnter", type="date")
     */
    private $finFechNuTer;

    /**
     * @var float $prograOrTer
     *
     * @ORM\Column(name="reprogra_valoroter", type="float")
     */
    private $prograOrTer;

    /**
     * @var float $prograNuTer
     *
     * @ORM\Column(name="reprogra_valornter", type="float")
     */
    private $prograNuTer;

    /**
     * @var date $iniFechOrCua
     *
     * @ORM\Column(name="reprogra_inifechocua", type="date")
     */
    private $iniFechOrCua;

    /**
     * @var date $finFechOrCua
     *
     * @ORM\Column(name="reprogra_finfechocua", type="date")
     */
    private $finFechOrCua;

    /**
     * @var date $iniFechNuCua
     *
     * @ORM\Column(name="reprogra_inifechncua", type="date")
     */
    private $iniFechNuCua;

    /**
     * @var date $finFechNuCua
     *
     * @ORM\Column(name="reprogra_finfechncua", type="date")
     */
    private $finFechNuCua;

    /**
     * @var float $prograOrCua
     *
     * @ORM\Column(name="reprogra_valorocua", type="float")
     */
    private $prograOrCua;

    /**
     * @var float $prograNuCua
     *
     * @ORM\Column(name="reprogra_valorncua", type="float")
     */
    private $prograNuCua;


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
     * Set iniFechOrSeg
     *
     * @param date $iniFechOrSeg
     */
    public function setIniFechOrSeg($iniFechOrSeg)
    {
        $date = new \DateTime($iniFechOrSeg);
        $this->iniFechOrSeg = $date;
    }

    /**
     * Get iniFechOrSeg
     *
     * @return date 
     */
    public function getIniFechOrSeg()
    {
        return $this->iniFechOrSeg;
    }

    /**
     * Set finFechOrSeg
     *
     * @param date $finFechOrSeg
     */
    public function setFinFechOrSeg($finFechOrSeg)
    {
        $date = new \DateTime($finFechOrSeg);
        $this->finFechOrSeg = $date;
    }

    /**
     * Get finFechOrSeg
     *
     * @return date 
     */
    public function getFinFechOrSeg()
    {
        return $this->finFechOrSeg;
    }

    /**
     * Set iniFechNuSeg
     *
     * @param date $iniFechNuSeg
     */
    public function setIniFechNuSeg($iniFechNuSeg)
    {
        $date = new \DateTime($iniFechNuSeg);
        $this->iniFechNuSeg = $date;
    }

    /**
     * Get iniFechNuSeg
     *
     * @return date 
     */
    public function getIniFechNuSeg()
    {
        return $this->iniFechNuSeg;
    }

    /**
     * Set finFechNuSeg
     *
     * @param date $finFechNuSeg
     */
    public function setFinFechNuSeg($finFechNuSeg)
    {
        $date = new \DateTime($finFechNuSeg);
        $this->finFechNuSeg = $date;
    }

    /**
     * Get finFechNuSeg
     *
     * @return date 
     */
    public function getFinFechNuSeg()
    {
        return $this->finFechNuSeg;
    }

    /**
     * Set prograOrSeg
     *
     * @param float $prograOrSeg
     */
    public function setPrograOrSeg($prograOrSeg)
    {
        $this->prograOrSeg = $prograOrSeg;
    }

    /**
     * Get prograOrSeg
     *
     * @return float 
     */
    public function getPrograOrSeg()
    {
        return $this->prograOrSeg;
    }

    /**
     * Set prograNuSeg
     *
     * @param float $prograNuSeg
     */
    public function setPrograNuSeg($prograNuSeg)
    {
        $this->prograNuSeg = $prograNuSeg;
    }

    /**
     * Get prograNuSeg
     *
     * @return float 
     */
    public function getPrograNuSeg()
    {
        return $this->prograNuSeg;
    }

    /**
     * Set iniFechOrTer
     *
     * @param date $iniFechOrTer
     */
    public function setIniFechOrTer($iniFechOrTer)
    {
        $date = new \DateTime($iniFechOrTer);
        $this->iniFechOrTer = $date;
    }

    /**
     * Get iniFechOrTer
     *
     * @return date 
     */
    public function getIniFechOrTer()
    {
        return $this->iniFechOrTer;
    }

    /**
     * Set finFechOrTer
     *
     * @param date $finFechOrTer
     */
    public function setFinFechOrTer($finFechOrTer)
    {
        $date = new \DateTime($finFechOrTer);
        $this->finFechOrTer = $date;
    }

    /**
     * Get finFechOrTer
     *
     * @return date 
     */
    public function getFinFechOrTer()
    {
        return $this->finFechOrTer;
    }

    /**
     * Set iniFechNuTer
     *
     * @param date $iniFechNuTer
     */
    public function setIniFechNuTer($iniFechNuTer)
    {
        $date = new \DateTime($iniFechNuTer);
        $this->iniFechNuTer = $date;
    }

    /**
     * Get iniFechNuTer
     *
     * @return date 
     */
    public function getIniFechNuTer()
    {
        return $this->iniFechNuTer;
    }

    /**
     * Set finFechNuTer
     *
     * @param date $finFechNuTer
     */
    public function setFinFechNuTer($finFechNuTer)
    {
        $date = new \DateTime($finFechNuTer);
        $this->finFechNuTer = $date;
    }

    /**
     * Get finFechNuTer
     *
     * @return date 
     */
    public function getFinFechNuTer()
    {
        return $this->finFechNuTer;
    }

    /**
     * Set prograOrTer
     *
     * @param float $prograOrTer
     */
    public function setPrograOrTer($prograOrTer)
    {
        $this->prograOrTer = $prograOrTer;
    }

    /**
     * Get prograOrTer
     *
     * @return float 
     */
    public function getPrograOrTer()
    {
        return $this->prograOrTer;
    }

    /**
     * Set prograNuTer
     *
     * @param float $prograNuTer
     */
    public function setPrograNuTer($prograNuTer)
    {
        $this->prograNuTer = $prograNuTer;
    }

    /**
     * Get prograNuTer
     *
     * @return float 
     */
    public function getPrograNuTer()
    {
        return $this->prograNuTer;
    }

    /**
     * Set iniFechOrCua
     *
     * @param date $iniFechOrCua
     */
    public function setIniFechOrCua($iniFechOrCua)
    {
        $date = new \DateTime($iniFechOrCua);
        $this->iniFechOrCua = $date;
    }

    /**
     * Get iniFechOrCua
     *
     * @return date 
     */
    public function getIniFechOrCua()
    {
        return $this->iniFechOrCua;
    }

    /**
     * Set finFechOrCua
     *
     * @param date $finFechOrCua
     */
    public function setFinFechOrCua($finFechOrCua)
    {
        $date = new \DateTime($finFechOrCua);
        $this->finFechOrCua = $date;
    }

    /**
     * Get finFechOrCua
     *
     * @return date 
     */
    public function getFinFechOrCua()
    {
        return $this->finFechOrCua;
    }

    /**
     * Set iniFechNuCua
     *
     * @param date $iniFechNuCua
     */
    public function setIniFechNuCua($iniFechNuCua)
    {
        $date = new \DateTime($iniFechNuCua);
        $this->iniFechNuCua = $date;
    }

    /**
     * Get iniFechNuCua
     *
     * @return date 
     */
    public function getIniFechNuCua()
    {
        return $this->iniFechNuCua;
    }

    /**
     * Set finFechNuCua
     *
     * @param date $finFechNuCua
     */
    public function setFinFechNuCua($finFechNuCua)
    {
        $date = new \DateTime($finFechNuCua);
        $this->finFechNuCua = $date;
    }

    /**
     * Get finFechNuCua
     *
     * @return date 
     */
    public function getFinFechNuCua()
    {
        return $this->finFechNuCua;
    }

    /**
     * Set prograOrCua
     *
     * @param float $prograOrCua
     */
    public function setPrograOrCua($prograOrCua)
    {
        $this->prograOrCua = $prograOrCua;
    }

    /**
     * Get prograOrCua
     *
     * @return float 
     */
    public function getPrograOrCua()
    {
        return $this->prograOrCua;
    }

    /**
     * Set prograNuCua
     *
     * @param float $prograNuCua
     */
    public function setPrograNuCua($prograNuCua)
    {
        $this->prograNuCua = $prograNuCua;
    }

    /**
     * Get prograNuCua
     *
     * @return float 
     */
    public function getPrograNuCua()
    {
        return $this->prograNuCua;
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