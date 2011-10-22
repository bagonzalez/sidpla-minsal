<?php

namespace MinSal\SidPla\IndicadoresTemplateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\IndicadoresTemplateBundle\Entity\IndicadorSalud
 *
 * @ORM\Table(name="sidpla_indicadorsalud")
 * @ORM\Entity
 */
class IndicadorSalud {

    /**
     * @var integer $codIndSalud
     *
     * @ORM\Column(name="indsalu_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codIndSalud;

    /**
     * @var string $nombreIndSalud
     *
     * @ORM\Column(name="indsalu_nombre", type="string", length=100)
     */
    private $nombreIndSalud;

    /**
     * @var string $form1IndSalud
     *
     * @ORM\Column(name="indsalu_formula1", type="string", length=250)
     */
    private $form1IndSalud;

    /**
     * @var string $form2IndSalud
     *
     * @ORM\Column(name="indsalu_formula2", type="string", length=50)
     */
    private $form2IndSalud;

    /**
     * @var integer $tipoEvalua
     *
     * @ORM\Column(name="indsalu_tipoevalua", type="integer")
     */
    private $tipoEvalua;

    /**
     * @ORM\OneToMany(targetEntity="FormulaIndicador", mappedBy="indicadorSalud")
     */
    private $formulaIndicador;

    /**
     * @ORM\OneToMany(targetEntity="EvaluacionIndicador", mappedBy="indSalud")
     */
    private $evaluacionesIndicador;

    /**
     * @ORM\ManyToOne(targetEntity="TipoIndicador", inversedBy="indicadoresAsoc")
     * @ORM\JoinColumn(name="tipind_codigo", referencedColumnName="tipind_codigo")
     */
    private $tipoIndicador;

    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal", inversedBy="indicadoresSalud")
     * @ORM\JoinColumn(name="objespuni_codigo", referencedColumnName="objespuni_codigo")
     */
    private $objEspUnisal;

    public function __construct() {
        $this->formulaIndicador = new \Doctrine\Common\Collections\ArrayCollection();
        $this->evaluacionesIndicador = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get codIndSalud
     *
     * @return integer 
     */
    public function getCodIndSalud() {
        return $this->codIndSalud;
    }

    /**
     * Set tipoEvalua
     *
     * @param integer $tipoEvalua
     */
    public function setTipoEvalua($tipoEvalua) {
        $this->tipoEvalua = $tipoEvalua;
    }

    /**
     * Get tipoEvalua
     *
     * @return integer 
     */
    public function getTipoEvalua() {
        return $this->tipoEvalua;
    }

    /**
     * Set nombreIndSalud
     *
     * @param string $nombreIndSalud
     */
    public function setNombreIndSalud($nombreIndSalud) {
        $this->nombreIndSalud = $nombreIndSalud;
    }

    /**
     * Get nombreIndSalud
     *
     * @return string 
     */
    public function getNombreIndSalud() {
        return $this->nombreIndSalud;
    }

    /**
     * Set form1IndSalud
     *
     * @param string $form1IndSalud
     */
    public function setForm1IndSalud($form1IndSalud) {
        $this->form1IndSalud = $form1IndSalud;
    }

    /**
     * Get form1IndSalud
     *
     * @return string 
     */
    public function getForm1IndSalud() {
        return $this->form1IndSalud;
    }

    /**
     * Set form2IndSalud
     *
     * @param string $form2IndSalud
     */
    public function setForm2IndSalud($form2IndSalud) {
        $this->form2IndSalud = $form2IndSalud;
    }

    /**
     * Get form2IndSalud
     *
     * @return string 
     */
    public function getForm2IndSalud() {
        return $this->form2IndSalud;
    }

    /**
     * Add formulaIndicador
     *
     * @param MinSal\SidPla\IndicadoresTemplateBundle\Entity\FormulaIndicador $formulaIndicador
     */
    public function addFormulaIndicador(\MinSal\SidPla\IndicadoresTemplateBundle\Entity\FormulaIndicador $formulaIndicador) {
        $this->formulaIndicador[] = $formulaIndicador;
    }

    /**
     * Get formulaIndicador
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFormulaIndicador() {
        return $this->formulaIndicador;
    }

    /**
     * Add evaluacionesIndicador
     *
     * @param MinSal\SidPla\IndicadoresTemplateBundle\Entity\EvaluacionIndicador $evaluacionesIndicador
     */
    public function addEvaluacionesIndicador(\MinSal\SidPla\IndicadoresTemplateBundle\Entity\EvaluacionIndicador $evaluacionesIndicador) {
        $this->evaluacionesIndicador[] = $evaluacionesIndicador;
    }

    /**
     * Get evaluacionesIndicador
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEvaluacionesIndicador() {
        return $this->evaluacionesIndicador;
    }

    /**
     * Set tipoIndicador
     *
     * @param MinSal\SidPla\IndicadoresTemplateBundle\Entity\TipoIndicador $tipoIndicador
     */
    public function setTipoIndicador(\MinSal\SidPla\IndicadoresTemplateBundle\Entity\TipoIndicador $tipoIndicador) {
        $this->tipoIndicador = $tipoIndicador;
    }

    /**
     * Get tipoIndicador
     *
     * @return MinSal\SidPla\IndicadoresTemplateBundle\Entity\TipoIndicador 
     */
    public function getTipoIndicador() {
        return $this->tipoIndicador;
    }

    /**
     * Set objEspUnisal
     *
     * @param MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal $objEspUnisal
     */
    public function setObjEspUnisal(\MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal $objEspUnisal) {
        $this->objEspUnisal = $objEspUnisal;
    }

    /**
     * Get objEspUnisal
     *
     * @return MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal 
     */
    public function getObjEspUnisal() {
        return $this->objEspUnisal;
    }

}