<?php

namespace MinSal\SidPla\UnidadOrgBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\UnidadOrgBundle\Entity\FuncionEspecifica
 *
 * @ORM\Table(name="sidpla_funcionespecifica")
 * @ORM\Entity
 */
class FuncionEspecifica
{
    /**
     * @var integer $idFuncEspec
     *
     * @ORM\Column(name="funesp_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idFuncEspec;

    /**
     * @var text $funcDescripcion
     *
     * @ORM\Column(name="funesp_descripcion", type="text")
     */
    private $funcDescripcion;
    
    /**
     * @ORM\ManyToOne(targetEntity="CaractOrg", inversedBy="funcionesEspec")
     * @ORM\JoinColumn(name="carorg_codigo", referencedColumnName="carorg_codigo")
     */
    protected $caractOrg;


    /**
     * Set idFuncEspec
     *
     * @param integer $idFuncEspec
     */
    public function setIdFuncEspec($idFuncEspec)
    {
        $this->idFuncEspec = $idFuncEspec;
    }

    /**
     * Get idFuncEspec
     *
     * @return integer 
     */
    public function getIdFuncEspec()
    {
        return $this->idFuncEspec;
    }

    /**
     * Set funcDescripcion
     *
     * @param text $funcDescripcion
     */
    public function setFuncDescripcion($funcDescripcion)
    {
        $this->funcDescripcion = $funcDescripcion;
    }

    /**
     * Get funcDescripcion
     *
     * @return text 
     */
    public function getFuncDescripcion()
    {
        return $this->funcDescripcion;
    }

    /**
     * Set caractOrg
     *
     * @param MinSal\SidPla\UnidadOrgBundle\Entity\CaractOrg $caractOrg
     */
    public function setCaractOrg(\MinSal\SidPla\UnidadOrgBundle\Entity\CaractOrg $caractOrg)
    {
        $this->caractOrg = $caractOrg;
    }

    /**
     * Get caractOrg
     *
     * @return MinSal\SidPla\UnidadOrgBundle\Entity\CaractOrg 
     */
    public function getCaractOrg()
    {
        return $this->caractOrg;
    }
}