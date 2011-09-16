<?php

namespace MinSal\SidPla\CensoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\CensoBundle\Entity\CensoPoblacion
 *
 * @ORM\Table(name="sidpla_censopoblacion")
 * @ORM\Entity
 */
class CensoPoblacion
{
    /**
     * @var integer $idCensoPoblacion
     *
     * @ORM\Column(name="censopoblacion_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
   
    private $idCensoPoblacion;
    
    
      /**
     * @ORM\OneToOne(targetEntity="MinSal\SidPla\PaoBundle\Entity\Pao", inversedBy="cesopoblacion")
     * @ORM\JoinColumn(name="pao_codigo", referencedColumnName="pao_codigo")
     */
    private $pao;
    
     /**
     * @ORM\ManyToMany(targetEntity="CategoriaCenso")
     * @ORM\JoinTable(name="sidpla_censo_categoria",
     *      joinColumns={@ORM\JoinColumn(name="censopoblacion_codigo", referencedColumnName="censopoblacion_codigo")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="catcen_codigo", referencedColumnName="catcen_codigo")}
     *      )
     */
    private $categoriasCenso;
    
    
      /**
     * @ORM\OneToMany(targetEntity="PoblacionHumana", mappedBy="censoPoblacion")
     */
    protected $poblacionHumana;


    /**
     * Set idCensoPoblacion
     *
     * @param integer $idCensoPoblacion
     */
    public function setIdCensoPoblacion($idCensoPoblacion)
    {
        $this->idCensoPoblacion = $idCensoPoblacion;
    }

    /**
     * Get idCensoPoblacion
     *
     * @return integer 
     */
    public function getIdCensoPoblacion()
    {
        return $this->idCensoPoblacion;
    }

    /**
     * Set pao
     *
     * @param MinSal\SidPla\PaoBundle\Entity\Pao $pao
     */
    public function setPao(\MinSal\SidPla\PaoBundle\Entity\Pao $pao)
    {
        $this->pao = $pao;
    }

    /**
     * Get pao
     *
     * @return MinSal\SidPla\PaoBundle\Entity\Pao 
     */
    public function getPao()
    {
        return $this->pao;
    }
    
    public function __construct()
    {
        $this->categoriasCenso = new \Doctrine\Common\Collections\ArrayCollection();
        $this->poblacionHumana = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Add categoriasCenso
     *
     * @param MinSal\SidPla\CensoBundle\Entity\CategoriaCenso $categoriasCenso
     */
    public function addCategoriaCenso(\MinSal\SidPla\CensoBundle\Entity\CategoriaCenso $categoriasCenso)
    {
        $this->categoriasCenso[] = $categoriasCenso;
    }

    /**
     * Add poblacionHumana
     *
     * @param MinSal\SidPla\CensoBundle\Entity\PoblacionHumana $poblacionHumana
     */
    public function addPoblacionHumana(\MinSal\SidPla\CensoBundle\Entity\PoblacionHumana $poblacionHumana)
    {
        $this->poblacionHumana[] = $poblacionHumana;
    }

    /**
     * Get poblacionHumana
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPoblacionHumana()
    {
        return $this->poblacionHumana;
    }
}