<?php

namespace MinSal\SidPla\IndicadoresTemplateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\IndicadoresTemplateBundle\Entity\FormulaIndicador
 *
 * @ORM\Table(name="sidpla_formulaindicador")
 * @ORM\Entity
 */
class FormulaIndicador {

    /**
     * @var integer $codFormIndi
     *
     * @ORM\Column(name="formulaindicador_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codFormIndi;

    /**
     * @var string $nombreForm
     *
     * @ORM\Column(name="componenteformula_nombre", type="string", length=50)
     */
    private $nombreForm;

    /**
     * @ORM\ManyToOne(targetEntity="IndicadorSalud", inversedBy="formulaIndicador")
     * @ORM\JoinColumn(name="indsalu_codigo", referencedColumnName="indsalu_codigo")
     */
    private $indicadorSalud;


    /**
     * Get codFormIndi
     *
     * @return integer 
     */
    public function getCodFormIndi()
    {
        return $this->codFormIndi;
    }

    /**
     * Set nombreForm
     *
     * @param string $nombreForm
     */
    public function setNombreForm($nombreForm)
    {
        $this->nombreForm = $nombreForm;
    }

    /**
     * Get nombreForm
     *
     * @return string 
     */
    public function getNombreForm()
    {
        return $this->nombreForm;
    }

    /**
     * Set indicadorSalud
     *
     * @param MinSal\SidPla\IndicadoresTemplateBundle\Entity\IndicadorSalud $indicadorSalud
     */
    public function setIndicadorSalud(\MinSal\SidPla\IndicadoresTemplateBundle\Entity\IndicadorSalud $indicadorSalud)
    {
        $this->indicadorSalud = $indicadorSalud;
    }

    /**
     * Get indicadorSalud
     *
     * @return MinSal\SidPla\IndicadoresTemplateBundle\Entity\IndicadorSalud 
     */
    public function getIndicadorSalud()
    {
        return $this->indicadorSalud;
    }
}