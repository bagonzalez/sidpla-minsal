<?php

namespace MinSal\SidPla\GesObjEspEntControlBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjespTemplate
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ObjespTemplate
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
     * @var integer $idObjEspTempl
     *
     * @ORM\Column(name="idObjEspTempl", type="integer")
     */
    private $idObjEspTempl;

    /**
     * @var integer $idObjEspec
     *
     * @ORM\Column(name="idObjEspec", type="integer")
     */
    private $idObjEspec;

    /**
     * @var integer $idObjTemplate
     *
     * @ORM\Column(name="idObjTemplate", type="integer")
     */
    private $idObjTemplate;


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
     * Set idObjEspTempl
     *
     * @param integer $idObjEspTempl
     */
    public function setIdObjEspTempl($idObjEspTempl)
    {
        $this->idObjEspTempl = $idObjEspTempl;
    }

    /**
     * Get idObjEspTempl
     *
     * @return integer 
     */
    public function getIdObjEspTempl()
    {
        return $this->idObjEspTempl;
    }

    /**
     * Set idObjEspec
     *
     * @param integer $idObjEspec
     */
    public function setIdObjEspec($idObjEspec)
    {
        $this->idObjEspec = $idObjEspec;
    }

    /**
     * Get idObjEspec
     *
     * @return integer 
     */
    public function getIdObjEspec()
    {
        return $this->idObjEspec;
    }

    /**
     * Set idObjTemplate
     *
     * @param integer $idObjTemplate
     */
    public function setIdObjTemplate($idObjTemplate)
    {
        $this->idObjTemplate = $idObjTemplate;
    }

    /**
     * Get idObjTemplate
     *
     * @return integer 
     */
    public function getIdObjTemplate()
    {
        return $this->idObjTemplate;
    }
}