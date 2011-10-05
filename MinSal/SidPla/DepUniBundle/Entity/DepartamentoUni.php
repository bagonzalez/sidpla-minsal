<?php

namespace MinSal\SidPla\DepUniBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\DepUniBundle\Entity\DepartamentoUni
 *
 * @ORM\Table(name="sidpla_departamentounidad")
 * @ORM\Entity
 */
class DepartamentoUni {

    /**
     * @var integer $codDeptoUnidad
     *
     * @ORM\Column(name="depuni_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codDeptoUnidad;

    /**
     * @var string $nombreDepto
     *
     * @ORM\Column(name="depuni_nombre", type="string", length=100)
     */
    private $nombreDepto;

    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa", inversedBy="departUnidades")
     * @ORM\JoinColumn(name="uniorg_codigo", referencedColumnName="uniorg_codigo")
     */
    private $uniOrgDep;

    /**
     * @ORM\OneToMany(targetEntity="RecursoHumano", mappedBy="deptoUnidadRRHH")
     */
    private $rrHHs;



    public function __construct()
    {
        $this->rrHHs = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get codDeptoUnidad
     *
     * @return integer 
     */
    public function getCodDeptoUnidad()
    {
        return $this->codDeptoUnidad;
    }

    /**
     * Set nombreDepto
     *
     * @param string $nombreDepto
     */
    public function setNombreDepto($nombreDepto)
    {
        $this->nombreDepto = $nombreDepto;
    }

    /**
     * Get nombreDepto
     *
     * @return string 
     */
    public function getNombreDepto()
    {
        return $this->nombreDepto;
    }

    /**
     * Set uniOrgDep
     *
     * @param MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa $uniOrgDep
     */
    public function setUniOrgDep(\MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa $uniOrgDep)
    {
        $this->uniOrgDep = $uniOrgDep;
    }

    /**
     * Get uniOrgDep
     *
     * @return MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa
     */
    public function getUniOrgDep()
    {
        return $this->uniOrgDep;
    }

    /**
     * Add rrHHs
     *
     * @param MinSal\SidPla\DepUniBundle\Entity\RecursoHumano $rrHHs
     */
    public function addRrHHs(\MinSal\SidPla\DepUniBundle\Entity\RecursoHumano $rrHHs)
    {
        $this->rrHHs[] = $rrHHs;
    }

    /**
     * Get rrHHs
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRrHHs()
    {
        return $this->rrHHs;
    }
}