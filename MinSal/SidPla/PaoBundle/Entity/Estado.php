<?php

namespace MinSal\SidPla\PaoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\PaoBundle\Entity\Estado
 *
 * @ORM\Table(name="sidpla_estado")
 * @ORM\Entity
 */

class Estado
{
    /**
     * @var integer $idEst
     *
     * @ORM\Column(name="estado_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idEst;

    /**
     * @var string $nombreEst
     *
     * @ORM\Column(name="estado_nombre", type="string", length=50)
     */
    private $nombreEst;

    /**
     * @var boolean $activoEst
     *
     * @ORM\Column(name="estado_activo", type="boolean")
     */
    private $activoEst;

    /**
     * @var string $siguienteEst
     *
     * @ORM\Column(name="estado_siguienteest", type="string", length=15)
     */
    private $siguienteEst;

    /**
     * Get idEst
     *
     * @return integer 
     */
    public function getIdEst()
    {
        return $this->idEst;
    }

    /**
     * Set nombreEst
     *
     * @param string $nombreEst
     */
    public function setNombreEst($nombreEst)
    {
        $this->nombreEst = $nombreEst;
    }

    /**
     * Get nombreEst
     *
     * @return string 
     */
    public function getNombreEst()
    {
        return $this->nombreEst;
    }

    /**
     * Set activoEst
     *
     * @param boolean $activoEst
     */
    public function setActivoEst($activoEst)
    {
        $this->activoEst = $activoEst;
    }

    /**
     * Get activoEst
     *
     * @return boolean 
     */
    public function getActivoEst()
    {
        return $this->activoEst;
    }

    /**
     * Set siguienteEst
     *
     * @param string $siguienteEst
     */
    public function setSiguienteEst($siguienteEst)
    {
        $this->siguienteEst = $siguienteEst;
    }

    /**
     * Get siguienteEst
     *
     * @return string 
     */
    public function getSiguienteEst()
    {
        return $this->siguienteEst;
    }
}
