<?php

namespace MinSal\SidPla\UsersBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sidpla_usuario")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(name="usuario_codigo", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idUsuario;

    /**
     * @ORM\OneToOne(targetEntity="MinSal\SidPla\AdminBundle\Entity\Empleado", mappedBy="usuario",orphanRemoval=true)
     * @ORM\JoinColumn(name="empleado_codigo", referencedColumnName="empleado_codigo")
     */
    private $empleado;

    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\AdminBundle\Entity\RolSistema", inversedBy="usuarios")
     * @ORM\JoinColumn(name="rol_codigo", referencedColumnName="rol_codigo")
     */
    protected $rol;

    /**
     * @var integer $idEmpleado
     *
     * @ORM\Column(name="empleado_codigo", type="integer")
     */
    private $idEmpleado;

    public function __construct() {
        parent::__construct();
        // your own logic
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getIdUsuario() {
        return $this->idUsuario;
    }

    /**
     * Set idEmpleado
     *
     * @param integer $idEmpleado
     */
    public function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }

    /**
     * Get idEmpleado
     *
     * @return integer
     */
    public function getidEmpleado() {
        return $this->idEmpleado;
    }

    /**
     * Set empleado
     *
     * @param MinSal\SidPla\UsersBundle\Entity\Empleado $empleado
     */
    public function setEmpleado(\MinSal\SidPla\AdminBundle\Entity\Empleado $empleado) {
        $this->empleado = $empleado;
    }

    /**
     * Get empleado
     *
     * @return MinSal\SidPla\UsersBundle\Entity\Empleado 
     */
    public function getEmpleado() {
        return $this->empleado;
    }

    /**
     * Set rol
     *
     * @param MinSal\SidPla\AdminBundle\Entity\RolSistema $rol
     */
    public function setRol(\MinSal\SidPla\AdminBundle\Entity\RolSistema $rol) {
        $this->rol = $rol;
    }

    /**
     * Get rol
     *
     * @return MinSal\SidPla\AdminBundle\Entity\RolSistema 
     */
    public function getRol() {
        return $this->rol;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername() {
        return $this->username;
    }

}