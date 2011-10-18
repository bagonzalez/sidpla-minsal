<?php

namespace MinSal\SidPla\GesObjEspBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * MinSal\SidPla\GesObjEspBundle\Entity\Resultadore
 *
 * @ORM\Table(name="sidpla_resultadore")
 * @ORM\Entity
 */
class Resultadore
{
    /**
     * @var integer $idResultadore
     *
     * @ORM\Column(name="resultadore_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idResultadore;

   
    
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado", inversedBy="Resultadore", cascade={"remove"})
     * @ORM\JoinColumn(name="resesp_codigo", referencedColumnName="resesp_codigo")
     */
    private $idResEsp;

    /**
     * @var integer $idProgMoni
     *
     * @ORM\Column(name="promon_codigo", type="integer")
     */
    private $idProgMoni;

    /**
     * @var integer $resultadoreProgramado
     *
     * @ORM\Column(name="resultadore_programado", type="integer")
     */
    private $resultadoreProgramado;

    /**
     * @var integer $resultadoreTrimestre
     *
     * @ORM\Column(name="resultadore_trimestre", type="integer")
     */
    private $resultadoreTrimestre;

    /**
     * @var integer $resultadoreRealizado
     *
     * @ORM\Column(name="resultadore_real", type="integer")
     */
    private $resultadoreRealizado;
    
     /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\PrograMonitoreoBundle\Entity\ProgramacionMonitoreo", inversedBy="resultadores")
     * @ORM\JoinColumn(name="promon_codigo", referencedColumnName="promon_codigo")
     */
    protected $programacionMonitoreo;

    /**
     * @ORM\OneToMany(targetEntity="MinSal\SidPla\PrograMonitoreoBundle\Entity\CompromisoCumplimiento", mappedBy="idResultadore")
     */
    protected $compromisocumplimiento;

    /**
     * Set idResultadore
     *
     * @param integer $idResultadore
     */
    public function setIdResultadore($idResultadore)
    {
        $this->idResultadore = $idResultadore;
    }

    /**
     * Get idResultadore
     *
     * @return integer 
     */
    public function getIdResultadore()
    {
        return $this->idResultadore;
    }

    /**
     * Set idResEsp
     *
     * @param MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado $idResEsp
     */
    public function setIdResEsp(\MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado $idResEsp)
    {
        $this->idResEsp = $idResEsp;
    }

    /**
     * Get idResEsp
     *
     * @return MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado
     */
    public function getIdResEsp()
    {
        return $this->idResEsp;
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
     * Set resultadoreProgramado
     *
     * @param integer $resultadoreProgramado
     */
    public function setResultadoreProgramado($resultadoreProgramado)
    {
        $this->resultadoreProgramado = $resultadoreProgramado;
    }

    /**
     * Get resultadoreProgramado
     *
     * @return integer 
     */
    public function getResultadoreProgramado()
    {
        return $this->resultadoreProgramado;
    }

    /**
     * Set resultadoreTrimestre
     *
     * @param integer $resultadoreTrimestre
     */
    public function setResultadoreTrimestre($resultadoreTrimestre)
    {
        $this->resultadoreTrimestre = $resultadoreTrimestre;
    }

    /**
     * Get resultadoreTrimestre
     *
     * @return integer 
     */
    public function getResultadoreTrimestre()
    {
        return $this->resultadoreTrimestre;
    }

    /**
     * Set resultadoreRealizado
     *
     * @param integer $resultadoreRealizado
     */
    public function setResultadoreRealizado($resultadoreRealizado)
    {
        $this->resultadoreRealizado = $resultadoreRealizado;
    }

    /**
     * Get resultadoreRealizado
     *
     * @return integer 
     */
    public function getResultadoreRealizado()
    {
        return $this->resultadoreRealizado;
    }
    
    /**
     * Set programacionMonitoreo
     *
     * @param integer $programacionMonitoreo
     */
    public function setProgramacionMonitoreo($programacionMonitoreo)
    {
        $this->programacionMonitoreo = $programacionMonitoreo;
    }

    /**
     * Get programacionMonitoreo
     *
     * @return integer 
     */
    public function getProgramacionMonitoreo()
    {
        return $this->programacionMonitoreo;
    }
    
    public function __construct() {
        $this->compromisocumplimiento = new ArrayCollection();
       
    }
    
    /**
     * Add compromisocumplimiento
     *
     * @param MinSal\SidPla\PrograMonitoreoBundle\Entity\CompromisoCumplimiento $compromisocumplimiento
     */
    public function addCompromisoCumplimiento(\MinSal\SidPla\PrograMonitoreoBundle\Entity\CompromisoCumplimiento $compromisocumplimiento) {
        $this->compromisocumplimiento[] = $compromisocumplimiento;
    }

    /**
     * Get compromisocumplimiento
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCompromisoCumplimiento() {
        return $this->compromisocumplimiento;
    }
}