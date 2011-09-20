<?php

namespace MinSal\SidPla\PaoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\PaoBundle\Entity\PeriodoPao
 *
 * @ORM\Table(name="sidpla_periodopao")
 * @ORM\Entity
 */
class PeriodoPao {

    /**
     * @var integer $codPerPao
     *
     * @ORM\Column(name="periodopao_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codPerPao;

    /**
     * @var datetime $fechIniPerPao
     *
     * @ORM\Column(name="periodopao_fechainicio", type="datetime")
     */
    private $fechIniPerPao;

    /**
     * @var datetime $fechFinPerPao
     *
     * @ORM\Column(name="periodopao_fechafin", type="datetime")
     */
    private $fechFinPerPao;

    /**
     * @var boolean $activoPerPao
     *
     * @ORM\Column(name="periodopao_estadoactivo", type="boolean")
     */
    private $activoPerPao;

    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\PaoBundle\Entity\Estado", inversedBy="EstadoCodigo")
     * @ORM\JoinColumn(name="estado_codigo", referencedColumnName="estado_codigo")
     */
    private $estPerPao;

    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\PaoBundle\Entity\Pao", inversedBy="periodoCalendarizacion")
     * @ORM\JoinColumn(name="pao_codigo", referencedColumnName="pao_codigo")
     */
    private $paoPerPao;

    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\PaoBundle\Entity\TipoPeriodo", inversedBy="TipoPeriodoCodigo")
     * @ORM\JoinColumn(name="tipoperiodo_codigo", referencedColumnName="tipoperiodo_codigo")
     */
    private $tipPeriodoPerPao;

    /**
     * Get codPerPao
     *
     * @return integer 
     */
    public function getCodPerPao() {
        return $this->codPerPao;
    }

    /**
     * Set fechIniPerPao
     *
     * @param datetime $fechIniPerPao
     */
    public function setFechIniPerPao($fechIniPerPao) {
        $date = new \DateTime($fechIniPerPao);
        $this->fechIniPerPao = $date;
    }

    /**
     * Get fechIniPerPao
     *
     * @return datetime 
     */
    public function getFechIniPerPao() {
        return $this->fechIniPerPao;
    }

    /**
     * Set fechFinPerPao
     *
     * @param datetime $fechFinPerPao
     */
    public function setFechFinPerPao($fechFinPerPao) {
        $date = new \DateTime($fechFinPerPao);
        $this->fechFinPerPao = $date;
    }

    /**
     * Get fechFinPerPao
     *
     * @return datetime 
     */
    public function getFechFinPerPao() {
        return $this->fechFinPerPao;
    }

    /**
     * Set activoPerPao
     *
     * @param boolean $activoPerPao
     */
    public function setActivoPerPao($activoPerPao) {
        $this->activoPerPao = $activoPerPao;
    }

    /**
     * Get activoPerPao
     *
     * @return boolean 
     */
    public function getActivoPerPao() {
        return $this->activoPerPao;
    }

    /**
     * Set estPerPao
     *
     * @param MinSal\SidPla\PaoBundle\Entity\Estado $estPerPao
     */
    public function setEstPerPao(\MinSal\SidPla\PaoBundle\Entity\Estado $estPerPao)
    {
        $this->estPerPao = $estPerPao;
    }

    /**
     * Get estPerPao
     *
     * @return MinSal\SidPla\PaoBundle\Entity\Estado 
     */
    public function getEstPerPao()
    {
        return $this->estPerPao;
    }

    /**
     * Set paoPerPao
     *
     * @param MinSal\SidPla\PaoBundle\Entity\Pao $paoPerPao
     */
    public function setPaoPerPao(\MinSal\SidPla\PaoBundle\Entity\Pao $paoPerPao)
    {
        $this->paoPerPao = $paoPerPao;
    }

    /**
     * Get paoPerPao
     *
     * @return MinSal\SidPla\PaoBundle\Entity\Pao 
     */
    public function getPaoPerPao()
    {
        return $this->paoPerPao;
    }

    /**
     * Set tipPeriodoPerPao
     *
     * @param MinSal\SidPla\PaoBundle\Entity\TipoPeriodo $tipPeriodoPerPao
     */
    public function setTipPeriodoPerPao(\MinSal\SidPla\PaoBundle\Entity\TipoPeriodo $tipPeriodoPerPao)
    {
        $this->tipPeriodoPerPao = $tipPeriodoPerPao;
    }

    /**
     * Get tipPeriodoPerPao
     *
     * @return MinSal\SidPla\PaoBundle\Entity\TipoPeriodo 
     */
    public function getTipPeriodoPerPao()
    {
        return $this->tipPeriodoPerPao;
    }
}