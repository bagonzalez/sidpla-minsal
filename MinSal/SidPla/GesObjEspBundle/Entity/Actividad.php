<?php

namespace MinSal\SidPla\GesObjEspBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * MinSal\SidPla\GesObjEspBundle\Entity\Actividad
 *
 * @ORM\Table(name="sidpla_actividad")
 * @ORM\Entity
 */
class Actividad
{
    /**
     * @var integer $idAct
     *
     * @ORM\Column(name="actividad_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idAct;

    
    /**
     * @var integer $idTipoMeta
     *
     * @ORM\Column(name="tipometa_codigo", type="integer")
     */
    private $idTipoMeta;

    /**
     * @var integer $idTipoMedVeri
     *
     * @ORM\Column(name="tipmedver_codigo", type="integer")
     */
    private $idTipoMedVeri;

    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado", inversedBy="actividades")
     * @ORM\JoinColumn(name="resesp_codigo", referencedColumnName="resesp_codigo")
     */
    private $idResEsp;

    /**
     * @var string $actDescMetaAnu
     *
     * @ORM\Column(name="actividad_descripmetanual", type="string", length=50)
     */
    private $actDescMetaAnu;

    /**
     * @var string $actResponsable
     *
     * @ORM\Column(name="activiadad_responsable", type="string", length=60)
     */
    private $actResponsable;

    /**
     * @var string $actDescripcion
     *
     * @ORM\Column(name="actividad_descripcion", type="string", length=300)
     */
    private $actDescripcion;

    /**
     * @var integer $actMetaAnual
     *
     * @ORM\Column(name="actividad_metanual", type="integer")
     */
    private $actMetaAnual;

    /**
     * @var string $actNomenclatura
     *
     * @ORM\Column(name="actividad_nomenclatura", type="string", length=255)
     */
    private $actNomenclatura;


    /**
     * Set idAct
     *
     * @param integer $idAct
     */
    public function setIdAct($idAct)
    {
        $this->idAct = $idAct;
    }

    /**
     * Get idAct
     *
     * @return integer 
     */
    public function getIdAct()
    {
        return $this->idAct;
    }

    /**
     * Set idTipoMeta
     *
     * @param integer $idTipoMeta
     */
    public function setIdTipoMeta($idTipoMeta)
    {
        $this->idTipoMeta = $idTipoMeta;
    }

    /**
     * Get idTipoMeta
     *
     * @return integer 
     */
    public function getIdTipoMeta()
    {
        return $this->idTipoMeta;
    }

    /**
     * Set idTipoMedVeri
     *
     * @param integer $idTipoMedVeri
     */
    public function setIdTipoMedVeri($idTipoMedVeri)
    {
        $this->idTipoMedVeri = $idTipoMedVeri;
    }

    /**
     * Get idTipoMedVeri
     *
     * @return integer 
     */
    public function getIdTipoMedVeri()
    {
        return $this->idTipoMedVeri;
    }

    /**
     * Set idResEsp  
     *
     * @param MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado $idResEsp
     */
    public function setIdResEsp(\MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado $idResEsp)
    {
        $this->idResEsp = $idResEsp;
    }

    /**
     * Get idResEsp
     *
     * @return MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado 
     */
    public function getIdResEsp()
    {
        return $this->idResEsp;
    }

    /**
     * Set actDescMetaAnu
     *
     * @param string $actDescMetaAnu
     */
    public function setActDescMetaAnu($actDescMetaAnu)
    {
        $this->actDescMetaAnu = $actDescMetaAnu;
    }

    /**
     * Get actDescMetaAnu
     *
     * @return string 
     */
    public function getActDescMetaAnu()
    {
        return $this->actDescMetaAnu;
    }

    /**
     * Set actResponsable
     *
     * @param string $actResponsable
     */
    public function setActResponsable($actResponsable)
    {
        $this->actResponsable = $actResponsable;
    }

    /**
     * Get actResponsable
     *
     * @return string 
     */
    public function getActResponsable()
    {
        return $this->actResponsable;
    }

    /**
     * Set actDescripcion
     *
     * @param string $actDescripcion
     */
    public function setActDescripcion($actDescripcion)
    {
        $this->actDescripcion = $actDescripcion;
    }

    /**
     * Get actDescripcion
     *
     * @return string 
     */
    public function getActDescripcion()
    {
        return $this->actDescripcion;
    }

    /**
     * Set actMetaAnual
     *
     * @param integer $actMetaAnual
     */
    public function setActMetaAnual($actMetaAnual)
    {
        $this->actMetaAnual = $actMetaAnual;
    }

    /**
     * Get actMetaAnual
     *
     * @return integer 
     */
    public function getActMetaAnual()
    {
        return $this->actMetaAnual;
    }

    /**
     * Set actNomenclatura
     *
     * @param string $actNomenclatura
     */
    public function setActNomenclatura($actNomenclatura)
    {
        $this->actNomenclatura = $actNomenclatura;
    }

    /**
     * Get actNomenclatura
     *
     * @return string 
     */
    public function getActNomenclatura()
    {
        return $this->actNomenclatura;
    }
}