<?php

namespace MinSal\SidPla\PaoBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\PaoBundle\Entity\Justificacion
 *
 * @ORM\Table(name="sidpla_justificacion")
 * @ORM\Entity
 */
class Justificacion {
    
/**
 * @var integer $idJustificacion
 *
 * @ORM\Column(name="justificacion_codigo", type="integer")
 * @ORM\Id
 * @ORM\GeneratedValue(strategy="AUTO")
 */
private $idJustificacion;

/**
 * @var text $justificacion_descripcion
 *
 * @ORM\Column(name="justificacion_descripcion", type="text")
 */
private $justificacion_descripcion;

/**
 * @var integer $pao_codigo
 *
 * @ORM\Column(name="pao_codigo", type="integer")
 */
private $pao_codigo;

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
 * Set justificacion_descripcion
 *
 * @param text $justificacion_descripcion
 */
public function setJustificacion_descripcion($justificacion_descripcion)
    {
        $this->justificacion_descripcion = $justificacion_descripcion;
    }

/**
 * Get justificacion_descripcion
 *
 * @return text 
 */
public function getJustificacion_descripcion()
    {
        return $this->justificacion_descripcion;
    }

/**
 * Set pao_codigo
 *
 * @param integer $pao_codigo
 */
 public function setPao_codigo($pao_codigo)
    {
        $this->pao_codigo = $pao_codigo;
    }

/**
 * Get pao_codigo
 *
 * @return integer
 */
 public function getPao_codigo()
    {
        return $this->pao_codigo;
    }
}