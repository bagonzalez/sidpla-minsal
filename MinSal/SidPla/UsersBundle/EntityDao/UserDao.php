<?php

namespace MinSal\SidPla\UsersBundle\EntityDao;

use Doctrine\ORM\Query\ResultSetMapping;
use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\EntityDao\RolDao;
use MinSal\SidPla\AdminBundle\Entity\RolSistema;

class UserDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaUsersBundle:User');
    }

    public function getUserSinRol() {
        $User = $this->em->createQuery("SELECT U
                                        FROM MinSalSidPlaUsersBundle:User U
                                        WHERE U.rol IS NULL");
        return $User->getResult();
    }

    public function getUserEspecifico($codigo) {
        $usuario = $this->repositorio->find($codigo);
        ;
        return $usuario;
    }

    public function editUserSinRol($codigoUser, $idRol) {

        $user = $this->getUserEspecifico($codigoUser);

        $rolDao = new RolDao($this->doctrine);
        $rol = $rolDao->getRolEspecifico($idRol);

        $user->setRol($rol);
        $this->em->persist($user);
        $this->em->flush();
        $matrizMensajes = $codigoUser;

        return $matrizMensajes;
    }

    public function tieneOtroUsuario($idEmpleado) {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('resp', 'resp');
        $query = $this->em->createNativeQuery('SELECT count (* )resp 
                                               FROM sidpla_usuario
                                               WHERE sidpla_usuario.empleado_codigo=?', $rsm);
        $query->setParameter(1, $idEmpleado);

        $x = $query->getResult();

        return $x[0]['resp'];
    }

    public function usernameDisponible($username) {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('resp', 'resp');
        $query = $this->em->createNativeQuery("SELECT count (*)resp 
                                               FROM sidpla_usuario
                                               WHERE username =?", $rsm);
        $query->setParameter(1, $username);

        $x = $query->getResult();

        return $x[0]['resp'];
    }

}

?>
