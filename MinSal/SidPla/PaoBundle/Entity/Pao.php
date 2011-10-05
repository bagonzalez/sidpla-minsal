<?php

namespace MinSal\SidPla\PaoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\PaoBundle\Entity\Pao
 *
 * @ORM\Table(name="sidpla_pao")
 * @ORM\Entity
 */
class Pao {

    /**
     * @var integer $idPao
     *
     * @ORM\Column(name="pao_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idPao;

    /**
     * @var bigint $anio
     *
     * @ORM\Column(name="pao_anio", type="bigint")
     */
    private $anio;

    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa", inversedBy="paos")
     * @ORM\JoinColumn(name="uniorg_codigo", referencedColumnName="uniorg_codigo")
     */
    protected $unidadOrganizativa;

    /**
     * @ORM\OneToOne(targetEntity="MinSal\SidPla\CensoBundle\Entity\CensoPoblacion", mappedBy="pao")
     * @ORM\JoinColumn(name="censopoblacion_codigo", referencedColumnName="censopoblacion_codigo")
     */
    private $cesopoblacion;

    /**
     * @ORM\OneToOne(targetEntity="Justificacion", mappedBy="pao")
     * @ORM\JoinColumn(name="justificacion_codigo", referencedColumnName="justificacion_codigo")
     */
    private $justificacion;

    /**
     * @ORM\OneToMany(targetEntity="PeriodoPao", mappedBy="paoPerPao")
     */
    private $periodoCalendarizacion;

    /**
     * @ORM\OneToOne(targetEntity="MinSal\SidPla\EstInfraBundle\Entity\InfraestructuraEvaluada", mappedBy="paoInfraEva")
     * @ORM\JoinColumn(name="infeva_codigo", referencedColumnName="infeva_codigo")
     */
    private $infraEvaluadaPao;

    /**
     * @ORM\OneToMany(targetEntity="MinSal\SidPla\RRMedicoBundle\Entity\PrograRRMed", mappedBy="paoProRRMed")
     */
    private $programacionesRRMed;

    /**
     * Set idPao
     *
     * @param integer $idPao
     */
    public function setIdPao($idPao) {
        $this->idPao = $idPao;
    }

    /**
     * Get idPao
     *
     * @return integer 
     */
    public function getIdPao() {
        return $this->idPao;
    }

    /**
     * Set anio
     *
     * @param bigint $anio
     */
    public function setAnio($anio) {
        $this->anio = $anio;
    }

    /**
     * Get anio
     *
     * @return bigint 
     */
    public function getAnio() {
        return $this->anio;
    }

    /**
     * Set unidadOrganizativa
     *
     * @param MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa $unidadOrganizativa
     */
    public function setUnidadOrganizativa(\MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa $unidadOrganizativa) {
        $this->unidadOrganizativa = $unidadOrganizativa;
    }

    /**
     * Get unidadOrganizativa
     *
     * @return MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa 
     */
    public function getUnidadOrganizativa() {
        return $this->unidadOrganizativa;
    }

    /**
     * Set cesopoblacion
     *
     * @param MinSal\SidPla\CensoBundle\Entity\CensoPoblacion $cesopoblacion
     */
    public function setCesopoblacion(\MinSal\SidPla\CensoBundle\Entity\CensoPoblacion $cesopoblacion) {
        $this->cesopoblacion = $cesopoblacion;
    }

    /**
     * Get cesopoblacion
     *
     * @return MinSal\SidPla\CensoBundle\Entity\CensoPoblacion 
     */
    public function getCesopoblacion() {
        return $this->cesopoblacion;
    }

    /**
     * Set justificacion
     *
     * @param MinSal\SidPla\PaoBundle\Entity\Justificacion $justificacion
     */
    public function setJustificacion(\MinSal\SidPla\PaoBundle\Entity\Justificacion $justificacion) {
        $this->justificacion = $justificacion;
    }

    /**
     * Get justificacion
     *
     * @return MinSal\SidPla\PaoBundle\Entity\Justificacion 
     */
    public function getJustificacion() {
        return $this->justificacion;
    }

    public function __construct() {
        $this->programacionesRRMed = new \Doctrine\Common\Collections\ArrayCollection();
        $this->periodoCalendarizacion = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add periodoCalendarizacion
     *
     * @param MinSal\SidPla\PaoBundle\Entity\PeriodoPao $periodoCalendarizacion
     */
    public function addPeriodoPao(\MinSal\SidPla\PaoBundle\Entity\PeriodoPao $periodoCalendarizacion) {
        $this->periodoCalendarizacion[] = $periodoCalendarizacion;
    }

    /**
     * Get periodoCalendarizacion
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPeriodoCalendarizacion() {
        return $this->periodoCalendarizacion;
    }

    /**
     * Add programacionesRRMed
     *
     * @param MinSal\SidPla\RRMedicoBundle\Entity\PrograRRMed $programacionesRRMed
     */
    public function addPrograRRMed(\MinSal\SidPla\RRMedicoBundle\Entity\PrograRRMed $programacionesRRMed) {
        $this->programacionesRRMed[] = $programacionesRRMed;
    }

    /**
     * Get programacionesRRMed
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProgramacionesRRMed() {
        return $this->programacionesRRMed;
    }

    /**
     * Set infraEvaluadaPao
     *
     * @param MinSal\SidPla\EstInfraBundle\Entity\InfraestructuraEvaluada $infraEvaluadaPao
     */
    public function setinfraEvaluadaPao($infraEvaluadaPao) {
        $this->infraEvaluadaPao = $infraEvaluadaPao;
    }

    /**
     * Get infraEvaluadaPao
     *
     * @return MinSal\SidPla\EstInfraBundle\Entity\InfraestructuraEvaluada 
     */
    public function getinfraEvaluadaPao() {
        return $this->infraEvaluadaPao;
    }

}