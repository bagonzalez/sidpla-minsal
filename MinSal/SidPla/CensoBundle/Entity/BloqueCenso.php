<?php

namespace MinSal\SidPla\CensoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * MinSal\SidPla\CensoBundle\Entity\BloqueCenso
 *
 * @ORM\Table(name="sidpla_bloquecenso")
 * @ORM\Entity
 */
class BloqueCenso
{
    /**
     * @var integer $idBloque
     *
     * @ORM\Column(name="bloquecenso_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idBloque;

    /**
     * @var string $nombreBloque
     *
     * @ORM\Column(name="bloquecenso_nombrebloque", type="string", length=150)
     */
    private $nombreBloque;

    /**
     * @var integer $ordenBloque
     *
     * @ORM\Column(name="bloquecenso_orden", type="integer")
     */
    private $ordenBloque;
    
     /**
     * @ORM\OneToMany(targetEntity="CategoriaCenso", mappedBy="bloque")
     */
    protected $categoriasCenso;
    
    public function __construct()
    {
        $this->categoriasCenso = new ArrayCollection();
    }


    /**
     * Get idBloque
     *
     * @return integer 
     */
    public function getIdBloque()
    {
        return $this->idBloque;
    }

     /**
     * Set nombreBloque
     *
     * @param string $NombreBloque
     */
    public function setNombreBloque($NombreBloque)
    {
        $this->nombreBloque = $NombreBloque;
    }

    /**
     * Get nombreBloque
     *
     * @return string 
     */
    public function getNombreBloque()
    {
        return $this->nombreBloque;
    }

    /**
     * Set ordenBloque
     *
     * @param integer $OrdenBloque
     */
    public function setOrdenBloque($OrdenBloque)
    {
        $this->ordenBloque = $OrdenBloque;
    }

    /**
     *Get ordenBloque
     *
     * @return integer 
     */
    public function getOrdenBloque()
    {
        return $this->ordenBloque;
    }

    /**
     * Add categoriasCenso
     *
     * @param MinSal\SidPla\CensoBundle\Entity\CategoriaCenso $categoriasCenso
     */
    public function addCategoriasCenso(\MinSal\SidPla\CensoBundle\Entity\CategoriaCenso $categoriasCenso)
    {
        $this->categoriasCenso[] = $categoriasCenso;
    }

    /**
     * Get categoriasCenso
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCategoriasCenso()
    {
        return $this->categoriasCenso;
    }
    
     public function __toString()
    {
       return $this->getNombreBloque();
    }
    
}