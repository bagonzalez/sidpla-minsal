<?php

namespace MinSal\SidPla\GesObjEspBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\GesObjEspBundle\Entity\ActividadVinculada
 *
 * @ORM\Table(name="sidpla_actividadvinculada")
 * @ORM\Entity
 */
class ActividadVinculada
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="actvin_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */  
    private $idActVincu;
    
    /**
     * @ORM\ManyToOne(targetEntity="Actividad", inversedBy="actvinculadasorigen")
     * @ORM\JoinColumn(name="actividad_actividadorigen", referencedColumnName="actividad_codigo")
     */
    private $actOrigen;
    
    /**
     * @ORM\Column(name="actividad_actividadorigen", type="integer")
     */
    private $idActOrigen;
    
    /**
     * @ORM\ManyToOne(targetEntity="Actividad", inversedBy="actdestinos")
     * @ORM\JoinColumn(name="actividad_actividaddestino", referencedColumnName="actividad_codigo")
     */
    private $actDest;
    
    /**
     * @ORM\Column(name="actividad_actividaddestino", type="integer")
     */
    private $idActDest;


    /**
     * @var text $justificacion
     *
     * @ORM\Column(name="actvin_justificacion", type="text")
     */
    private $justificacion;
    
    
       /**
     * @var text $justificacion
     *
     * @ORM\Column(name="actvin_justificacionestado", type="text")
     */
    private $justificacionEstado;

    /**
     * @var string $estado
     *
     * @ORM\Column(name="actvin_estado", type="string", length=15)
     */
    private $estado;
    
           
     /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\PrograMonitoreoBundle\Entity\ProgramacionMonitoreo", inversedBy="actvinculadasOrigen")
     * @ORM\JoinColumn(name="promon_codigoorigen", referencedColumnName="promon_codigo")
     */
    protected $programacionMonitoreoOrigen;
    
             
     /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\PrograMonitoreoBundle\Entity\ProgramacionMonitoreo", inversedBy="actvinculadasDestino")
     * @ORM\JoinColumn(name="promon_codigodestino", referencedColumnName="promon_codigo")
     */
    protected $programacionMonitoreoDestino;
    
      
    /**
     * Set idActVincu
     *
     * @param integer $idActVincu
     */
    public function setIdActVincu($idActVincu)
    {
        $this->idActVincu = $idActVincu;
    }

    /**
     * Get idActVincu
     *
     * @return integer 
     */
    public function getIdActVincu()
    {
        return $this->idActVincu;
    }
    

    /**
     * Set justificacion
     *
     * @param text $justificacion
     */
    public function setJustificacion($justificacion)
    {
        $this->justificacion = $justificacion;
    }

    /**
     * Get justificacion
     *
     * @return text 
     */
    public function getJustificacion()
    {
        return $this->justificacion;
    }
    
    
    /**
     * Set justificacion
     *
     * @param text $justificacion
     */
    public function setJustificacionEstado($justificacion)
    {
        $this->justificacionEstado = $justificacion;
    }

    /**
     * Get justificacion
     *
     * @return text 
     */
    public function getJustificacionEstado()
    {
        return $this->justificacionEstado;
    }

    /**
     * Set estado
     *
     * @param string $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set actOrigen
     *
     * @param MinSal\SidPla\GesObjEspBundle\Entity\Actividad $actOrigen
     */
    public function setActOrigen(\MinSal\SidPla\GesObjEspBundle\Entity\Actividad $actOrigen)
    {
        $this->actOrigen = $actOrigen;
    }

    /**
     * Get actOrigen
     *
     * @return MinSal\SidPla\GesObjEspBundle\Entity\Actividad 
     */
    public function getActOrigen()
    {
        return $this->actOrigen;
    }

    /**
     * Set actDest
     *
     * @param MinSal\SidPla\GesObjEspBundle\Entity\Actividad $actDest
     */
    public function setActDest(\MinSal\SidPla\GesObjEspBundle\Entity\Actividad $actDest)
    {
        $this->actDest = $actDest;
    }

    /**
     * Get actDest
     *
     * @return MinSal\SidPla\GesObjEspBundle\Entity\Actividad 
     */
    public function getActDest()
    {
        return $this->actDest;
    }

    /**
     * Set idActOrigen
     *
     * @param integer $idActOrigen
     */
    public function setIdActOrigen($idActOrigen)
    {
        $this->idActOrigen = $idActOrigen;
    }

    /**
     * Get idActOrigen
     *
     * @return integer 
     */
    public function getIdActOrigen()
    {
        return $this->idActOrigen;
    }

    /**
     * Set idActDest
     *
     * @param integer $idActDest
     */
    public function setIdActDest($idActDest)
    {
        $this->idActDest = $idActDest;
    }

    /**
     * Get idActDest
     *
     * @return integer 
     */
    public function getIdActDest()
    {
        return $this->idActDest;
    }
    
    /**
     * Set programacionMonitoreo
     *
     * @param integer $programacionMonitoreo
     */
    public function setProgramacionMonitoreoOrigen($programacionMonitoreo)
    {
        $this->programacionMonitoreoOrigen = $programacionMonitoreo;
    }

    /**
     * Get programacionMonitoreo
     *
     * @return integer 
     */
    public function getProgramacionMonitoreoOrigen()
    {
        return $this->programacionMonitoreoOrigen;
    }
    
        /**
     * Set programacionMonitoreo
     *
     * @param integer $programacionMonitoreo
     */
    public function setProgramacionMonitoreoDestino($programacionMonitoreo)
    {
        $this->programacionMonitoreoDestino = $programacionMonitoreo;
    }

    /**
     * Get programacionMonitoreo
     *
     * @return integer 
     */
    public function getProgramacionMonitoreoDestino()
    {
        return $this->programacionMonitoreoDestino;
    }
    
}