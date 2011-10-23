<?php

namespace MinSal\SidPla\UsersBundle\EntityDao;

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

    public function getUser() {
        $User = $this->em->createQuery("SELECT U
                                        FROM MinSalSidPlaUsersBundle:User U
                                        WHERE U.rol IS NULL
                                        ");
        return $User->getResult();
    }

    public function getUserEspecifico($codigo) {
        $usuario = $this->repositorio->find($codigo);
        ;
        return $usuario;
    }

    public function editUserSinRol($codigoUser, $idRol) {
        
        $user=  $this->getUserEspecifico($codigoUser);
        
        $rolDao=new RolDao($this->doctrine);
        $rol=$rolDao->getRolEspecifico($idRol);
        
        $user->setRol($rol);
        $this->em->persist($user);
        $this->em->flush();
        $matrizMensajes = $codigoUser;

        return $matrizMensajes;
    }

}

?>
