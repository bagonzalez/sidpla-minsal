<?php

namespace MinSal\SidPla\PaoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\PaoBundle\Entity\PeriodoOficial
 *
 * @ORM\Table(name="sidpla_periodooficial)
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
     * @var interger $anioPerOfi
     *
     * @ORM\Column(name="periodoficial_anio", type="interger")
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
     * @var date $activoPerOfi
     *
     * @ORM\Column(name="periodoficial_activo", type="boolean")
     */
    private $activoPerOfi;

    
     /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\PaoBundle\Entity\Pao", inversedBy="periodooficiales")
     * @ORM\JoinColumn(name="tipoperiodo_codigo", referencedColumnName="tipoperiodo_codigo")
     */
    protected $pao;


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
     * Set idPerOfi
     *
     * @param integer $idPerOfi
     */
    public function setIdPerOfi($idPerOfi)
    {
        $this->idPerOfi = $idPerOfi;
    }

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
     * @param interger $anioPerOfi
     */
    public function setAnioPerOfi(\interger $anioPerOfi)
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
     * @param date $fechIniPerOfi
     */
    public function setFechIniPerOfi($fechIniPerOfi)
    {
        $this->fechIniPerOfi = $fechIniPerOfi;
    }

    /**
     * Get fechIniPerOfi
     *
     * @return date 
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
        $this->fechFinPerOfi = $fechFinPerOfi;
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
     * @param boolean $activoTipPer
     */
    public function setActivoTipPer($activoPerOfi)
    {
        $this->activoPerOfi = $activoTipPer;
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
     * Set pao
     *
     * @param MinSal\SidPla\PaoBundle\Entity\Pao $pao
     */
    public function setPao(MinSal\SidPla\PaoBundle\Entity\Pao $pao)
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