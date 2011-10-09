<?php

namespace MinSal\SidPla\GesObjEspEntControlBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjespTemplate
 *
 * @ORM\Table(name= "sidpla_objespectemplate")
 * @ORM\Entity
 */
class ObjespTemplate
{
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
     * @var integer $idObjTemplate
     *
     * @ORM\Column(name="objtmp_codigo", type="integer")
     */
    private $idObjTemplate;

    
    /**
     * @ORM\OneToMany(targetEntity="MinSal\SidPla\GesObjEspEntControlBundle\Entity\ResEspTemplate", mappedBy="idObjEspecTempl",   cascade={"persist", "remove"})
     */
    protected $resultadostemplate;
    
    /**
     * Set idObjEspTempl
     *
     * @param integer $idObjEspTempl
     */
    public function setIdObjEspTempl($idObjEspTempl)
    {
        $this->idObjEspTempl = $idObjEspTempl;
    }

    /**
     * Get idObjEspTempl
     *
     * @return integer 
     */
    public function getIdObjEspTempl()
    {
        return $this->idObjEspTempl;
    }

    /**
     * Set idObjEspec
     *
     * @param MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico $idObjEspec
     */
    public function setIdObjEspec(\MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico $idObjEspec)
    {
        $this->idObjEspec = $idObjEspec;
    }

    /**
     * Get idObjEspec
     *
     * @return MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico 
     */
    public function getIdObjEspec()
    {
        return $this->idObjEspec;
    }

    /**
     * Set idObjTemplate
     *
     * @param integer $idObjTemplate
     */
    public function setIdObjTemplate($idObjTemplate)
    {
        $this->idObjTemplate = $idObjTemplate;
    }

    /**
     * Get idObjTemplate
     *
     * @return integer 
     */
    public function getIdObjTemplate()
    {
        return $this->idObjTemplate;
    }
    
    public function __construct()
    {
        $this->resultadostemplate= new ArrayCollection();
        
    }
    /**
     * Add resultadostemplate
     *
     * @param MinSal\SidPla\GesObjEspEntControlBundle\Entity\ResEspTemplate $resultadostemplate
     */
    public function addResultadostemplate(\MinSal\SidPla\GesObjEspEntControlBundle\Entity\ResEspTemplate $resultadostemplate)
    {
        $this->resultadostemplate[] = $resultadostemplate;
    }

    /**
     * Get resultadostemplate
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getResultadostemplate()
    {
        return $this->resultadostemplate;
    }
}