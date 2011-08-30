<?php

namespace MinSal\SidPla\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\AdminBundle\Entity\NotificacionSistema
 *
 * @ORM\Table(name="sidpla_notificacionsistema"))
 * @ORM\Entity
 */
class NotificacionSistema
{
    /**
     * @var integer $codNoti
     *
     * @ORM\Column(name="notifmensa_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codNoti;

   
    /**
     * @var string $nombreNoti
     *
     * @ORM\Column(name="notifmensa_nombre", type="string", length=100)
     */
    private $nombreNoti;

    /**
     * @var string $TipoMensajeNoti
     *
     * @ORM\Column(name="notifmensa_tipoMensaje", type="string", length=25)
     */
    private $TipoMensajeNoti;

    /**
     * @var string $MensajeNoti
     *
     * @ORM\Column(name="notifmensa_mensaje", type="string", length=100)
     */
    private $MensajeNoti;


     /**
     * Get codNoti
     *
     * @return integer 
     */
    public function getCodNoti()
    {
        return $this->codNoti;
    }

    /**
     * Set nombreNoti
     *
     * @param string $nombreNoti
     */
    public function setNombreNoti($nombreNoti)
    {
        $this->nombreNoti = $nombreNoti;
    }

    /**
     * Get nombreNoti
     *
     * @return string 
     */
    public function getNombreNoti()
    {
        return $this->nombreNoti;
    }

    /**
     * Set TipoMensajeNoti
     *
     * @param string $tipoMensajeNoti
     */
    public function setTipoMensajeNoti($tipoMensajeNoti)
    {
        $this->TipoMensajeNoti = $tipoMensajeNoti;
    }

    /**
     * Get TipoMensajeNoti
     *
     * @return string 
     */
    public function getTipoMensajeNoti()
    {
        return $this->TipoMensajeNoti;
    }

    /**
     * Set MensajeNoti
     *
     * @param string $mensajeNoti
     */
    public function setMensajeNoti($mensajeNoti)
    {
        $this->MensajeNoti = $mensajeNoti;
    }

    /**
     * Get MensajeNoti
     *
     * @return string 
     */
    public function getMensajeNoti()
    {
        return $this->MensajeNoti;
    }
}