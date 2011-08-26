<?php

namespace MinSal\SidPla\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\AdminBundle\Entity\DepartamentoPais
 *
 * @ORM\Table(name="sidpla_departamento")
 * @ORM\Entity
 */
class DepartamentoPais
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="depa_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idDepto;
   

    /**
     * @var string $nombreDepto
     *
     * @ORM\Column(name="depa_nombre", type="string", length=150)
     */
    private $nombreDepto;
  

    /**
     * Set idDepto
     *
     * @param integer $idDepto
     */
    public function setIdDepto($idDepto)
    {
        $this->idDepto = $idDepto;
    }

    /**
     * Get idDepto
     *
     * @return integer 
     */
    public function getIdDepto()
    {
        return $this->idDepto;
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