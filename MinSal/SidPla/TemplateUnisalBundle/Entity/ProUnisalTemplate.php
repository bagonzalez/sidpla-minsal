<?php

namespace MinSal\SidPla\TemplateUnisalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\TemplateUnisalBundle\Entity\ProUnisalTemplate
 *
 * @ORM\Table(name="sidpla_prounisaltemplate")
 * @ORM\Entity
 */
class ProUnisalTemplate {

    /**
     * @var integer $codProUniTem
     * 
     * @ORM\Column(name="prounitem_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codProUniTem;

    /**
     * @var bigint $anioProUniTem
     *
     * @ORM\Column(name="prounitem_anio", type="bigint")
     */
    private $anioProUniTem;

    /**
     * @ORM\OneToMany(targetEntity="ObjetivoEspeUnisal", mappedBy="prograMonObj")
     */
    private $objeEspeProgra;
    
    

    public function __construct()
    {
        $this->objeEspeProgra = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get codProUniTem
     *
     * @return integer 
     */
    public function getCodProUniTem()
    {
        return $this->codProUniTem;
    }

    /**
     * Set anioProUniTem
     *
     * @param bigint $anioProUniTem
     */
    public function setAnioProUniTem($anioProUniTem)
    {
        $this->anioProUniTem = $anioProUniTem;
    }

    /**
     * Get anioProUniTem
     *
     * @return bigint 
     */
    public function getAnioProUniTem()
    {
        return $this->anioProUniTem;
    }

    /**
     * Add objeEspeProgra
     *
     * @param MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal $objeEspeProgra
     */
    public function addObjeEspeProgra(\MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal $objeEspeProgra)
    {
        $this->objeEspeProgra[] = $objeEspeProgra;
    }

    /**
     * Get objeEspeProgra
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getObjeEspeProgra()
    {
        return $this->objeEspeProgra;
    }
}