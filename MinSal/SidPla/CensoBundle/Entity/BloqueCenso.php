<?php

namespace MinSal\SidPla\CensoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\CensoBundle\Entity\BloqueCenso
 *
 * @ORM\Table(name="sidpla_bloquecenso")
 * @ORM\Entity
 */
class BloqueCenso
{
    /**
     * @var integer $bloquecenso_codigo
     *
     * @ORM\Column(name="bloquecenso_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $bloquecenso_codigo;

    /**
     * @var string $bloquecenso_nombrebloque
     *
     * @ORM\Column(name="bloquecenso_nombrebloque", type="string", length=150)
     */
    private $bloquecenso_nombrebloque;

    /**
     * @var integer $bloquecenso_orden
     *
     * @ORM\Column(name="bloquecenso_orden", type="integer")
     */
    private $bloquecenso_orden;


    /**
     * Get bloquecenso_codigo
     *
     * @return integer 
     */
    public function getBloqueCenso_Codigo()
    {
        return $this->bloquecenso_codigo;
    }

     /**
     * Set bloquecenso_nombrebloque
     *
     * @param string $BloqueCenso_NombreBloque
     */
    public function setBloqueCenso_NombreBloque($BloqueCenso_NombreBloque)
    {
        $this->bloquecenso_nombrebloque = $BloqueCenso_NombreBloque;
    }

    /**
     * Get bloquecenso_nombrebloque
     *
     * @return string 
     */
    public function getBloqueCenso_NombreBloque()
    {
        return $this->bloquecenso_nombrebloque;
    }

    /**
     * Set bloquecenso_orden
     *
     * @param integer $BloqueCenso_Orden
     */
    public function setBloqueCenso_Orden($BloqueCenso_Orden)
    {
        $this->bloquecenso_orden = $BloqueCenso_Orden;
    }

    /**
     * bloquecenso_orden
     *
     * @return integer 
     */
    public function getBloqueCenso_Orden()
    {
        return $this->bloquecenso_orden;
    }
}