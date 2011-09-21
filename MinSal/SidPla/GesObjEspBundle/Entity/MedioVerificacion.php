<?php

namespace MinSal\SidPla\GesObjEspBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\GesObjEspBundle\Entity\MedioVerificacion
 *
 * @ORM\Table(name="sidpla_tipomedioverificacion")
 * @ORM\Entity
 */
class MedioVerificacion
{
    /**
     * @var integer $idMedVerf
     *
     * @ORM\Column(name="tipmedver_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idMedVerf;

    /**
     * @ORM\ManyToOne(targetEntity="ResultadoEsperado", inversedBy="medioVerificacion")
     * @ORM\JoinColumn(name="resesp_codigo", referencedColumnName="resesp_codigo")
     */
    private $idResulEspe;

    /**
     * @var string $medVerfDescricion
     *
     * @ORM\Column(name="tipmedver_descripcion", type="string", length=150)
     */
    private $medVerfDescricion;


    /**
     * Set idMedVerf
     *
     * @param integer $idMedVerf
     */
    public function setIdMedVerf($idMedVerf)
    {
        $this->idMedVerf = $idMedVerf;
    }

    /**
     * Get idMedVerf
     *
     * @return integer 
     */
    public function getIdMedVerf()
    {
        return $this->idMedVerf;
    }

    /**
     * Set idResulEspe
     *
     * @param MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado $idResulEspe
     */
    public function setIdResulEspe(\MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado $idResulEspe)
    {
        $this->idResulEspe = $idResulEspe;
    }

    /**
     * Get idResulEspe
     *
     * @return MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado 
     */
    public function getIdResulEspe()
    {
        return $this->idResulEspe;
    }

    /**
     * Set medVerfDescricion
     *
     * @param string $medVerfDescricion
     */
    public function setMedVerfDescricion($medVerfDescricion)
    {
        $this->medVerfDescricion = $medVerfDescricion;
    }

    /**
     * Get medVerfDescricion
     *
     * @return string 
     */
    public function getMedVerfDescricion()
    {
        return $this->medVerfDescricion;
    }
}