<?php

namespace MinSal\SidPla\GesObjEspBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\GesObjEspBundle\Entity\ResulActividad
 *
 * @ORM\Table(name="sidpla_resultadoactvidad")
 * @ORM\Entity
 */
class ResulActividad
{
    /**
     * @var integer $idResulAct
     *
     * @ORM\Column(name="resact_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idResulAct;

    
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\GesObjEspBundle\Entity\Actividad", inversedBy="resulAct", cascade={"remove"})
     * @ORM\JoinColumn(name="actividad_codigo", referencedColumnName="actividad_codigo")
     */
    private $idActividad;

    /**
     * @var integer $idProgMoni
     *
     * @ORM\Column(name="promon_codigo", type="integer")
     */
    private $idProgMoni;

    /**
     * @var integer $resulActProgramado
     *
     * @ORM\Column(name="resact_programado", type="integer")
     */
    private $resulActProgramado;

    /**
     * @var integer $resulActTrimestre
     *
     * @ORM\Column(name="resact_trimestre", type="integer")
     */
    private $resulActTrimestre;

    /**
     * @var integer $resulActRealizado
     *
     * @ORM\Column(name="resact_real", type="integer")
     */
    private $resulActRealizado;

    /**
     * @var date $resulActFechaInicio
     *
     * @ORM\Column(name="resact_fechainicio", type="date")
     */
    private $resulActFechaInicio;

    /**
     * @var date $resulActFechaFin
     *
     * @ORM\Column(name="resact_fechafin", type="date")
     */
    private $resulActFechaFin;

     
    /**
     * Set idResulAct
     *
     * @param integer $idResulAct
     */
    public function setIdResulAct($idResulAct)
    {
        $this->idResulAct = $idResulAct;
    }

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
     * Set idActividad
     *
     * @param MinSal\SidPla\GesObjEspBundle\Entity\Actividad $idActividad
     */
    public function setIdActividad(\MinSal\SidPla\GesObjEspBundle\Entity\Actividad $idActividad)
    {
        $this->idActividad = $idActividad;
    }

    /**
     * Get idActividad
     *
     * @return MinSal\SidPla\GesObjEspBundle\Entity\Actividad
     */
    public function getIdActividad()
    {
        return $this->idActividad;
    }

    /**
     * Set idProgMoni
     *
     * @param integer $idProgMoni
     */
    public function setIdProgMoni($idProgMoni)
    {
        $this->idProgMoni = $idProgMoni;
    }

    /**
     * Get idProgMoni
     *
     * @return integer 
     */
    public function getIdProgMoni()
    {
        return $this->idProgMoni;
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
     * Set resulActTrimestre
     *
     * @param integer $resulActTrimestre
     */
    public function setResulActTrimestre($resulActTrimestre)
    {
        $this->resulActTrimestre = $resulActTrimestre;
    }

    /**
     * Get resulActTrimestre
     *
     * @return integer 
     */
    public function getResulActTrimestre()
    {
        return $this->resulActTrimestre;
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
     * Set resulActFechaInicio
     *
     * @param date $resulActFechaInicio
     */
    public function setResulActFechaInicio($resulActFechaInicio)
    {    $date = new \DateTime($resulActFechaInicio);
        $this->resulActFechaInicio = $date;
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
        $date = new \DateTime($resulActFechaFin);
        $this->resulActFechaFin = $date;
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
    
   
    
    
}