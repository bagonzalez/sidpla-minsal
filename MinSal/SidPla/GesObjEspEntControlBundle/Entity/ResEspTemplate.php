<?php

namespace MinSal\SidPla\GesObjEspEntControlBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\GesObjEspEntControlBundle\Entity\ResEspTemplate
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ResEspTemplate
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer $idResEspTempl
     *
     * @ORM\Column(name="idResEspTempl", type="integer")
     */
    private $idResEspTempl;

    /**
     * @var integer $idObjEspecTempl
     *
     * @ORM\Column(name="idObjEspecTempl", type="integer")
     */
    private $idObjEspecTempl;

    /**
     * @var string $resEspTemplIndicador
     *
     * @ORM\Column(name="resEspTemplIndicador", type="string", length=150)
     */
    private $resEspTemplIndicador;

    /**
     * @var string $resEspTemplDescripcion
     *
     * @ORM\Column(name="resEspTemplDescripcion", type="string", length=200)
     */
    private $resEspTemplDescripcion;

    /**
     * @var string $resEspTemplNomencla
     *
     * @ORM\Column(name="resEspTemplNomencla", type="string", length=15)
     */
    private $resEspTemplNomencla;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

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
     * @param integer $idObjEspecTempl
     */
    public function setIdObjEspecTempl($idObjEspecTempl)
    {
        $this->idObjEspecTempl = $idObjEspecTempl;
    }

    /**
     * Get idObjEspecTempl
     *
     * @return integer 
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