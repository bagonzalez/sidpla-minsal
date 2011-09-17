<?php

namespace MinSal\SidPla\CensoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * MinSal\SidPla\CensoBundle\Entity\PoblacionHumana
 *
 * @ORM\Table(name="sidpla_poblacionhumana")
 * @ORM\Entity
 */
class PoblacionHumana
{
    /**
     * @var integer $idPobHum
     *
     * @ORM\Column(name="pobhum_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idPobHum;

    /**
     * @var integer $codCatCen
     *
     * @ORM\Column(name="catcen_codigo", type="integer")
     */
    private $codCatCen;

    /**
     * @var integer $codCenPob
     *
     * @ORM\Column(name="censopoblacion_codigo", type="integer")
     */
    private $codCenPob;

    /**
     * @var string $pobHumClasi
     *
     * @ORM\Column(name="pobhum_clasificacion", type="string", length=10)
     */
    private $pobHumClasi;

    /**
     * @var string $pobHumArea
     *
     * @ORM\Column(name="pobhum_area", type="string", length=10)
     */
    private $pobHumArea;

    /**
     * @var integer $pobHumCant
     *
     * @ORM\Column(name="pobhum_cantidad", type="integer")
     */
    private $pobHumCant;

    /**
     * @var string $pobhumsexo
     *
     * @ORM\Column(name="pobhum_sexo", type="string", length=1)
     */
    private $pobhumsexo;
    
    
     /**
     * @ORM\ManyToOne(targetEntity="CategoriaCenso", inversedBy="poblacionHumana")
     * @ORM\JoinColumn(name="catcen_codigo", referencedColumnName="catcen_codigo")
     */
    protected $categoriaCenso;
    
     /**
     * @ORM\ManyToOne(targetEntity="CensoPoblacion", inversedBy="poblacionHumana")
     * @ORM\JoinColumn(name="censopoblacion_codigo", referencedColumnName="censopoblacion_codigo")
     */
    protected $censoPoblacion;


    /**
     * Get idPobHum
     *
     * @return integer 
     */
    public function getIdPobHum()
    {
        return $this->idPobHum;
    }

    /**
     * Set codCatCen
     *
     * @param integer $codCatCen
     */
    public function setCodCatCen($codCatCen)
    {
        $this->codCatCen = $codCatCen;
    }

    /**
     * Get codCatCen
     *
     * @return integer 
     */
    public function getCodCatCen()
    {
        return $this->codCatCen;
    }

    /**
     * Set codCenPob
     *
     * @param integer $codCenPob
     */
    public function setCodCenPob($codCenPob)
    {
        $this->codCenPob = $codCenPob;
    }

    /**
     * Get codCenPob
     *
     * @return integer 
     */
    public function getCodCenPob()
    {
        return $this->codCenPob;
    }

    /**
     * Set pobHumClasi
     *
     * @param string $pobHumClasi
     */
    public function setPobHumClasi($pobHumClasi)
    {
        $this->pobHumClasi = $pobHumClasi;
    }

    /**
     * Get pobHumClasi
     *
     * @return string 
     */
    public function getPobHumClasi()
    {
        return $this->pobHumClasi;
    }

    /**
     * Set pobHumArea
     *
     * @param string $pobHumArea
     */
    public function setPobHumArea($pobHumArea)
    {
        $this->pobHumArea = $pobHumArea;
    }

    /**
     * Get pobHumArea
     *
     * @return string 
     */
    public function getPobHumArea()
    {
        return $this->pobHumArea;
    }

    /**
     * Set pobHumCant
     *
     * @param integer $pobHumCant
     */
    public function setPobHumCant($pobHumCant)
    {
        $this->pobHumCant = $pobHumCant;
    }

    /**
     * Get pobHumCant
     *
     * @return integer 
     */
    public function getPobHumCant()
    {
        return $this->pobHumCant;
    }    

    /**
     * Set pobhumsexo
     *
     * @param string $pobhumsexo
     */
    public function setPobhumsexo($pobhumsexo)
    {
        $this->pobhumsexo = $pobhumsexo;
    }

    /**
     * Get pobhumsexo
     *
     * @return string 
     */
    public function getPobhumsexo()
    {
        return $this->pobhumsexo;
    }

    /**
     * Set categoriaCenso
     *
     * @param MinSal\SidPla\CensoBundle\Entity\CategoriaCenso $categoriaCenso
     */
    public function setCategoriaCenso(\MinSal\SidPla\CensoBundle\Entity\CategoriaCenso $categoriaCenso)
    {
        $this->categoriaCenso = $categoriaCenso;
    }

    /**
     * Get categoriaCenso
     *
     * @return MinSal\SidPla\CensoBundle\Entity\CategoriaCenso 
     */
    public function getCategoriaCenso()
    {
        return $this->categoriaCenso;
    }

    /**
     * Set censoPoblacion
     *
     * @param MinSal\SidPla\CensoBundle\Entity\CensoPoblacion $censoPoblacion
     */
    public function setCensoPoblacion(\MinSal\SidPla\CensoBundle\Entity\CensoPoblacion $censoPoblacion)
    {
        $this->censoPoblacion = $censoPoblacion;
    }

    /**
     * Get censoPoblacion
     *
     * @return MinSal\SidPla\CensoBundle\Entity\CensoPoblacion 
     */
    public function getCensoPoblacion()
    {
        return $this->censoPoblacion;
    }
}