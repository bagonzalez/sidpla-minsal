<?php

namespace MinSal\SidPla\AdminBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\AdminBundle\Entity\MensajeCorreTemp
 *
 * @ORM\Table(name="sidpla_mensajecorreotemplate")
 * @ORM\Entity
 */
class MensajeCorreTemp {
   
    /**
     * @var integer $mencortem_codigo
     *
     * @ORM\Column(name="mencortem_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $mencortem_codigo;

    /**
     * @var text $mencortem_texto
     *
     * @ORM\Column(name="mencortem_texto", type="string", length=200)
     */
    private $mencortem_texto;

    /**
     * @var string $mencortem_nombre
     *
     * @ORM\Column(name="mencortem_nombre", type="string", length=10)
     */
    private $mencortem_nombre;

   
    /**
     * Get mencortem_codigo
     *
     * @return integer 
     */
    public function getMencortemCodigo()
    {
        return $this->mencortem_codigo;
    }

    /**
     * Set mencortem_texto
     *
     * @param text $mencortemTexto
     */
    public function setMencortemTexto($mencortemTexto)
    {
        $this->mencortem_texto = $mencortemTexto;
    }

    /**
     * Get mencortem_texto
     *
     * @return text 
     */
    public function getMencortemTexto()
    {
        return $this->mencortem_texto;
    }

    /**
     * Set mencortem_nombre
     *
     * @param string $mencortemNombre
     */
    public function setMencortemNombre($mencortemNombre)
    {
        $this->mencortem_nombre = $mencortemNombre;
    }

    /**
     * Get mencortem_nombre
     *
     * @return string 
     */
    public function getMencortemNombre()
    {
        return $this->mencortem_nombre;
    }
}