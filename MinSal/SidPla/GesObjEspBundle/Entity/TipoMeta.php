<?php

namespace MinSal\SidPla\GesObjEspBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * MinSal\SidPla\GesObjEspBundle\Entity\TipoMeta
 *
 * @ORM\Table(name="sidpla_tipometa")
 * @ORM\Entity
 */
class TipoMeta
{
    /**
     * @var integer $idTipoMeta
     *
     * @ORM\Column(name="tipometa_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idTipoMeta;

    /**
     * @var string $tipoMetaNombre
     *
     * @ORM\Column(name="tipometa_nombre", type="string", length=30)
     */
    private $tipoMetaNombre;

    /**
     * Set idTipoMeta
     *
     * @param integer $idTipoMeta
     */
    public function setIdTipoMeta($idTipoMeta)
    {
        $this->idTipoMeta = $idTipoMeta;
    }

    /**
     * Get idTipoMeta
     *
     * @return integer 
     */
    public function getIdTipoMeta()
    {
        return $this->idTipoMeta;
    }

    /**
     * Set tipoMetaNombre
     *
     * @param string $tipoMetaNombre
     */
    public function setTipoMetaNombre($tipoMetaNombre)
    {
        $this->tipoMetaNombre = $tipoMetaNombre;
    }

    /**
     * Get tipoMetaNombre
     *
     * @return string 
     */
    public function getTipoMetaNombre()
    {
        return $this->tipoMetaNombre;
    }
    
      
    
}