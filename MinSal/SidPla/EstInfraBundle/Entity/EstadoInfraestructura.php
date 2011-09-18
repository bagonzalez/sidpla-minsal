<?php

namespace MinSal\SidPla\EstInfraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\EstInfraBundle\Entity\EstadoInfraestructura
 *
 * @ORM\Table(name="sidpla_estadoinfraestructura")
 * @ORM\Entity
 */
class EstadoInfraestructura
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="estinf_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $NomEstado
     *
     * @ORM\Column(name="estinf_nombre", type="string", length=25)
     */
    private $NomEstado;

    /**
     * @var string $estadoDescrip
     *
     * @ORM\Column(name="estinf_descripcion", type="string", length=100)
     */
    private $estadoDescrip;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    
    /**
     * Set NomEstado
     *
     * @param string $nomEstado
     */
    public function setNomEstado($nomEstado)
    {
        $this->NomEstado = $nomEstado;
    }

    /**
     * Get NomEstado
     *
     * @return string 
     */
    public function getNomEstado()
    {
        return $this->NomEstado;
    }

    /**
     * Set estadoDescrip
     *
     * @param string $estadoDescrip
     */
    public function setEstadoDescrip($estadoDescrip)
    {
        $this->estadoDescrip = $estadoDescrip;
    }

    /**
     * Get estadoDescrip
     *
     * @return string 
     */
    public function getEstadoDescrip()
    {
        return $this->estadoDescrip;
    }
}