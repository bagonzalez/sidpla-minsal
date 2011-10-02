<?php

namespace MinSal\SidPla\DepUniBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\DepUniBundle\Entity\TipoRRHumano
 *
 * @ORM\Table(name="sidpla_tiporecursohumano")
 * @ORM\Entity
 */
class TipoRRHumano {

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
     * @ORM\OneToMany(targetEntity="RecursoHumano", mappedBy="tipoRRHH")
     */
    private $rrHHTipoHum;



    public function __construct()
    {
        $this->rrHHTipoHum = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get codTipoRRHH
     *
     * @return integer 
     */
    public function getCodTipoRRHH()
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

    /**
     * Add rrHHTipoHum
     *
     * @param MinSal\SidPla\DepUniBundle\Entity\RecursoHumano $rrHHTipoHum
     */
    public function addRrHHTipoHum(\MinSal\SidPla\DepUniBundle\Entity\RecursoHumano $rrHHTipoHum)
    {
        $this->rrHHTipoHum[] = $rrHHTipoHum;
    }

    /**
     * Get rrHHTipoHum
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRrHHTipoHum()
    {
        return $this->rrHHTipoHum;
    }
}