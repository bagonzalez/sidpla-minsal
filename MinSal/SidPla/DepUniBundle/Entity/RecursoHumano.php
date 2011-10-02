<?php

namespace MinSal\SidPla\DepUniBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\DepUniBundle\Entity\RecursoHumano
 *
 * @ORM\Table(name="sidpla_recursohumano")
 * @ORM\Entity
 */
class RecursoHumano
{
    /**
     * @var integer $codigoRRHH
     *
     * @ORM\Column(name="rechum_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoRRHH;

    /**
     * @var integer $cantidad
     *
     * @ORM\Column(name="rechum_cantidad", type="integer")
     */
    private $cantidad;

    /**
     * @var string $Descripcion
     *
     * @ORM\Column(name="rechum_descripcion", type="string", length=300)
     */
    private $descripcion;


    /**
     * Get codigoRRHH
     *
     * @return integer 
     */
    public function getcodigoRRHH()
    {
        return $this->codigoRRHH;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     */
    public function setcantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getcantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     */
    public function setdescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getdescripcion()
    {
        return $this->descripcion;
    }
}