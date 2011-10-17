<?php

namespace MinSal\SidPla\TemplateUnisalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\TemplateUnisalBundle\Entity\FormulaActividad
 *
 * @ORM\Table(name="sidpla_formulactividad")
 * @ORM\Entity
 */
class FormulaActividad {

    /**
     * @var integer $codFormAct
     *
     * @ORM\Column(name="foract_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codFormAct;

    /**
     * @var string $nombreFormAct
     *
     * @ORM\Column(name="foract_nombre", type="string", length=50)
     */
    private $nombreFormAct;

    /**
     * @ORM\ManyToOne(targetEntity="ActividadUnisalTemplate", inversedBy="formulasAct")
     * @ORM\JoinColumn(name="actunitem_codigo", referencedColumnName="actunitem_codigo")
     */
    private $actUnisalForm;


    /**
     * Get codFormAct
     *
     * @return integer 
     */
    public function getCodFormAct()
    {
        return $this->codFormAct;
    }

    /**
     * Set nombreFormAct
     *
     * @param string $nombreFormAct
     */
    public function setNombreFormAct($nombreFormAct)
    {
        $this->nombreFormAct = $nombreFormAct;
    }

    /**
     * Get nombreFormAct
     *
     * @return string 
     */
    public function getNombreFormAct()
    {
        return $this->nombreFormAct;
    }

    /**
     * Set actUnisalForm
     *
     * @param MinSal\SidPla\TemplateUnisalBundle\Entity\ActividadUnisalTemplate $actUnisalForm
     */
    public function setActUnisalForm(\MinSal\SidPla\TemplateUnisalBundle\Entity\ActividadUnisalTemplate $actUnisalForm)
    {
        $this->actUnisalForm = $actUnisalForm;
    }

    /**
     * Get actUnisalForm
     *
     * @return MinSal\SidPla\TemplateUnisalBundle\Entity\ActividadUnisalTemplate 
     */
    public function getActUnisalForm()
    {
        return $this->actUnisalForm;
    }
}