<?php

namespace MinSal\SidPla\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\AdminBundle\Entity\OpcionSistema 
 * 
 * @ORM\Entity
 * @ORM\Table(name="sidpla_opcionsistema")
 */
class OpcionSistema
{
    /**
     * @var integer $idOpcionSistema
     *
     * @ORM\Column(name="opcionsistema_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */ 

    private $idOpcionSistema;

    /**
     * @var string $nombreOpcion
     *
     * @ORM\Column(name="opcionsistema_nombre", type="string", length=15)
     */
    private $nombreOpcion;

    /**
     * @var string $descripcionOpcion
     *
     * @ORM\Column(name="opcionsistema_descripcion", type="string", length=15)
     */
    private $descripcionOpcion;

    /**
     * @var string $enlace
     *
     * @ORM\Column(name="opcionsistema_enlace", type="string", length=150)
     */
    private $enlace;

    /**
     * @var integer $idOpcionSistema2
     *
     * @ORM\Column(name="opcionsistema_codigo2", type="integer")
     */
    private $idOpcionSistema2;

    /**
     * @var integer $idRol
     *
     * @ORM\Column(name="rol_codigo", type="integer")
     */
    private $idRol;


    /**
     * Get idOpcionSistema
     *
     * @return integer 
     */
    public function getIdOpcionSistema()
    {
        return $this->idOpcionSistema;
    }

    /**
     * Set nombreOpcion
     *
     * @param string $nombreOpcion
     */
    public function setNombreOpcion($nombreOpcion)
    {
        $this->nombreOpcion = $nombreOpcion;
    }

    /**
     * Get nombreOpcion
     *
     * @return string 
     */
    public function getNombreOpcion()
    {
        return $this->nombreOpcion;
    }

    /**
     * Set descripcionOpcion
     *
     * @param string $descripcionOpcion
     */
    public function setDescripcionOpcion($descripcionOpcion)
    {
        $this->descripcionOpcion = $descripcionOpcion;
    }

    /**
     * Get descripcionOpcion
     *
     * @return string 
     */
    public function getDescripcionOpcion()
    {
        return $this->descripcionOpcion;
    }

    /**
     * Set enlace
     *
     * @param string $enlace
     */
    public function setEnlace($enlace)
    {
        $this->enlace = $enlace;
    }

    /**
     * Get enlace
     *
     * @return string 
     */
    public function getEnlace()
    {
        return $this->enlace;
    }

    /**
     * Set idOpcionSistema2
     *
     * @param integer $idOpcionSistema2
     */
    public function setIdOpcionSistema2(\integer $idOpcionSistema2)
    {
        $this->idOpcionSistema2 = $idOpcionSistema2;
    }

    /**
     * Get idOpcionSistema2
     *
     * @return integer 
     */
    public function getIdOpcionSistema2()
    {
        return $this->idOpcionSistema2;
    }

    /**
     * Set idRol
     *
     * @param integer $idRol
     */
    public function setIdRol(\integer $idRol)
    {
        $this->idRol = $idRol;
    }

    /**
     * Get idRol
     *
     * @return integer 
     */
    public function getIdRol()
    {
        return $this->idRol;
    }
}