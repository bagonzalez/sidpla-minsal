<?php

namespace MinSal\SidPla\TemplateUnisalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * MinSal\SidPla\TemplateUnisalBundle\Entity\ResultActUniSal
 *
 * @ORM\Table(name="sidpla_resultadoactividadunisal")
 * @ORM\Entity
 */
class ResultActUniSal {
    
     /**
     * @var integer $idResulAct
     *
     * @ORM\Column(name="resactu_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idResulAct;    
    
    
     /**
     * @var integer $resulActProgramado
     *
     * @ORM\Column(name="resactu_programado", type="integer")
     */
    private $resulActProgramado;
    
    
    /**
     * @var integer $resulActRealizado
     *
     * @ORM\Column(name="resactu_real", type="integer")
     */
    private $resulActRealizado;
    
     /**
     * @var integer $mes
     *
     * @ORM\Column(name="resactu_mes", type="integer")
     */
    private $mes;
    
     /**
     * @var date $resulActFechaInicio
     *
     * @ORM\Column(name="resactu_fechainicio", type="date")
     */
    private $resulActFechaInicio;

    /**
     * @var date $resulActFechaFin
     *
     * @ORM\Column(name="resactu_fechafin", type="date")
     */
    private $resulActFechaFin;
    
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\PrograMonitoreoBundle\Entity\ProgramacionMonitoreo", inversedBy="resultadoactUniSal")
     * @ORM\JoinColumn(name="promon_codigo", referencedColumnName="promon_codigo")
     */
    protected $programacionMonitoreo;
    
    
     /**
     * @ORM\ManyToOne(targetEntity="ActividadUniSal", inversedBy="resultadoactUniSal")
     * @ORM\JoinColumn(name="actuni_codigo", referencedColumnName="actuni_codigo")
     */
    protected $actividadUniSal;
    

    /**
     * Get idResulAct
     *
     * @return integer 
     */
    public function getIdResulAct()
    {
        return $this->idResulAct;
    }

    /**
     * Set resulActProgramado
     *
     * @param integer $resulActProgramado
     */
    public function setResulActProgramado($resulActProgramado)
    {
        $this->resulActProgramado = $resulActProgramado;
    }

    /**
     * Get resulActProgramado
     *
     * @return integer 
     */
    public function getResulActProgramado()
    {
        return $this->resulActProgramado;
    }

    /**
     * Set resulActRealizado
     *
     * @param integer $resulActRealizado
     */
    public function setResulActRealizado($resulActRealizado)
    {
        $this->resulActRealizado = $resulActRealizado;
    }

    /**
     * Get resulActRealizado
     *
     * @return integer 
     */
    public function getResulActRealizado()
    {
        return $this->resulActRealizado;
    }

    /**
     * Set mes
     *
     * @param integer $mes
     */
    public function setMes($mes)
    {
        $this->mes = $mes;
    }

    /**
     * Get mes
     *
     * @return integer 
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set resulActFechaInicio
     *
     * @param date $resulActFechaInicio
     */
    public function setResulActFechaInicio($resulActFechaInicio)
    {
        $this->resulActFechaInicio = $resulActFechaInicio;
    }

    /**
     * Get resulActFechaInicio
     *
     * @return date 
     */
    public function getResulActFechaInicio()
    {
        return $this->resulActFechaInicio;
    }

    /**
     * Set resulActFechaFin
     *
     * @param date $resulActFechaFin
     */
    public function setResulActFechaFin($resulActFechaFin)
    {
        $this->resulActFechaFin = $resulActFechaFin;
    }

    /**
     * Get resulActFechaFin
     *
     * @return date 
     */
    public function getResulActFechaFin()
    {
        return $this->resulActFechaFin;
    }

    /**
     * Set programacionMonitoreo
     *
     * @param MinSal\SidPla\PrograMonitoreoBundle\Entity\ProgramacionMonitoreo $programacionMonitoreo
     */
    public function setProgramacionMonitoreo(\MinSal\SidPla\PrograMonitoreoBundle\Entity\ProgramacionMonitoreo $programacionMonitoreo)
    {
        $this->programacionMonitoreo = $programacionMonitoreo;
    }

    /**
     * Get programacionMonitoreo
     *
     * @return MinSal\SidPla\PrograMonitoreoBundle\Entity\ProgramacionMonitoreo 
     */
    public function getProgramacionMonitoreo()
    {
        return $this->programacionMonitoreo;
    }

    /**
     * Set actividadUniSal
     *
     * @param MinSal\SidPla\TemplateUnisalBundle\Entity\ActividadUniSal $actividadUniSal
     */
    public function setActividadUniSal(\MinSal\SidPla\TemplateUnisalBundle\Entity\ActividadUniSal $actividadUniSal)
    {
        $this->actividadUniSal = $actividadUniSal;
    }

    /**
     * Get actividadUniSal
     *
     * @return MinSal\SidPla\TemplateUnisalBundle\Entity\ActividadUniSal 
     */
    public function getActividadUniSal()
    {
        return $this->actividadUniSal;
    }
}