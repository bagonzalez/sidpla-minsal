<?php

namespace MinSal\SidPla\CensoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\CensoBundle\Entity\CategoriaCenso
 *
 * @ORM\Table(name="sidpla_categoriacenso")
 * @ORM\Entity
 */
class CategoriaCenso
{
    /**
     * @var integer $idCategoriaCenso
     *
     * @ORM\Column(name="catcen_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */  
    private $idCategoriaCenso;

    /**
     * @var string $descripcionCategoria
     *
     * @ORM\Column(name="catcen_descripcion", type="string", length=200)
     */
    private $descripcionCategoria;

    /**
     * @var boolean $activo
     *
     * @ORM\Column(name="catcen_activo", type="boolean")
     */
    private $activo;

    /**
     * @var string $divTabla
     *
     * @ORM\Column(name="catcen_divtabla", type="string", length=100)
     */
    private $divTabla;
    
    
     /**
     * @ORM\ManyToOne(targetEntity="BloqueCenso", inversedBy="categoriasCenso")
     * @ORM\JoinColumn(name="bloquecenso_codigo", referencedColumnName="bloquecenso_codigo")
     */
    protected $bloque;


    /**
     * Set idCategoriaCenso
     *
     * @param integer $idCategoriaCenso
     */
    public function setIdCategoriaCenso($idCategoriaCenso)
    {
        $this->idCategoriaCenso = $idCategoriaCenso;
    }

    /**
     * Get idCategoriaCenso
     *
     * @return integer 
     */
    public function getIdCategoriaCenso()
    {
        return $this->idCategoriaCenso;
    }

    /**
     * Set descripcionCategoria
     *
     * @param string $descripcionCategoria
     */
    public function setDescripcionCategoria($descripcionCategoria)
    {
        $this->descripcionCategoria = $descripcionCategoria;
    }

    /**
     * Get descripcionCategoria
     *
     * @return string 
     */
    public function getDescripcionCategoria()
    {
        return $this->descripcionCategoria;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    /**
     * Get activo
     *
     * @return boolean 
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set divTabla
     *
     * @param string $divTabla
     */
    public function setDivTabla($divTabla)
    {
        $this->divTabla = $divTabla;
    }

    /**
     * Get divTabla
     *
     * @return string 
     */
    public function getDivTabla()
    {
        return $this->divTabla;
    }

    /**
     * Set bloque
     *
     * @param MinSal\SidPla\CensoBundle\Entity\BloqueCenso $bloque
     */
    public function setBloque(\MinSal\SidPla\CensoBundle\Entity\BloqueCenso $bloque)
    {
        $this->bloque = $bloque;
    }

    /**
     * Get bloque
     *
     * @return MinSal\SidPla\CensoBundle\Entity\BloqueCenso 
     */
    public function getBloque()
    {
        return $this->bloque;
    }
}