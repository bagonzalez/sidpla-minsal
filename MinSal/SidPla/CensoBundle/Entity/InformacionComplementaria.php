<?php

namespace MinSal\SidPla\CensoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * MinSal\SidPla\CensoBundle\Entity\InformacionComplementaria
 *
 * @ORM\Table(name="sidpla_infcomplementaria")
 * @ORM\Entity
 */

class InformacionComplementaria
{
    /**
     * @var integer $idInfoComp
     *
     * @ORM\Column(name="infcom_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idInfoComp;

    /**
     * @var string $areaInfoComp
     *
     * @ORM\Column(name="infcom_area", type="string", length=10)
     */
    private $areaInfoComp;

    /**
     * @var integer $codigoCensoPoblacion
     *
     * @ORM\Column(name="censopoblacion_codigo", type="integer")
     */
    private $codigoCensoPoblacion;

    
    /**
     * @var integer $codigoCatCen
     *
     * @ORM\Column(name="catcen_codigo", type="integer")
     */
    private $codigoCatCen;
 
    
       /**
     * @var integer $cantidadInfoComp
     *
     * @ORM\Column(name="infcom_cantidad", type="integer")
     */
    private $cantidadInfoComp;
    
    
        /**
     * @ORM\ManyToOne(targetEntity="CensoPoblacion", inversedBy="informacionComplementaria")
     * @ORM\JoinColumn(name="censopoblacion_codigo", referencedColumnName="censopoblacion_codigo")
     */
    protected $censoPoblacion;
    
     /**
     * @ORM\ManyToOne(targetEntity="CategoriaCenso", inversedBy="infComplementaria")
     * @ORM\JoinColumn(name="catcen_codigo", referencedColumnName="catcen_codigo")
     */
    protected $categoriaCenso;

    
    /**
     * Get idInfoComp
     *
     * @return integer 
     */
    public function getIdInfoComp()
    {
        return $this->idInfoComp;
    }

    /**
     * Set areaInfoComp
     *
     * @param string $areaInfoComp
     */
    public function setAreaInfoComp($areaInfoComp)
    {
        $this->areaInfoComp = $areaInfoComp;
    }

    /**
     * Get areaInfoComp
     *
     * @return string 
     */
    public function getAreaInfoComp()
    {
        return $this->areaInfoComp;
    }

    /**
     * Set codigoCensoPoblacion
     *
     * @param integer $codigoCensoPoblacion
     */
    public function setCodigoCensoPoblacion($codigoCensoPoblacion)
    {
        $this->codigoCensoPoblacion = $codigoCensoPoblacion;
    }

    /**
     * Get codigoCensoPoblacion
     *
     * @return integer 
     */
    public function getCodigoCensoPoblacion()
    {
        return $this->codigoCensoPoblacion;
    }

    /**
     * Set codigoCatCen
     *
     * @param integer $codigoCatCen
     */
    public function setCodigoCatCen($codigoCatCen)
    {
        $this->codigoCatCen = $codigoCatCen;
    }

    /**
     * Get codigoCatCen
     *
     * @return integer 
     */
    public function getCodigoCatCen()
    {
        return $this->codigoCatCen;
    }
    
    /**
     * Set cantidadInfoComp
     *
     * @param integer $cantidadInfoComp
     */
    public function setCantidadInfoComp($cantidadInfoComp)
    {
        $this->cantidadInfoComp = $cantidadInfoComp;
    }

    /**
     * Get cantidadInfoComp
     *
     * @return integer 
     */
    public function getCantidadInfoComp()
    {
        return $this->cantidadInfoComp;
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
}