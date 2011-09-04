<?php

namespace MinSal\SidPla\PaoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\PaoBundle\Entity\TipoPeriodo
 *
 * @ORM\Table(name="sidpla_tipoperiodo")
 * @ORM\Entity
 */
class TipoPeriodo
{

     /**
     * @var integer $idTipPer
     *
     * @ORM\Column(name="tipoperiodo_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idTipPer;

    /**
     * @var string $descTipPer
     *
     * @ORM\Column(name="tipoperiodo_descripcion", type="string", length=200)
     */
    private $descTipPer;

    /**
     * @var string $nomTipPer
     *
     * @ORM\Column(name="tipoperiodo_nombre", type="string", length=30)
     */
    private $nomTipPer;

    /**
     * @var boolean $UsuarioTipPer
     *
     * @ORM\Column(name="tipoperiodo_usuario", type="boolean")
     */
    private $UsuarioTipPer;

    /**
     * @var boolean $activoTipPer
     *
     * @ORM\Column(name="tipoperiodo_activo", type="boolean")
     */
    private $activoTipPer;


    /**
     * Get idTipPer
     *
     * @return integer 
     */
    public function getIdTipPer()
    {
        return $this->idTipPer;
    }

    /**
     * Set descTipPer
     *
     * @param string $descTipPer
     */
    public function setDescTipPer($descTipPer)
    {
        $this->descTipPer = $descTipPer;
    }

    /**
     * Get descTipPer
     *
     * @return string 
     */
    public function getDescTipPer()
    {
        return $this->descTipPer;
    }

    /**
     * Set nomTipPer
     *
     * @param string $nomTipPer
     */
    public function setNomTipPer($nomTipPer)
    {
        $this->nomTipPer = $nomTipPer;
    }

    /**
     * Get nomTipPer
     *
     * @return string 
     */
    public function getNomTipPer()
    {
        return $this->nomTipPer;
    }

    /**
     * Set UsuarioTipPer
     *
     * @param boolean $usuarioTipPer
     */
    public function setUsuarioTipPer($usuarioTipPer)
    {
        $this->UsuarioTipPer = $usuarioTipPer;
    }

    /**
     * Get UsuarioTipPer
     *
     * @return boolean 
     */
    public function getUsuarioTipPer()
    {
        return $this->UsuarioTipPer;
    }

    /**
     * Set activoTipPer
     *
     * @param boolean $activoTipPer
     */
    public function setActivoTipPer($activoTipPer)
    {
        $this->activoTipPer = $activoTipPer;
    }

    /**
     * Get activoTipPer
     *
     * @return boolean 
     */
    public function getActivoTipPer()
    {
        return $this->activoTipPer;
    }
}
