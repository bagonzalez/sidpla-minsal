<?php
namespace MinSal\SidPla\GesObjEspBundle\EntityDao;

use MinSal\SidPla\GesObjEspBundle\Entity\Resultadore;
use Doctrine\ORM\Query\ResultSetMapping;
class ResultadoreDao {
    //put your code here

    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaGesObjEspBundle:Resultadore');
    } 
    
    public function getResultadore($id) {	    
        $ResultEsp=$this->repositorio->find($id);
        return $ResultEsp;
    }
    
    public function delResultadore($id){            

        $Res=$this->repositorio->find($id);

        if(!$Res){
            throw $this->createNotFoundException('No se encontro registro con ese id '.$id);
        }

        $this->em->remove($Res);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar termino con exito');

        return $matrizMensajes;
    }
    
     public function editresultadore($trim,$id){
         
         $objResultadore=new Resultadore();
         $objResultadore=$this->repositorio->find($id);
         $objResultadore->setResultadoreProgramado($trim);                         
        
         $this->em->flush();            
         $matrizMensajes = array('El proceso de editar termino con exito');
 
         return $matrizMensajes;
    }
    
    public function hayResultadosRe($idResEsp) {

        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('resp', 'resp');
        $query = $this->em->createNativeQuery('SELECT count(*) resp
                                                FROM sidpla_resultadore
                                                WHERE resesp_codigo = ?', $rsm);
        $query->setParameter(1, $idResEsp);

        $x = $query->getSingleScalarResult();
        return $x;
    }
    
}

?>
