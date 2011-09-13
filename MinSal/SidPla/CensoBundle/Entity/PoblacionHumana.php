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
     * @param string $pobhumSexo
     */
    public function setPobhumSexo($pobhumSexo)
    {
        $this->pobhumsexo = $pobhumSexo;
    }

    /**
     * Get pobhumsexo
     *
     * @return string 
     */
    public function getPobhumSexo()
    {
        return $this->pobhumsexo;
    }
}