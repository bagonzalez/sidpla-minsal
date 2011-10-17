<?php

namespace MinSal\SidPla\TemplateUnisalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\TemplateUnisalBundle\Entity\ActividadUnisalTemplate
 *
 * @ORM\Table(name="sidpla_actividadunisaltemplate")
 * @ORM\Entity
 */
class ActividadUnisalTemplate {

    /**
     * @var integer $codActUniTemp
     *
     * @ORM\Column(name="actunitem_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codActUniTemp;

    /**
     * @var string $descActUniTemp
     *
     * @ORM\Column(name="actunitem_descripcion", type="string", length=200)
     */
    private $descActUniTemp;

    /**
     * @var string $nomenActUniTemp
     *
     * @ORM\Column(name="actunitem_nomenclatura", type="string", length=15)
     */
    private $nomenActUniTemp;

    /**
     * @var string $responsableActUniTemp
     *
     * @ORM\Column(name="actunitem_responsable", type="string", length=60)
     */
    private $responsableActUniTemp;

    /**
     * @var string $beneActUniTemp
     *
     * @ORM\Column(name="actunitem_beneficiario", type="string", length=180)
     */
    private $beneActUniTemp;

    /**
     * @var float $coberActUniTemp
     *
     * @ORM\Column(name="actunitem_cobertura", type="float")
     */
    private $coberActUniTemp;

    /**
     * @var float $concenActUniTemp
     *
     * @ORM\Column(name="actunitem_concentracion", type="float")
     */
    private $concenActUniTemp;

    /**
     * @var string $condActUniTemp
     *
     * @ORM\Column(name="actunitem_condicionante", type="string", length=255)
     */
    private $condActUniTemp;

    /**
     * @var integer $metaAnualActUniTemp
     *
     * @ORM\Column(name="actunitem_tipometaanual", type="integer")
     */
    private $metaAnualActUniTemp;

    /**
     * @ORM\ManyToOne(targetEntity="ResultadoEspeUnisal", inversedBy="actividadesTemplate")
     * @ORM\JoinColumn(name="resulespuni_codigo", referencedColumnName="resulespuni_codigo")
     */
    private $resulEspeTemAct;

    /**
     * @ORM\OneToMany(targetEntity="FormulaActividad", mappedBy="actUnisalForm")
     */
    private $formulasAct;

    public function __construct() {
        $this->formulasAct = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get codActUniTemp
     *
     * @return integer 
     */
    public function getCodActUniTemp() {
        return $this->codActUniTemp;
    }

    /**
     * Set descActUniTemp
     *
     * @param string $descActUniTemp
     */
    public function setDescActUniTemp($descActUniTemp) {
        $this->descActUniTemp = $descActUniTemp;
    }

    /**
     * Get descActUniTemp
     *
     * @return string 
     */
    public function getDescActUniTemp() {
        return $this->descActUniTemp;
    }

    /**
     * Set metaAnualActUniTemp
     *
     * @param integer $metaAnualActUniTemp
     */
    public function setMetaAnualActUniTemp($metaAnualActUniTemp) {
        $this->metaAnualActUniTemp = $metaAnualActUniTemp;
    }

    /**
     * Get metaAnualActUniTemp
     *
     * @return integer 
     */
    public function getMetaAnualActUniTemp() {
        return $this->metaAnualActUniTemp;
    }

    /**
     * Set nomenActUniTemp
     *
     * @param string $nomenActUniTemp
     */
    public function setNomenActUniTemp($nomenActUniTemp) {
        $this->nomenActUniTemp = $nomenActUniTemp;
    }

    /**
     * Get nomenActUniTemp
     *
     * @return string 
     */
    public function getNomenActUniTemp() {
        return $this->nomenActUniTemp;
    }

    /**
     * Set responsableActUniTemp
     *
     * @param string $responsableActUniTemp
     */
    public function setResponsableActUniTemp($responsableActUniTemp) {
        $this->responsableActUniTemp = $responsableActUniTemp;
    }

    /**
     * Get responsableActUniTemp
     *
     * @return string 
     */
    public function getResponsableActUniTemp() {
        return $this->responsableActUniTemp;
    }

    /**
     * Set beneActUniTemp
     *
     * @param string $beneActUniTemp
     */
    public function setBeneActUniTemp($beneActUniTemp) {
        $this->beneActUniTemp = $beneActUniTemp;
    }

    /**
     * Get beneActUniTemp
     *
     * @return string 
     */
    public function getBeneActUniTemp() {
        return $this->beneActUniTemp;
    }

    /**
     * Set coberActUniTemp
     *
     * @param float $coberActUniTemp
     */
    public function setCoberActUniTemp($coberActUniTemp) {
        $this->coberActUniTemp = $coberActUniTemp;
    }

    /**
     * Get coberActUniTemp
     *
     * @return float 
     */
    public function getCoberActUniTemp() {
        return $this->coberActUniTemp;
    }

    /**
     * Set concenActUniTemp
     *
     * @param float $concenActUniTemp
     */
    public function setConcenActUniTemp($concenActUniTemp) {
        $this->concenActUniTemp = $concenActUniTemp;
    }

    /**
     * Get concenActUniTemp
     *
     * @return float 
     */
    public function getConcenActUniTemp() {
        return $this->concenActUniTemp;
    }

    /**
     * Set condActUniTemp
     *
     * @param string $condActUniTemp
     */
    public function setCondActUniTemp($condActUniTemp) {
        $this->condActUniTemp = $condActUniTemp;
    }

    /**
     * Get condActUniTemp
     *
     * @return string 
     */
    public function getCondActUniTemp() {
        return $this->condActUniTemp;
    }

    /**
     * Set resulEspeTemAct
     *
     * @param MinSal\SidPla\TemplateUnisalBundle\Entity\ResultadoEspeUnisal $resulEspeTemAct
     */
    public function setResulEspeTemAct(\MinSal\SidPla\TemplateUnisalBundle\Entity\ResultadoEspeUnisal $resulEspeTemAct) {
        $this->resulEspeTemAct = $resulEspeTemAct;
    }

    /**
     * Get resulEspeTemAct
     *
     * @return MinSal\SidPla\TemplateUnisalBundle\Entity\ResultadoEspeUnisal 
     */
    public function getResulEspeTemAct() {
        return $this->resulEspeTemAct;
    }

    /**
     * Add formulasAct
     *
     * @param MinSal\SidPla\TemplateUnisalBundle\Entity\FormulaActividad $formulasAct
     */
    public function addFormulasAct(\MinSal\SidPla\TemplateUnisalBundle\Entity\FormulaActividad $formulasAct) {
        $this->formulasAct[] = $formulasAct;
    }

    /**
     * Get formulasAct
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFormulasAct() {
        return $this->formulasAct;
    }

}