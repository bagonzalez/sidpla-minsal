<?php

namespace MinSal\SidPla\GesObjEspEntControlBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjTemplate
 *
 * @ORM\Table(name="sidpla_objtemplate")
 * @ORM\Entity
 */
class ObjTemplate {

    /**
     * @var integer $codObjTmp
     *
     * @ORM\Column(name="objtmp_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codObjTmp;

    /**
     * @var bigint $anioObjTemp
     *
     * @ORM\Column(name="objtmp_anio", type="bigint")
     */
    private $anioObjTemp;

    /**
     * @ORM\OneToMany(targetEntity="ObjespTemplate", mappedBy="objTmpEspe", cascade={"persist", "remove"})
     */
    private $especificoObjTmp;

    /**
     * Get codObjTmp
     *
     * @return integer 
     */
    public function getCodObjTmp() {
        return $this->codObjTmp;
    }

    /**
     * Set anioObjTemp
     *
     * @param bigint $anioObjTemp
     */
    public function setAnioObjTemp($anioObjTemp) {
        $this->anioObjTemp = $anioObjTemp;
    }

    /**
     * Get anioObjTemp
     *
     * @return bigint 
     */
    public function getAnioObjTemp() {
        return $this->anioObjTemp;
    }

    public function __construct()
    {
        $this->especificoObjTmp = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add especificoObjTmp
     *
     * @param MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjespTemplate $especificoObjTmp
     */
    public function addEspecificoObjTmp(\MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjespTemplate $especificoObjTmp)
    {
        $this->especificoObjTmp[] = $especificoObjTmp;
    }

    /**
     * Get especificoObjTmp
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEspecificoObjTmp()
    {
        return $this->especificoObjTmp;
    }
}