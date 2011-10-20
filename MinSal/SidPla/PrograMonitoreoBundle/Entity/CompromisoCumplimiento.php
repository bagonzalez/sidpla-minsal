<?php

namespace MinSal\SidPla\PrograMonitoreoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\PrograMonitoreoBundle\Entity\CompromisoCumplimiento
 *
 * @ORM\Table(name="sidpla_compromisocumplimiento")
 * @ORM\Entity
 */
class CompromisoCumplimiento
{
    /**
     * @var integer $idComproCumpl
     *
     * @ORM\Column(name="comcum_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idComproCumpl;

   
     /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\GesObjEspBundle\Entity\ResulActividad", inversedBy="compromisocumplimiento")
     * @ORM\JoinColumn(name="resact_codigo", referencedColumnName="resact_codigo")
     */
    private $idResActividad;
    
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\GesObjEspBundle\Entity\Resultadore", inversedBy="compromisocumplimiento")
     * @ORM\JoinColumn(name="resultadore_codigo", referencedColumnName="resultadore_codigo")
     */
    private $idResultadore;

    
    /**
     * @var string $comproCumpliHallazgozEncontrados
     *
     * @ORM\Column(name="comcum_hallazgosencontrados", type="string", length=300)
     */
    private $comproCumpliHallazgozEncontrados;

    /**
     * @var string $comproCumpliResponsable
     *
     * @ORM\Column(name="comcum_responsable", type="string", length=60)
     */
    private $comproCumpliResponsable;

    /**
     * @var string $comproCumpliMedidaAdoptar
     *
     * @ORM\Column(name="comcum_medidaadoptar", type="string", length=300)
     */
    private $comproCumpliMedidaAdoptar;

    /**
     * @var date $comproCumpliFecha
     *
     * @ORM\Column(name="comcum_fecha", type="date")
     */
    private $comproCumpliFecha;
    
    
    /**
     * Set idComproCumpl
     *
     * @param integer $idComproCumpl
     */
    public function setIdComproCumpl($idComproCumpl)
    {
        $this->idComproCumpl = $idComproCumpl;
    }

    /**
     * Get idComproCumpl
     *
     * @return integer 
     */
    public function getIdComproCumpl()
    {
        return $this->idComproCumpl;
    }
    
    

    /**
     * Set comproCumpliHallazgozEncontrados
     *
     * @param string $comproCumpliHallazgozEncontrados
     */
    public function setComproCumpliHallazgozEncontrados($comproCumpliHallazgozEncontrados)
    {
        $this->comproCumpliHallazgozEncontrados = $comproCumpliHallazgozEncontrados;
    }

    /**
     * Get comproCumpliHallazgozEncontrados
     *
     * @return string 
     */
    public function getComproCumpliHallazgozEncontrados()
    {
        return $this->comproCumpliHallazgozEncontrados;
    }

    /**
     * Set comproCumpliResponsable
     *
     * @param string $comproCumpliResponsable
     */
    public function setComproCumpliResponsable($comproCumpliResponsable)
    {
        $this->comproCumpliResponsable = $comproCumpliResponsable;
    }

    /**
     * Get comproCumpliResponsable
     *
     * @return string 
     */
    public function getComproCumpliResponsable()
    {
        return $this->comproCumpliResponsable;
    }

    /**
     * Set comproCumpliMedidaAdoptar
     *
     * @param string $comproCumpliMedidaAdoptar
     */
    public function setComproCumpliMedidaAdoptar($comproCumpliMedidaAdoptar)
    {
        $this->comproCumpliMedidaAdoptar = $comproCumpliMedidaAdoptar;
    }

    /**
     * Get comproCumpliMedidaAdoptar
     *
     * @return string 
     */
    public function getComproCumpliMedidaAdoptar()
    {
        return $this->comproCumpliMedidaAdoptar;
    }

    /**
     * Set comproCumpliFecha
     *
     * @param date $comproCumpliFecha
     */
    public function setComproCumpliFecha($comproCumpliFecha)
    { $date = new \DateTime($comproCumpliFecha);
        $this->comproCumpliFecha = $date;
        
    }

    /**
     * Get comproCumpliFecha
     *
     * @return date 
     */
    public function getComproCumpliFecha()
    {
        return $this->comproCumpliFecha;
    }
    
    
    /**
     * Set idResActividad
     *
     * @param integer $idResActividad
     */
    public function setIdResActividad($idResActividad)
    {
        $this->idResActividad = $idResActividad;
    }

    /**
     * Get idResActividad
     *
     * @return integer 
     */
    public function getIdResActividad()
    {
        return $this->idResActividad;
    }
    
     /**
     * Set idResultadore
     *
     * @param integer $idResultadore
     */
    public function setIdResultadore($idResultadore)
    {
        $this->idResultadore = $idResultadore;
    }

    /**
     * Get idResultadore
     *
     * @return integer 
     */
    public function getIdResultadore()
    {
        return $this->idResultadore;
    }
    
    
}