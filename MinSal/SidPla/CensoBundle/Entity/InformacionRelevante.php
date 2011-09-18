<?php

namespace MinSal\SidPla\CensoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\CensoBundle\Entity\InformacionRelevante
 *
 * @ORM\Table(name="sidpla_informacionrelevante")
 * @ORM\Entity
 */
class InformacionRelevante
{
    /**
     * @var integer $idInfRel
     *
     * @ORM\Column(name="infrel_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idInfRel;

    
    /**
     * @var integer $codCenPob
     *
     * @ORM\Column(name="censopoblacion_codigo", type="integer")
     */
    private $codCenPob;

    /**
     * @var integer $codCatCen
     *
     * @ORM\Column(name="catcen_codigo", type="integer")
     */
    private $codCatCen;

    /**
     * @var integer $infRelCant
     *
     * @ORM\Column(name="infrel_cantidad", type="integer")
     */
    private $infRelCant;
    
    
     /**
     * @ORM\ManyToOne(targetEntity="CensoPoblacion", inversedBy="informacionRelevante")
     * @ORM\JoinColumn(name="censopoblacion_codigo", referencedColumnName="censopoblacion_codigo")
     */
    protected $censoPoblacion;
    
     /**
     * @ORM\ManyToOne(targetEntity="CategoriaCenso", inversedBy="infRelevante")
     * @ORM\JoinColumn(name="catcen_codigo", referencedColumnName="catcen_codigo")
     */
    protected $categoriaCenso;


    /**
     * Get idInfRel
     *
     * @return integer 
     */
    public function getIdInfRel()
    {
        return $this->idInfRel;
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
     * Set infRelCant
     *
     * @param integer $infRelCant
     */
    public function setInfRelCant($infRelCant)
    {
        $this->infRelCant = $infRelCant;
    }

    /**
     * Get infRelCant
     *
     * @return integer 
     */
    public function getInfRelCant()
    {
        return $this->infRelCant;
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