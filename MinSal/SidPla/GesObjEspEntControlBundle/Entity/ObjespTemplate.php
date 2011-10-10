<?php

namespace MinSal\SidPla\GesObjEspEntControlBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjespTemplate
 *
 * @ORM\Table(name="sidpla_objespectemplate")
 * @ORM\Entity
 */
class ObjespTemplate {

    /**
     * @var integer $idObjEspTempl
     *
     * @ORM\Column(name="objespectmp_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idObjEspTempl;

    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico", inversedBy="objetivostemplate", cascade={"remove"})
     * @ORM\JoinColumn(name="objesp_codigo", referencedColumnName="objesp_codigo")
     */
    private $idObjEspec;

    /**
     * @ORM\ManyToOne(targetEntity="ObjTemplate", inversedBy="especificoObjTmp",cascade={"remove"})
     * @ORM\JoinColumn(name="objtmp_codigo", referencedColumnName="objtmp_codigo")
     */
    private $objTmpEspe;

    /**
     * @ORM\OneToMany(targetEntity="ResEspTemplate", mappedBy="idObjEspecTempl",   cascade={"persist", "remove"})
     */
    protected $resultadostemplate;

    /**
     * Set idObjEspTempl
     *
     * @param integer $idObjEspTempl
     */
    public function setIdObjEspTempl($idObjEspTempl) {
        $this->idObjEspTempl = $idObjEspTempl;
    }

    /**
     * Get idObjEspTempl
     *
     * @return integer 
     */
    public function getIdObjEspTempl() {
        return $this->idObjEspTempl;
    }

    /**
     * Set idObjEspec
     *
     * @param MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico $idObjEspec
     */
    public function setIdObjEspec(\MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico $idObjEspec) {
        $this->idObjEspec = $idObjEspec;
    }

    /**
     * Get idObjEspec
     *
     * @return MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico 
     */
    public function getIdObjEspec() {
        return $this->idObjEspec;
    }

    /**
     * Set idObjTemplate
     *
     * @param integer $idObjTemplate
     */
    public function setIdObjTemplate($idObjTemplate) {
        $this->idObjTemplate = $idObjTemplate;
    }

    /**
     * Get idObjTemplate
     *
     * @return integer 
     */
    public function getIdObjTemplate() {
        return $this->idObjTemplate;
    }

    public function __construct() {
        $this->resultadostemplate = new  ArrayCollection();
    }

    /**
     * Add resultadostemplate
     *
     * @param MinSal\SidPla\GesObjEspEntControlBundle\Entity\ResEspTemplate $resultadostemplate
     */
    public function addResultadostemplate(\MinSal\SidPla\GesObjEspEntControlBundle\Entity\ResEspTemplate $resultadostemplate) {
        $this->resultadostemplate[] = $resultadostemplate;
    }

    /**
     * Get resultadostemplate
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getResultadostemplate() {
        return $this->resultadostemplate;
    }


    /**
     * Set objTmpEspe
     *
     * @param MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjTemplate $objTmpEspe
     */
    public function setObjTmpEspe(\MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjTemplate $objTmpEspe)
    {
        $this->objTmpEspe = $objTmpEspe;
    }

    /**
     * Get objTmpEspe
     *
     * @return MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjTemplate 
     */
    public function getObjTmpEspe()
    {
        return $this->objTmpEspe;
    }
}