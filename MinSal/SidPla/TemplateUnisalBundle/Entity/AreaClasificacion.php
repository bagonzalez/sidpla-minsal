<?php

namespace MinSal\SidPla\TemplateUnisalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\TemplateUnisalBundle\Entity\AreaClasificacion
 *
 * @ORM\Table(name="sidpla_areaclasificacion")
 * @ORM\Entity
 */
class AreaClasificacion {

    /**
     * @var integer $codArea
     *
     * @ORM\Column(name="arecla_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codArea;

    /**
     * @var string $nombreArea
     *
     * @ORM\Column(name="arecla_nombre", type="string", length=50)
     */
    private $nombreArea;

    /**
     * @ORM\OneToMany(targetEntity="ObjetivoEspeUnisal", mappedBy="areaClaObj")
     */
    private $objetivosObjeArea;

    public function __construct()
    {
        $this->objetivosObjeArea = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get codArea
     *
     * @return integer 
     */
    public function getCodArea()
    {
        return $this->codArea;
    }

    /**
     * Set nombreArea
     *
     * @param string $nombreArea
     */
    public function setNombreArea($nombreArea)
    {
        $this->nombreArea = $nombreArea;
    }

    /**
     * Get nombreArea
     *
     * @return string 
     */
    public function getNombreArea()
    {
        return $this->nombreArea;
    }

    /**
     * Add objetivosObjeArea
     *
     * @param MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal $objetivosObjeArea
     */
    public function addObjetivosObjeArea(\MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal $objetivosObjeArea)
    {
        $this->objetivosObjeArea[] = $objetivosObjeArea;
    }

    /**
     * Get objetivosObjeArea
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getObjetivosObjeArea()
    {
        return $this->objetivosObjeArea;
    }
}