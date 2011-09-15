<?php

namespace MinSal\SidPla\EstInfraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\EstInfraBundle\Entity\ElementoInfraestructura
 * 
 * @ORM\Table("sidpla_elementoinfraestructura")
 * @ORM\Entity
 */
class ElementoInfraestructura
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="eleminf_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $nomElemInfra
     *
     * @ORM\Column(name="eleminf_nombre", type="string", length=150)
     */
    private $nomElemInfra;

    /**
     * @var string $elemInfraDescrip
     *
     * @ORM\Column(name="eleminf_descripcion", type="string", length=250)
     */
    private $elemInfraDescrip;

     /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\EstInfraBundle\Entity\UnidadMedida", inversedBy="unidadmedida")
     * @ORM\JoinColumn(name="unimed_codigo", referencedColumnName="unimed_codigo")
     */
    private $codUnidadMed;


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
     * Set nomElemInfra
     *
     * @param string $nomElemInfra
     */
    public function setNomElemInfra($nomElemInfra)
    {
        $this->nomElemInfra = $nomElemInfra;
    }

    /**
     * Get nomElemInfra
     *
     * @return string 
     */
    public function getNomElemInfra()
    {
        return $this->nomElemInfra;
    }

    /**
     * Set elemInfraDescrip
     *
     * @param string $elemInfraDescrip
     */
    public function setElemInfraDescrip($elemInfraDescrip)
    {
        $this->elemInfraDescrip = $elemInfraDescrip;
    }

    /**
     * Get elemInfraDescrip
     *
     * @return string 
     */
    public function getElemInfraDescrip()
    {
        return $this->elemInfraDescrip;
    }

    /**
     * Set codUnidadMed
     *
     * @param MinSal\SidPla\EstInfraBundle\Entity\UnidadMedida $codUnidadMed
     */
    public function setCodUnidadMed(MinSal\SidPla\EstInfraBundle\Entity\UnidadMedida $codUnidadMed)
    {
        $this->codUnidadMed = $codUnidadMed;
    }

    /**
     * Get codUnidadMed
     *
     * @return MinSal\SidPla\EstInfraBundle\Entity\UnidadMedida
     */
    public function getCodUnidadMed()
    {
        return $this->codUnidadMed;
    }
}