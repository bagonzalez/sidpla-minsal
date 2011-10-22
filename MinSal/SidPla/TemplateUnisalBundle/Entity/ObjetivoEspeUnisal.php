<?php

namespace MinSal\SidPla\TemplateUnisalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal
 *
 * @ORM\Table(name="sidpla_objetivoespeunisal")
 * @ORM\Entity
 */
class ObjetivoEspeUnisal {

    /**
     * @var integer $codObjEspUni
     *
     * @ORM\Column(name="objespuni_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codObjEspUni;

    /**
     * @var string $descObjEspUni
     *
     * @ORM\Column(name="objespuni_descripcion", type="string", length=300)
     */
    private $descObjEspUni;

    /**
     * @var string $nomenObjEspUni
     *
     * @ORM\Column(name="objespuni_nomenclatura", type="string", length=15)
     */
    private $nomenObjEspUni;

    /**
     * @ORM\ManyToOne(targetEntity="ProUnisalTemplate", inversedBy="objeEspeProgra")
     * @ORM\JoinColumn(name="prounitem_codigo", referencedColumnName="prounitem_codigo")
     */
    private $prograMonObj;

    /**
     * @ORM\ManyToOne(targetEntity="AreaClasificacion", inversedBy="objetivosObjeArea")
     * @ORM\JoinColumn(name="arecla_codigo", referencedColumnName="arecla_codigo")
     */
    private $areaClaObj;

    /**
     * @ORM\OneToMany(targetEntity="ResultadoEspeUnisal", mappedBy="objEspRET")
     */
    private $resultEspObjT;

    /**
     * @ORM\OneToMany(targetEntity="MinSal\SidPla\IndicadoresTemplateBundle\Entity\IndicadorSalud", mappedBy="objEspUnisal")
     */
    private $indicadoresSalud;

    public function __construct() {
        $this->resultEspObjT = new \Doctrine\Common\Collections\ArrayCollection();
        $this->indicadoresSalud = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get codObjEspUni
     *
     * @return integer 
     */
    public function getCodObjEspUni() {
        return $this->codObjEspUni;
    }

    /**
     * Set descObjEspUni
     *
     * @param string $descObjEspUni
     */
    public function setDescObjEspUni($descObjEspUni) {
        $this->descObjEspUni = $descObjEspUni;
    }

    /**
     * Get descObjEspUni
     *
     * @return string 
     */
    public function getDescObjEspUni() {
        return $this->descObjEspUni;
    }

    /**
     * Set nomenObjEspUni
     *
     * @param string $nomenObjEspUni
     */
    public function setNomenObjEspUni($nomenObjEspUni) {
        $this->nomenObjEspUni = $nomenObjEspUni;
    }

    /**
     * Get nomenObjEspUni
     *
     * @return string 
     */
    public function getNomenObjEspUni() {
        return $this->nomenObjEspUni;
    }

    /**
     * Set prograMonObj
     *
     * @param MinSal\SidPla\TemplateUnisalBundle\Entity\ProUnisalTemplate $prograMonObj
     */
    public function setPrograMonObj(\MinSal\SidPla\TemplateUnisalBundle\Entity\ProUnisalTemplate $prograMonObj) {
        $this->prograMonObj = $prograMonObj;
    }

    /**
     * Get prograMonObj
     *
     * @return MinSal\SidPla\TemplateUnisalBundle\Entity\ProUnisalTemplate 
     */
    public function getPrograMonObj() {
        return $this->prograMonObj;
    }

    /**
     * Set areaClaObj
     *
     * @param MinSal\SidPla\TemplateUnisalBundle\Entity\AreaClasificacion $areaClaObj
     */
    public function setAreaClaObj(\MinSal\SidPla\TemplateUnisalBundle\Entity\AreaClasificacion $areaClaObj) {
        $this->areaClaObj = $areaClaObj;
    }

    /**
     * Get areaClaObj
     *
     * @return MinSal\SidPla\TemplateUnisalBundle\Entity\AreaClasificacion 
     */
    public function getAreaClaObj() {
        return $this->areaClaObj;
    }

    /**
     * Add resultEspObjT
     *
     * @param MinSal\SidPla\TemplateUnisalBundle\Entity\ResultadoEspeUnisal $resultEspObjT
     */
    public function addResultEspObjT(\MinSal\SidPla\TemplateUnisalBundle\Entity\ResultadoEspeUnisal $resultEspObjT) {
        $this->resultEspObjT[] = $resultEspObjT;
    }

    /**
     * Get resultEspObjT
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getResultEspObjT() {
        return $this->resultEspObjT;
    }

    /**
     * Add indicadoresSalud
     *
     * @param MinSal\SidPla\IndicadoresTemplateBundle\Entity\IndicadorSalud $indicadoresSalud
     */
    public function addIndicadoresSalud(\MinSal\SidPla\IndicadoresTemplateBundle\Entity\IndicadorSalud $indicadoresSalud) {
        $this->indicadoresSalud[] = $indicadoresSalud;
    }

    /**
     * Get indicadoresSalud
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getIndicadoresSalud() {
        return $this->indicadoresSalud;
    }

}