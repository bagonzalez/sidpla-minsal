<?php
namespace MinSal\SidPla\UsersBundle\EntityDao;

use MinSal\SidPla\UsersBundle\Entity\User;

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
                                        ");
        return $User->getResult();
    }
}

?>
