<?php

namespace MinSal\SidPla\DepUniBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\DepUniBundle\Entity\TipoRRHumano
 *
 * @ORM\Table(name="sidpla_tiporecursohumano")
 * @ORM\Entity
 */
class TipoRRHumano
{
    /**
     * @var integer $codTipoRRHH
     *
     * @ORM\Column(name="tiprechum_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codTipoRRHH;

    /**
     * @var string $DescripRRHH
     *
     * @ORM\Column(name="tiprechum_descripcion", type="string", length=60)
     */
    private $DescripRRHH;


    /**
     * Get codTipoRRHH
     *
     * @return integer 
     */
    public function getcodTipoRRHH()
    {
        return $this->codTipoRRHH;
    }

    /**
     * Set DescripRRHH
     *
     * @param string $descripRRHH
     */
    public function setDescripRRHH($descripRRHH)
    {
        $this->DescripRRHH = $descripRRHH;
    }

    /**
     * Get DescripRRHH
     *
     * @return string 
     */
    public function getDescripRRHH()
    {
        return $this->DescripRRHH;
    }
}