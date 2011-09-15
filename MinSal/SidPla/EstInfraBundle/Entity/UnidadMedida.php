<?php

namespace MinSal\SidPla\EstInfraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\EstInfraBundle\Entity\UnidadMedida
 *
 * @ORM\Table(name="sidpla_unidadmedida")
 * @ORM\Entity
 */
class UnidadMedida
{
    /**
     * @var integer $idUnidMed
     *
     * @ORM\Column(name="unimed_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
  
    private $idUnidMed;

    /**
     * @var string $nomUnidMed
     *
     * @ORM\Column(name="unimed_nombre", type="string", length=50)
     */
    private $nomUnidMed;

    /**
     * @var string $descripUnidMed
     *
     * @ORM\Column(name="unimed_descripcion", type="string", length=250)
     */
    private $descripUnidMed;

    /**
     * @var string $tipoUnidMed
     *
     * @ORM\Column(name="unimed_tipo", type="string", length=10)
     */
    private $tipoUnidMed;


    /**
     * Get idUnidMed
     *
     * @return integer 
     */
    public function getIdUnidMed()
    {
        return $this->idUnidMed;
    }

    /**
     * Set nomUnidMed
     *
     * @param string $nomUnidMed
     */
    public function setNomUnidMed($nomUnidMed)
    {
        $this->nomUnidMed = $nomUnidMed;
    }

    /**
     * Get nomUnidMed
     *
     * @return string 
     */
    public function getNomUnidMed()
    {
        return $this->nomUnidMed;
    }

    /**
     * Set descripUnidMed
     *
     * @param string $descripUnidMed
     */
    public function setDescripUnidMed($descripUnidMed)
    {
        $this->descripUnidMed = $descripUnidMed;
    }

    /**
     * Get descripUnidMed
     *
     * @return string 
     */
    public function getDescripUnidMed()
    {
        return $this->descripUnidMed;
    }

    /**
     * Set tipoUnidMed
     *
     * @param string $tipoUnidMed
     */
    public function setTipoUnidMed($tipoUnidMed)
    {
        $this->tipoUnidMed = $tipoUnidMed;
    }

    /**
     * Get tipoUnidMed
     *
     * @return string 
     */
    public function getTipoUnidMed()
    {
        return $this->tipoUnidMed;
    }
}