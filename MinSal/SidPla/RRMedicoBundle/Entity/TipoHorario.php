<?php

namespace MinSal\SidPla\RRMedicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\RRMedicoBundle\Entity\TipoHorario
 *
 * @ORM\Table(name="sidpla_tipohorario")
 * @ORM\Entity
 */
class TipoHorario {

    /**
     * @var integer $codTipoHor
     *
     * @ORM\Column(name="tiphor_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codTipoHor;

    /**
     * @var string $tipoHorDes
     *
     * @ORM\Column(name="tiphor_descripcion", type="string", length=100)
     */
    private $tipoHorDes;

    /**
     * @var bigint $tipoCantidadHor
     *
     * @ORM\Column(name="tiphor_cantidadhoras", type="bigint")
     */
    private $tipoCantidadHor;

    /**
     * @var bigint $tipoHorTurno
     *
     * @ORM\Column(name="tiphor_turno", type="bigint")
     */
    private $tipoHorTurno;

    /**
     * @ORM\OneToMany(targetEntity="ResulPrograRRMed", mappedBy="tipoHorario")
     */
    private $resProTip;

   

    public function __construct()
    {
        $this->resProTip = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get codTipoHor
     *
     * @return integer 
     */
    public function getCodTipoHor()
    {
        return $this->codTipoHor;
    }

    /**
     * Set tipoHorDes
     *
     * @param string $tipoHorDes
     */
    public function setTipoHorDes($tipoHorDes)
    {
        $this->tipoHorDes = $tipoHorDes;
    }

    /**
     * Get tipoHorDes
     *
     * @return string 
     */
    public function getTipoHorDes()
    {
        return $this->tipoHorDes;
    }

    /**
     * Set tipoCantidadHor
     *
     * @param bigint $tipoCantidadHor
     */
    public function setTipoCantidadHor($tipoCantidadHor)
    {
        $this->tipoCantidadHor = $tipoCantidadHor;
    }

    /**
     * Get tipoCantidadHor
     *
     * @return bigint 
     */
    public function getTipoCantidadHor()
    {
        return $this->tipoCantidadHor;
    }

    /**
     * Set tipoHorTurno
     *
     * @param bigint $tipoHorTurno
     */
    public function setTipoHorTurno($tipoHorTurno)
    {
        $this->tipoHorTurno = $tipoHorTurno;
    }

    /**
     * Get tipoHorTurno
     *
     * @return bigint 
     */
    public function getTipoHorTurno()
    {
        return $this->tipoHorTurno;
    }

    /**
     * Add resProTip
     *
     * @param MinSal\SidPla\RRMedicoBundle\Entity\ResulPrograRRMed $resProTip
     */
    public function addResProTip(\MinSal\SidPla\RRMedicoBundle\Entity\ResulPrograRRMed $resProTip)
    {
        $this->resProTip[] = $resProTip;
    }

    /**
     * Get resProTip
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getResProTip()
    {
        return $this->resProTip;
    }
}