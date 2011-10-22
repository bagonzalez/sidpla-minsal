<?php

namespace MinSal\SidPla\IndicadoresTemplateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\IndicadoresTemplateBundle\Entity\TipoIndicador
 *
 * @ORM\Table(name="sidpla_tipoindicador")
 * @ORM\Entity
 */
class TipoIndicador {

    /**
     * @var integer $codTipIndi
     *
     * @ORM\Column(name="tipind_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codTipIndi;

    /**
     * @var string $nombreTipIndi
     *
     * @ORM\Column(name="tipind_nombre", type="string", length=25)
     */
    private $nombreTipIndi;

    /**
     * @ORM\OneToMany(targetEntity="IndicadorSalud", mappedBy="tipoIndicador")
     */
    private $indicadoresAsoc;

    public function __construct()
    {
        $this->indicadoresAsoc = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get codTipIndi
     *
     * @return integer 
     */
    public function getCodTipIndi()
    {
        return $this->codTipIndi;
    }

    /**
     * Set nombreTipIndi
     *
     * @param string $nombreTipIndi
     */
    public function setNombreTipIndi($nombreTipIndi)
    {
        $this->nombreTipIndi = $nombreTipIndi;
    }

    /**
     * Get nombreTipIndi
     *
     * @return string 
     */
    public function getNombreTipIndi()
    {
        return $this->nombreTipIndi;
    }

    /**
     * Add indicadoresAsoc
     *
     * @param MinSal\SidPla\IndicadoresTemplateBundle\Entity\IndicadorSalud $indicadoresAsoc
     */
    public function addIndicadoresAsoc(\MinSal\SidPla\IndicadoresTemplateBundle\Entity\IndicadorSalud $indicadoresAsoc)
    {
        $this->indicadoresAsoc[] = $indicadoresAsoc;
    }

    /**
     * Get indicadoresAsoc
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getIndicadoresAsoc()
    {
        return $this->indicadoresAsoc;
    }
}