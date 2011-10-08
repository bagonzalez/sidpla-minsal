<?php

namespace MinSal\SidPla\PaoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\PaoBundle\Entity\PeriodoOficial
 *
 * @ORM\Table(name="sidpla_periodooficial")
 * @ORM\Entity
 */

class PeriodoOficial
{
    /**
     * @var integer $idPerOfi
     *
     * @ORM\Column(name="periodoficial_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idPerOfi;

    /**
     * @var bigint $anioPerOfi
     *
     * @ORM\Column(name="periodoficial_anio", type="bigint")
     */
    private $anioPerOfi;

    /**
     * @var date $fechIniPerOfi
     *
     * @ORM\Column(name="periodoficial_fechainicio", type="date")
     */
    private $fechIniPerOfi;

    /**
     * @var date $fechFinPerOfi
     *
     * @ORM\Column(name="periodoficial_fechafin", type="date")
     */
    private $fechFinPerOfi;

    /**
     * @var boolean $activoPerOfi
     *
     * @ORM\Column(name="periodoficial_activo", type="boolean")
     */
    private $activoPerOfi;

     /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\PaoBundle\Entity\TipoPeriodo", inversedBy="periodooficiales")
     * @ORM\JoinColumn(name="tipoperiodo_codigo", referencedColumnName="tipoperiodo_codigo")
     */
    private $tipPerioPerOfi;
   
    /**
     * Get idPerOfi
     *
     * @return integer 
     */
    public function getIdPerOfi()
    {
        return $this->idPerOfi;
    }

    /**
     * Set anioPerOfi
     *
     * @param bigint $anioPerOfi
     */
    public function setAnioPerOfi($anioPerOfi)
    {
        $this->anioPerOfi = $anioPerOfi;
    }

    /**
     * Get anioPerOfi
     *
     * @return interger 
     */
    public function getAnioPerOfi()
    {
        return $this->anioPerOfi;
    }

    /**
     * Set fechIniPerOfi
     *
     * @param datetime $fechIniPerOfi
     */
    public function setFechIniPerOfi($fechIniPerOfi)
    {
        $date = new \DateTime($fechIniPerOfi);
        $this->fechIniPerOfi =$date;    

    }

    /**
     * Get fechIniPerOfi
     *
     * @return datetime 
     */
    public function getFechIniPerOfi()
    {
        return $this->fechIniPerOfi;
    }

    /**
     * Set fechFinPerOfi
     *
     * @param date $fechFinPerOfi
     */
    public function setFechFinPerOfi($fechFinPerOfi)
    {
        $date = new \DateTime($fechFinPerOfi);
        $this->fechFinPerOfi =$date;
     
    }

    /**
     * Get fechFinPerOfi
     *
     * @return date 
     */
    public function getFechFinPerOfi()
    {
        return $this->fechFinPerOfi;
    }

    /**
     * Set activoPerOfi
     *
     * @param boolean $activoPerOfi
     */
    public function setActivoPerOfi($activoPerOfi)
    {
        $this->activoPerOfi = $activoPerOfi;
    }

    /**
     * Get activoPerOfi
     *
     * @return boolean 
     */
    public function getActivoPerOfi()
    {
        return $this->activoPerOfi;
    }



    /**
     * Set tipPerioPerOfi
     *
     * @param MinSal\SidPla\PaoBundle\Entity\TipoPeriodo $tipPerioPerOfi
     */
    public function setTipPerioPerOfi(\MinSal\SidPla\PaoBundle\Entity\TipoPeriodo $tipPerioPerOfi)
    {
        $this->tipPerioPerOfi = $tipPerioPerOfi;
    }

    /**
     * Get tipPerioPerOfi
     *
     * @return MinSal\SidPla\PaoBundle\Entity\TipoPeriodo 
     */
    public function getTipPerioPerOfi()
    {
        return $this->tipPerioPerOfi;
    }
}