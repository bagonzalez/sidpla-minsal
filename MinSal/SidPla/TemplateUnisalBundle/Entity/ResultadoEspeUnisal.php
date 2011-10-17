<?php

namespace MinSal\SidPla\TemplateUnisalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\TemplateUnisalBundle\Entity\ResultadoEspeUnisal
 *
 * @ORM\Table(name="sidpla_resultadoespeunisal")
 * @ORM\Entity
 */
class ResultadoEspeUnisal {

    /**
     * @var integer $codResEspUni
     *
     * @ORM\Column(name="resulespuni_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codResEspUni;

    /**
     * @var string $descResEspUni
     *
     * @ORM\Column(name="resulespuni_descripcion", type="string", length=300)
     */
    private $descResEspUni;

    /**
     * @var string $nomenResEspUni
     *
     * @ORM\Column(name="resulespuni_nomenclatura", type="string", length=15)
     */
    private $nomenResEspUni;

    /**
     * @ORM\ManyToOne(targetEntity="ObjetivoEspeUnisal", inversedBy="resultEspObjT")
     * @ORM\JoinColumn(name="objespuni_codigo", referencedColumnName="objespuni_codigo")
     */
    private $objEspRET;

    /**
     * @ORM\OneToMany(targetEntity="ActividadUnisalTemplate", mappedBy="resulEspeTemAct")
     */
    private $actividadesTemplate;

    public function __construct()
    {
        $this->actividadesTemplate = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get codResEspUni
     *
     * @return integer 
     */
    public function getCodResEspUni()
    {
        return $this->codResEspUni;
    }

    /**
     * Set descResEspUni
     *
     * @param string $descResEspUni
     */
    public function setDescResEspUni($descResEspUni)
    {
        $this->descResEspUni = $descResEspUni;
    }

    /**
     * Get descResEspUni
     *
     * @return string 
     */
    public function getDescResEspUni()
    {
        return $this->descResEspUni;
    }

    /**
     * Set nomenResEspUni
     *
     * @param string $nomenResEspUni
     */
    public function setNomenResEspUni($nomenResEspUni)
    {
        $this->nomenResEspUni = $nomenResEspUni;
    }

    /**
     * Get nomenResEspUni
     *
     * @return string 
     */
    public function getNomenResEspUni()
    {
        return $this->nomenResEspUni;
    }

    /**
     * Set objEspRET
     *
     * @param MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal $objEspRET
     */
    public function setObjEspRET(\MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal $objEspRET)
    {
        $this->objEspRET = $objEspRET;
    }

    /**
     * Get objEspRET
     *
     * @return MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal 
     */
    public function getObjEspRET()
    {
        return $this->objEspRET;
    }

    /**
     * Add actividadesTemplate
     *
     * @param MinSal\SidPla\TemplateUnisalBundle\Entity\ActividadUnisalTemplate $actividadesTemplate
     */
    public function addActividadesTemplate(\MinSal\SidPla\TemplateUnisalBundle\Entity\ActividadUnisalTemplate $actividadesTemplate)
    {
        $this->actividadesTemplate[] = $actividadesTemplate;
    }

    /**
     * Get actividadesTemplate
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getActividadesTemplate()
    {
        return $this->actividadesTemplate;
    }
}