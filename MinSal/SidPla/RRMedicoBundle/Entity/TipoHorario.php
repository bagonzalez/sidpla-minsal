<?php

namespace MinSal\SidPla\RRMedicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\RRMedicoBundle\Entity\TipoHorario
 *
 * @ORM\Table(name="sidpla_tipohorario")
 * @ORM\Entity
 */
class TipoHorario
{
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
     * @var integer $tipoCantidadHor
     *
     * @ORM\Column(name="tiphor_cantidadhoras", type="integer")
     */
    private $tipoCantidadHor;

    /**
     * @var string $tipoHorTurno
     *
     * @ORM\Column(name="tiphor_turno", type="string", length=10)
     */
    private $tipoHorTurno;


    /**
     * Get codTipoHor
     *
     * @return integer 
     */
    public function getcodTipoHor(){
        return $this->codTipoHor;
    }

    /**
     * Set tipoHorDes
     *
     * @param string $tipoHorDes
     */
    public function setTipoHorDes($tipoHorDes){
        $this->tipoHorDes = $tipoHorDes;
    }

    /**
     * Get tipoHorDes
     *
     * @return string 
     */
    public function getTipoHorDes(){
        return $this->tipoHorDes;
    }

    /**
     * Set tipoCantidadHor
     *
     * @param integer $tipoCantidadHor
     */
    public function setTipoCantidadHor($tipoCantidadHor){
        $this->tipoCantidadHor = $tipoCantidadHor;
    }

    /**
     * Get tipoCantidadHor
     *
     * @return integer 
     */
    public function getTipoCantidadHor(){
        return $this->tipoCantidadHor;
    }

    /**
     * Set tipoHorTurno
     *
     * @param string $tipoHorTurno
     */
    public function setTipoHorTurno($tipoHorTurno){
        $this->tipoHorTurno = $tipoHorTurno;
    }

    /**
     * Get tipoHorTurno
     *
     * @return string 
     */
    public function getTipoHorTurno(){
        return $this->tipoHorTurno;
    }
}