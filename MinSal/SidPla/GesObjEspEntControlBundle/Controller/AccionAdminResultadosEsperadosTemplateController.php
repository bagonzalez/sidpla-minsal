<?php

namespace MinSal\SidPla\GesObjEspEntControlBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjespTemplate;
use MinSal\SidPla\GesObjEspEntControlBundle\EntityDao\ObjespTemplateDao;
use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ResEspTemplate;
use MinSal\SidPla\GesObjEspEntControlBundle\EntityDao\ResEspTemplateDao;
use MinSal\SidPla\GesObjEspBundle\Entity\TipoMeta;
use MinSal\SidPla\GesObjEspBundle\EntityDao\TipoMetaDao;

class AccionAdminResultadosEsperadosTemplateController extends Controller {

    public function consultarResultadosEsperadosTemplateAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $request = $this->getRequest();
        $idfila = $request->get('idfila');
        
        $objetivoDao = new ObjespTemplateDao($this->getDoctrine());
        $objetivoAux = $objetivoDao->getObjetivoTemplate($idfila);
        $objetivosEspec = $objetivoAux->getIdObjEspec()->getDescripcion();
        $resultadosEsperados = $objetivoAux->getResultadostemplate();

        if (count($resultadosEsperados) == 0)
            return $this->render('MinSalSidPlaGesObjEspEntControlBundle:GestionResultadosEsperadosTemplate:manttResultadosEsperados.html.twig', 
                    array('opciones' => $opciones, 'idfila' => $idfila, 'descripcion' => $objetivosEspec));
        else
            return $this->render('MinSalSidPlaGesObjEspEntControlBundle:GestionResultadosEsperadosTemplate:manttResultadosEsperados.html.twig', 
                    array('opciones' => $opciones, 'idfila' => $idfila, 'descripcion' => $objetivosEspec, 'resultadosEsperados' => $resultadosEsperados));
    }

    public function manttResultadosEsperadosTemplateAction() {

        $request = $this->getRequest();
        $id = $request->get('id');
        $idobjetivo = $request->get('idfila'); //id objetivo
        $idResTempl = $request->get('idResTempl');

        $operacion = $request->get('oper');

        $objDao = new ResEspTemplateDao($this->getDoctrine());


        $objDao->delResultadoEsperadotemplate($id);

        return new Response("{sc:true,msg:''}");
    }

    public function ingresoResultadosEsperadosTemplateAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');

        $request = $this->getRequest();
        $idfila = $request->get('idfila');
        $objetivoAux = new ObjespTemplate();
        $objetivoDao = new ObjespTemplateDao($this->getDoctrine());
        $objetivoAux = $objetivoDao->getObjetivoTemplate($idfila);
        $objetivosEspec = $objetivoAux->getIdObjEspec()->getDescripcion();

        return $this->render('MinSalSidPlaGesObjEspEntControlBundle:GestionResultadosEsperadosTemplate:IngresoResultadoEsperado.html.twig', array('opciones' => $opciones, 'idfila' => $idfila, 'descripcion' => $objetivosEspec));
    }

    public function guardarResultadosEsperadosTemplateAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $request = $this->getRequest();
        $idfila = $request->get('idfila');
        $idobjetivo = $request->get('idfila');  //representa en este caso el codigo de objetivo
        $resEspeDesc = $request->get('resultadoEsperado');
        $resEspIndicador = $request->get('Indicador');

        $resEspNomencl = "prueba";
        $objetivoDao = new ObjespTemplateDao($this->getDoctrine());
        $idResultadoEsp = $objetivoDao->agregarResulEsperadoTemplate($resEspeDesc, $resEspNomencl, $resEspIndicador, $idobjetivo);

        $objetivoAux = new ObjespTemplate();
        $objetivoDao = new ObjespTemplateDao($this->getDoctrine());
        $objetivoAux = $objetivoDao->getObjetivoTemplate($idfila);
        $objetivosEspec = $objetivoAux->getIdObjEspec()->getDescripcion();
        return $this->consultarResultadosEsperadosTemplateAction();
    }

    public function consultarTipoMetaAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $tipometaDao = new TipoMetaDao($this->getDoctrine());
        $tiposmeta = $tipometaDao->getTiposMeta();

        $numfilas = count($tiposmeta);

        $tipo = new TipoMeta();
        $i = 0;

        foreach ($tiposmeta as $tipo) {
            $rows[$i]['id'] = $tipo->getIdTipoMeta();
            $rows[$i]['cell'] = array($tipo->getIdTipoMeta(),
                $tipo->getTipoMetaNombre());
            $i++;
        }

        $datos = json_encode($rows);


        $jsonresponse = '{
               "page":"1",
               "total":"1",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';


        $response = new Response($jsonresponse);
        return $response;
    }

    public function editarResultadosEsperadosTemplateAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $request = $this->getRequest();
        $idfila = $request->get('idfila');
        $id = $request->get('idfilaResultado');


        //obteniendo el objetivo especifico
        $objetivoAux = new ObjespTemplate();
        $objetivoDao = new ObjespTemplateDao($this->getDoctrine());
        $objetivoAux = $objetivoDao->getObjetivoTemplate($idfila);

        $objetivosEspec = $objetivoAux->getIdObjEspec()->getDescripcion();

        //obteniendo los datos del resultado esperado

        $resultadoAux = new ResEspTemplate();
        $resultadoDao = new ResEspTemplateDao($this->getDoctrine());
        $resultadoAux = $resultadoDao->getResultadoTemplate($id);

        $resultadoEsperadoDescrp = $resultadoAux->getResEspTemplDescripcion();
        $resultadoEsperadoIndicador = $resultadoAux->getResEspTemplIndicador();

        return $this->render('MinSalSidPlaGesObjEspEntControlBundle:GestionResultadosEsperadosTemplate:EditarResultadoEsperado.html.twig', array('opciones' => $opciones, 'idfila' => $idfila, 'descripcion' => $objetivosEspec, 'idfilaResultado' => $id,
                    'resultadoEsperadoDescrp' => $resultadoEsperadoDescrp
                    , 'resultadoEsperadoIndicador' => $resultadoEsperadoIndicador
                ));
    }

    public function editandoResultadosEsperadosTemplateAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $request = $this->getRequest();
        $idfila = $request->get('idfila');

        $idobjetivo = $request->get('idfila'); //representa en este caso el codigo de objetivo
        $id = $request->get('idfilaResultado');
        $resEspeDesc = $request->get('resultadoEsperado');
        $resEspIndicador = $request->get('Indicador');

        $resEspNomencl = "pruebanomenc";
        $objDao = new ResEspTemplateDao($this->getDoctrine());
        $objDao->editResulEspTemplate($resEspeDesc, $resEspNomencl, $resEspIndicador, $idobjetivo, $id);

        //obteniendo el objetivo especifico
        //$objetivoAux = new ObjespTemplate();
        $objetivoDao = new ObjespTemplateDao($this->getDoctrine());
        $objetivoAux = $objetivoDao->getObjetivoTemplate($idfila);
        $objetivosEspec = $objetivoAux->getIdObjEspec()->getDescripcion();

        //return $this->render('MinSalSidPlaGesObjEspEntControlBundle:GestionResultadosEsperadosTemplate:manttResultadosEsperados.html.twig', array('opciones' => $opciones, 'idfila' => $idfila,               'descripcion' => $objetivosEspec));
        return $this->consultarResultadosEsperadosTemplateAction();
    }

}

?>
