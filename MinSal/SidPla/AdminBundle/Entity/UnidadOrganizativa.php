<?php

namespace MinSal\SidPla\AdminBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa
 *
 * @ORM\Table(name="sidpla_unidadorganizativa")
 * @ORM\Entity
 */
class UnidadOrganizativa {
    
    /**
     * @var integer $idUnidadOrg
     *
     * @ORM\Column(name="uniorg_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
     private $idUnidadOrg;
     
     
     /**
     * @var string $nombreUnidad
     *
     * @ORM\Column(name="uniorg_nombre", type="string", length=150)
     */
     private $nombreUnidad;    
     
     
     /**
     * @var string $descripcionUnidad
     *
     * @ORM\Column(name="uniorg_descripcion", type="string", length=200)
     */
     private $descripcionUnidad;
     
     /**
     * @var string $tipoUnidad
     *
     * @ORM\Column(name="uniorg_tipounidad", type="string", length=15)
     */
     private $tipoUnidad;
     
     
     /**
     * @var integer $idUnidadOrgPadre
     *
     * @ORM\Column(name="uniorg_codigo1", type="integer")
     */
     private $idUnidadOrgPadre;
     
     /**
     * @var integer $idMunicipio
     *
     * @ORM\Column(name="muni_codigo", type="integer")
     */
     private $idMunicipio;     
     
     
     /**
     * Get idUnidadOrg
     *
     * @return integer 
     */
    public function getIdUnidadOrg()
    {
        return $this->idUnidadOrg;
    }
    
    public function getNombreUnidad()
    {
        return $this->nombreUnidad;
    }
    
    public function setNombreUnidad($nombreUnidad)
    {
        $this->nombreUnidad = $nombreUnidad;
    }
    
    public function getDescripcionUnidad()
    {
        return $this->descripcionUnidad;
    }
    
    public function setDescripcionUnidad($descripcionUnidad)
    {
        $this->descripcionUnidad = $descripcionUnidad;
    }
    
    public function getTipoUnidad()
    {
        return $this->tipoUnidad;
    }
    
     public function setTipoUnidad($tipoUnidad)
    {
        $this->tipoUnidad = $tipoUnidad;
    }
    
    public function getIdUnidadOrgPadre()
    {
        return $this->idUnidadOrgPadre;
    }
    
    public function setIdUnidadOrgPadre($idUnidadOrgPadre)
    {
        $this->idUnidadOrgPadre = $idUnidadOrgPadre;
    }
    
    public function getIdMunicipio()
    {
        return $this->idMunicipio;
    }
    
    public function setIdMunicipio($idMunicipio)
    {
        $this->idMunicipio = $idMunicipio;
    }
   
}

?>
