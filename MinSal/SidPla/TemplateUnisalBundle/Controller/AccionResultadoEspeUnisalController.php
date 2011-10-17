<?php

namespace MinSal\SidPla\TemplateUnisalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

use MinSal\SidPla\TemplateUnisalBundle\EntityDao\ResultadoEspeUnisalDao;
use MinSal\SidPla\TemplateUnisalBundle\Entity\ResultadoEspeUnisal;

use MinSal\SidPla\TemplateUnisalBundle\EntityDao\ObjetivoEspeUnisalDao;
use MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal;


class AccionResultadoEspeUnisalController extends Controller {

    public function mostrarResEspeUnisalAction() {
        
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $idObj = $request->get('idObj');

        $objEspUniDao = new ObjetivoEspeUnisalDao($this->getDoctrine());
       
        $objEspUni = $objEspUniDao->getObjetivoEspeUnisalEspecifico($idObj);
        $decObjEsp=$objEspUni->getDescObjEspUni();
                
        $resulEspUnisal=$objEspUni->getResultEspObjT();
        
        if (count($resulEspUnisal)!=0)
            return $this->render('MinSalSidPlaTemplateUnisalBundle:ResultadoEspeUnisal:manttResultadoEspeUnisal.html.twig', 
                    array('opciones' => $opciones, 'descObj' => $decObjEsp, 'idObj' => $idObj,'resultadosUnisal'=>$resulEspUnisal));
        else
            return $this->render('MinSalSidPlaTemplateUnisalBundle:ResultadoEspeUnisal:manttResultadoEspeUnisal.html.twig', 
                    array('opciones' => $opciones, 'descObj' => $decObjEsp, 'idObj' => $idObj));
    }

    public function ingresarResEspeUnisalAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $idObj = $request->get('idObj');
        $descObj = $request->get('objEspTmp');

        return $this->render('MinSalSidPlaTemplateUnisalBundle:ResultadoEspeUnisal:gestionResultadoEspeUnisal.html.twig', 
                array('opciones' => $opciones, 'idObj'=>$idObj,'descObj'=>$descObj));
    }
    
   public function editarResEspeUnisalAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        
        $request = $this->getRequest();
        $idObj = $request->get('idObj');
        $descObj = $request->get('objEspTmp');
        
        $idResEspeUnisal = $request->get('idResEsp');
        
        $resultadoEsperadoUnisalDao=new ResultadoEspeUnisalDao($this->getDoctrine());
        
        $resultadoEsperadoUnisal=$resultadoEsperadoUnisalDao->getResultadoEspeUnisalEspecifico($idResEspeUnisal);
        $descResEsp=$resultadoEsperadoUnisal->getDescResEspUni();

        return $this->render('MinSalSidPlaTemplateUnisalBundle:ResultadoEspeUnisal:gestionResultadoEspeUnisal.html.twig', 
                array('opciones' => $opciones, 'idResEsp' => $idResEspeUnisal,'descResEsp'=>$descResEsp,'idObj'=>$idObj,'descObj'=>$descObj));
    }

    public function manttResEspeUnisalAction() {
        $request = $this->getRequest();

        $operacion = $request->get('oper');
        $idObj = $request->get('idObj');
        $descResEsp=$request->get('descResEsp');
        $idResEsp=$request->get('idResEsp');

        $resEspeUnisalDao= new ResultadoEspeUnisalDao($this->getDoctrine());

        
        switch ($operacion) {
            case 'add':
                $resEspeUnisalDao->agregarResultadoEsperado($idObj, $descResEsp);
             break;
            case 'edit':
              $resEspeUnisalDao->editarResultadoEsperado($idResEsp,$descResEsp);
            break;
        }

        return $this->mostrarResEspeUnisalAction();
    }

}

?>  

