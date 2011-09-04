<?php

namespace MinSal\SidPla\PaoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\PaoBundle\Entity\Justificacion
 *
 * @ORM\Table(name="sidpla_justificacion")
 * @ORM\Entity
 */
class Justificacion
{
    /**
     * @var integer $idJustificacion
     *
     * @ORM\Column(name="idJustificacion", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idJustificacion;

    /**
     * @var Text $justificacion_descripcion
     *
     * @ORM\Column(name="justificacion_descripcion", type="Text")
     */
    private $justificacion_descripcion;

    /**
     * @var Integer $pao_codigo
     *
     * @ORM\Column(name="pao_codigo", type="Integer")
     */
    protected $pao_codigo;


    /**
     * Get idJustificacion
     *
     * @return integer 
     */
    public function getIdJustificacion()
    {
        return $this->idJustificacion;
    }

    /**
     * Set idJustificacion
     *
     * @param Integer idJustificacion
     */
    public function setIdJustificacion(\Integer $idJustificacion)
    {
        $this->idJustificacion = $idJustificacion;
    }

    /**
     * Set justificacion_descripcion
     *
     * @param Text $justificacion_descripcion
     */
    public function setJustificacion_descripcion(\Text $justificacion_descripcion)
    {
        $this->justificacion_descripcion = $justificacion_descripcion;
    }

    /**
     * Get justificacion_descripcion
     *
     * @return Text 
     */
    public function getJustificacion_descripcion()
    {
        return $this->justificacion_descripcion;
    }

    /**
     * Set pao_codigo
     *
     * @param MinSal\SidPla\PaoBundle\Entity\Pao $pao_codigo
     */
    public function setPao_codigo(\MinSal\SidPla\AdminBundle\Entity\Pao $pao_codigo)
    {
        $this->pao_codigo = $pao_codigo;
    }

    /**
     * Get $pao_codigo
     *
     * @return MinSal\SidPla\AdminBundle\Entity\Pao 
     */
    public function getPao_codigo()
    {
        return $this->pao_codigo;
    }
}