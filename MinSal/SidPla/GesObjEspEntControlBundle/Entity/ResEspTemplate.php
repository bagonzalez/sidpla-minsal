<?php

namespace MinSal\SidPla\GesObjEspEntControlBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\GesObjEspEntControlBundle\Entity\ResEspTemplate
 *
 * @ORM\Table(name="sidpla_resespetemplate")
 * @ORM\Entity
 */
class ResEspTemplate
{
    /**
     * @var integer $idResEspTempl
     *
     * @ORM\Column(name="restmp_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idResEspTempl;

    

    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjespTemplate", inversedBy="resultadostemplate", cascade={"remove"})
     * @ORM\JoinColumn(name="objtmp_codigo", referencedColumnName="objtmp_codigo")
     */
    private $idObjEspecTempl;

    /**
     * @var string $resEspTemplIndicador
     *
     * @ORM\Column(name="restmp_indicador", type="string", length=150)
     */
    private $resEspTemplIndicador;

    /**
     * @var string $resEspTemplDescripcion
     *
     * @ORM\Column(name="restmp_descripcion", type="string", length=200)
     */
    private $resEspTemplDescripcion;

    /**
     * @var string $resEspTemplNomencla
     *
     * @ORM\Column(name="restmp_nomenclatura", type="string", length=15)
     */
    private $resEspTemplNomencla;


    
    /**
     * Set idResEspTempl
     *
     * @param integer $idResEspTempl
     */
    public function setIdResEspTempl($idResEspTempl)
    {
        $this->idResEspTempl = $idResEspTempl;
    }

    /**
     * Get idResEspTempl
     *
     * @return integer 
     */
    public function getIdResEspTempl()
    {
        return $this->idResEspTempl;
    }

    /**
     * Set idObjEspecTempl
     *
     * @param MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjespTemplate $idObjEspecTempl
     */
    public function setIdObjEspecTempl(\MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjespTemplate$idObjEspecTempl)
    {
        $this->idObjEspecTempl = $idObjEspecTempl;
    }

    /**
     * Get idObjEspecTempl
     *
     * @return MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjespTemplate
     */
    public function getIdObjEspecTempl()
    {
        return $this->idObjEspecTempl;
    }

    /**
     * Set resEspTemplIndicador
     *
     * @param string $resEspTemplIndicador
     */
    public function setResEspTemplIndicador($resEspTemplIndicador)
    {
        $this->resEspTemplIndicador = $resEspTemplIndicador;
    }

    /**
     * Get resEspTemplIndicador
     *
     * @return string 
     */
    public function getResEspTemplIndicador()
    {
        return $this->resEspTemplIndicador;
    }

    /**
     * Set resEspTemplDescripcion
     *
     * @param string $resEspTemplDescripcion
     */
    public function setResEspTemplDescripcion($resEspTemplDescripcion)
    {
        $this->resEspTemplDescripcion = $resEspTemplDescripcion;
    }

    /**
     * Get resEspTemplDescripcion
     *
     * @return string 
     */
    public function getResEspTemplDescripcion()
    {
        return $this->resEspTemplDescripcion;
    }

    /**
     * Set resEspTemplNomencla
     *
     * @param string $resEspTemplNomencla
     */
    public function setResEspTemplNomencla($resEspTemplNomencla)
    {
        $this->resEspTemplNomencla = $resEspTemplNomencla;
    }

    /**
     * Get resEspTemplNomencla
     *
     * @return string 
     */
    public function getResEspTemplNomencla()
    {
        return $this->resEspTemplNomencla;
    }   
}