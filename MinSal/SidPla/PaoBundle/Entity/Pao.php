<?php

namespace MinSal\SidPla\PaoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\PaoBundle\Entity\Pao
 *
 * @ORM\Table(name="sidpla_pao")
 * @ORM\Entity
 */
class Pao
{
    /**
     * @var integer $idPao
     *
     * @ORM\Column(name="idPao", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idPao;

    
    /**
     * @var integer $anio
     *
     * @ORM\Column(name="anio", type="integer")
     */
    private $anio;
    
    
     /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa", inversedBy="paos")
     * @ORM\JoinColumn(name="uniorg_codigo", referencedColumnName="uniorg_codigo")
     */
    protected $unidadOrganizativa;



    /**
     * Set idPao
     *
     * @param integer $idPao
     */
    public function setIdPao($idPao)
    {
        $this->idPao = $idPao;
    }

    /**
     * Get idPao
     *
     * @return integer 
     */
    public function getIdPao()
    {
        return $this->idPao;
    }

    /**
     * Set anio
     *
     * @param integer $anio
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;
    }

    /**
     * Get anio
     *
     * @return integer 
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set unidadOrganizativa
     *
     * @param MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa $unidadOrganizativa
     */
    public function setUnidadOrganizativa(\MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa $unidadOrganizativa)
    {
        $this->unidadOrganizativa = $unidadOrganizativa;
    }

    /**
     * Get unidadOrganizativa
     *
     * @return MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa 
     */
    public function getUnidadOrganizativa()
    {
        return $this->unidadOrganizativa;
    }
}