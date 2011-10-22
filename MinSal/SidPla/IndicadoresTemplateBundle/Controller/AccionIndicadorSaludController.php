<?php

namespace MinSal\SidPla\IndicadoresTemplateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

use MinSal\SidPla\IndicadoresTemplateBundle\EntityDao\IndicadorSaludDao;
use MinSal\SidPla\IndicadoresTemplateBundle\Entity\IndicadorSalud;

use MinSal\SidPla\TemplateUnisalBundle\EntityDao\ObjetivoEspeUnisalDao;
use MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal;

use MinSal\SidPla\IndicadoresTemplateBundle\Entity\TipoIndicador;
use MinSal\SidPla\IndicadoresTemplateBundle\EntityDao\TipoIndicadorDao;

class AccionIndicadorSaludController extends Controller  {
    
    public function mostrarIndicadoresSaludAction() {
        
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $idObj = $request->get('idObj');

        $objEspUniDao = new ObjetivoEspeUnisalDao($this->getDoctrine());
        $objEspUni = $objEspUniDao->getObjetivoEspeUnisalEspecifico($idObj);
        $decObjEsp=$objEspUni->getDescObjEspUni();
                
        $indicadoresSalud=$objEspUni->getIndicadoresSalud();
        
        if (count($indicadoresSalud)!=0)
            return $this->render('MinSalSidPlaIndicadoresTemplateBundle:IndicadorSalud:manttIndicadorSalud.html.twig', 
                    array('opciones' => $opciones, 'descObj' => $decObjEsp, 'idObj' => $idObj,'indSalud'=>$indicadoresSalud));
        else
            return $this->render('MinSalSidPlaIndicadoresTemplateBundle:IndicadorSalud:manttIndicadorSalud.html.twig', 
                    array('opciones' => $opciones, 'descObj' => $decObjEsp, 'idObj' => $idObj));
    }
    
    public function ingresarIndicadorSaludAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $idObj = $request->get('idObj');
        $objEspUniDao = new ObjetivoEspeUnisalDao($this->getDoctrine());
        $objEspUni = $objEspUniDao->getObjetivoEspeUnisalEspecifico($idObj);
        $descObj = $objEspUni->getDescObjEspUni();
        
        $tipoIndicadorDao = new TipoIndicadorDao($this->getDoctrine());
        $tipoIndicador=$tipoIndicadorDao->getTipoIndicador();
        
        array_multisort($tipoIndicador, SORT_ASC);

        return $this->render('MinSalSidPlaIndicadoresTemplateBundle:IndicadorSalud:gestionIndicadorSalud.html.twig', 
                array('opciones' => $opciones, 'idObj'=>$idObj,'descObj'=>$descObj,'tipoIndicador'=>$tipoIndicador));
    }
     public function editarIndicadorSaludAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        
        $request = $this->getRequest();
        $idObj = $request->get('idObj');
        $objEspUniDao = new ObjetivoEspeUnisalDao($this->getDoctrine());
        $objEspUni = $objEspUniDao->getObjetivoEspeUnisalEspecifico($idObj);
        $descObj = $objEspUni->getDescObjEspUni();
        
        $idIndSal = $request->get('idIndSal');
        
        $indicadorDao= new IndicadorSaludDao($this->getDoctrine());
        $indicador=new IndicadorSalud();
        
        $indicador=$indicadorDao->getIndicadorSaludEspecifico($idIndSal);
        
        $tipoIndicadorDao = new TipoIndicadorDao($this->getDoctrine());
        $tipoIndicador=$tipoIndicadorDao->getTipoIndicador();
        
        array_multisort($tipoIndicador, SORT_ASC);
        

        return $this->render('MinSalSidPlaIndicadoresTemplateBundle:IndicadorSalud:gestionIndicadorSalud.html.twig', 
                array('opciones' => $opciones, 'idObj'=>$idObj,'descObj'=>$descObj,'idIndSal'=>$indicador->getCodIndSalud(),'tipoIndicador'=>$tipoIndicador,
                    'tipInd'=>$indicador->getTipoIndicador()->getCodTipIndi(),'descIndSal'=>$indicador->getNombreIndSalud(),
                    'form1IndSal'=>$indicador->getForm1IndSalud(),'form2IndSal'=>$indicador->getForm2IndSalud(),'resIndSal'=>$indicador->getTipoEvalua()));
    }

    public function manttIndicadorSaludAction() {
        $request = $this->getRequest();

        $operacion = $request->get('oper');
        $idObj = $request->get('idObj');
        $idIndSal=$request->get('idIndSal');
        $idTipInd=$request->get('tipInd');
        $nombreIndSalud=$request->get('descIndSal');
        $form1IndSalud=$request->get('form1IndSal');
        $form2IndSalud=$request->get('form2IndSal');
        $tipoEvalua=$request->get('resIndSal');

        $indicadorSaludDao= new IndicadorSaludDao($this->getDoctrine());

        
        switch ($operacion) {
            case 'add':
                $indicadorSaludDao->agregarIndicadorSalud($idObj, $idTipInd, $nombreIndSalud, $form1IndSalud, $form2IndSalud,$tipoEvalua);
             break;
            case 'edit':
             $indicadorSaludDao->editarIndicadorSalud($idIndSal, $idTipInd, $nombreIndSalud, $form1IndSalud, $form2IndSalud, $tipoEvalua);
            break;
        }

        return $this->mostrarIndicadoresSaludAction();
    }
}

?>
