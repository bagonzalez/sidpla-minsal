<?php

namespace MinSal\SidPla\DepUniBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\DepUniBundle\Entity\DepartamentoUni
 *
 * @ORM\Table(name="sidpla_departamentounidad")
 * @ORM\Entity
 */
class DepartamentoUni
{
    /**
     * @var integer $codDeptoUnidad
     *
     * @ORM\Column(name="depuni_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codDeptoUnidad;

    /**
     * @var string $nombreDepto
     *
     * @ORM\Column(name="depuni_nombre", type="string", length=100)
     */
    private $nombreDepto;


    /**
     * Get codDeptoUnidad
     *
     * @return integer 
     */
    public function getcodDeptoUnidad()
    {
        return $this->codDeptoUnidad;
    }

    /**
     * Set nombreDepto
     *
     * @param string $nombreDepto
     */
    public function setNombreDepto($nombreDepto)
    {
        $this->nombreDepto = $nombreDepto;
    }

    /**
     * Get nombreDepto
     *
     * @return string 
     */
    public function getNombreDepto()
    {
        return $this->nombreDepto;
    }
}