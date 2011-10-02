<?php

namespace MinSal\SidPla\DepUniBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\DepUniBundle\Entity\RecursoHumano
 *
 * @ORM\Table(name="sidpla_recursohumano")
 * @ORM\Entity
 */
class RecursoHumano {

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
     * @ORM\ManyToOne(targetEntity="DepartamentoUni", inversedBy="rrHHs")
     * @ORM\JoinColumn(name="depuni_codigo", referencedColumnName="depuni_codigo")
     */
    private $deptoUnidadRRHH;
    
    /**
     * @ORM\ManyToOne(targetEntity="TipoRRHumano", inversedBy="rrHHTipoHum")
     * @ORM\JoinColumn(name="tiprechum_codigo", referencedColumnName="tiprechum_codigo")
     */
    private $tipoRRHH;

    /**
     * Get codigoRRHH
     *
     * @return integer 
     */
    public function getCodigoRRHH()
    {
        return $this->codigoRRHH;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set deptoUnidadRRHH
     *
     * @param MinSal\SidPla\DepUniBundle\Entity\DepartamentoUni $deptoUnidadRRHH
     */
    public function setDeptoUnidadRRHH(\MinSal\SidPla\DepUniBundle\Entity\DepartamentoUni $deptoUnidadRRHH)
    {
        $this->deptoUnidadRRHH = $deptoUnidadRRHH;
    }

    /**
     * Get deptoUnidadRRHH
     *
     * @return MinSal\SidPla\DepUniBundle\Entity\DepartamentoUni 
     */
    public function getDeptoUnidadRRHH()
    {
        return $this->deptoUnidadRRHH;
    }

    /**
     * Set tipoRRHH
     *
     * @param MinSal\SidPla\DepUniBundle\Entity\TipoRRHumano $tipoRRHH
     */
    public function setTipoRRHH(\MinSal\SidPla\DepUniBundle\Entity\TipoRRHumano $tipoRRHH)
    {
        $this->tipoRRHH = $tipoRRHH;
    }

    /**
     * Get tipoRRHH
     *
     * @return MinSal\SidPla\DepUniBundle\Entity\TipoRRHumano 
     */
    public function getTipoRRHH()
    {
        return $this->tipoRRHH;
    }
}