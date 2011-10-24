<?php

namespace MinSal\SidPla\GesObjEspEntControlBundle\EntityDao;

use Doctrine\ORM\Query\ResultSetMapping;
use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ResEspTemplate;

class ResEspTemplateDao {

    //put your code here
    var $doctrine;
    var $repositorio;
    var $em;

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaGesObjEspEntControlBundle:ResEspTemplate');
    }

    public function getResultadoTemplate($id) {
        $resultadotemplate = $this->repositorio->find($id);
        return $resultadotemplate;
    }

    public function editResulEspTemplate($resEspeDesc, $resEspNomencl, $resEspIndicador, $idobjetivo, $id) {


        $objResulesperado = new ResEspTemplate();
        $objResulesperado = $this->repositorio->find($id);
        $objResulesperado->setResEspTemplDescripcion($resEspeDesc);
        //$objResulesperado->setResEspNomencl($resEspNomencl);                         
        $objResulesperado->setResEspTemplIndicador($resEspIndicador);


        $this->em->flush();
        $matrizMensajes = array('El proceso de editar termino con exito');

        return $matrizMensajes;
    }

    public function delResultadoEsperadotemplate($id) {

        $obj = $this->repositorio->find($id);

        if (!$obj) {
            throw $this->createNotFoundException('No se encontro registro con ese id ' . $id);
        }

        $this->em->remove($obj);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar termino con exito');

        return $matrizMensajes;
    }

    public function cuantosResulDefinidas($anio) {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('cuanto', 'cuanto');
        $query = $this->em->createNativeQuery("SELECT count(*) cuanto
                                               FROM sidpla_objtemplate, 
                                                    sidpla_objespectemplate, 
                                                    sidpla_resespetemplate
                                               WHERE sidpla_objtemplate.objtmp_codigo = sidpla_objespectemplate.objtmp_codigo AND
                                                     sidpla_objespectemplate.objespectmp_codigo = sidpla_resespetemplate.objespectmp_codigo AND
                                                     sidpla_objtemplate.objtmp_anio = ?", $rsm);
        $query->setParameter(1, $anio);

        $x = $query->getResult();

        return $x[0]['cuanto'];
    }

}

?>
