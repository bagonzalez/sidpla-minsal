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
        $objetivoAux = new ObjespTemplate();
        $objetivoDao = new ObjespTemplateDao($this->getDoctrine());
        $objetivoAux = $objetivoDao->getObjetivoTemplate($idfila);
        $objetivosEspec = $objetivoAux->getIdObjEspec()->getDescripcion();


        return $this->render('MinSalSidPlaGesObjEspEntControlBundle:GestionResultadosEsperadosTemplate:manttResultadosEsperados.html.twig', array('opciones' => $opciones, 'idfila' => $idfila, 'descripcion' => $objetivosEspec));
    }

    public function consultarResultadosEsperadosTemplateJSONAction() {

        $request = $this->getRequest();
        $idobjetivo = $request->get('idfila');

        $objetivoAux = new ObjespTemplate();
        $objetivoDao = new ObjespTemplateDao($this->getDoctrine());
        $objetivoAux = $objetivoDao->getObjetivoTemplate($idobjetivo);

        $objetivosEspec = $objetivoAux->getResultadostemplate();

        $numfilas = count($objetivosEspec);

        $objetivoEspec = new ResEspTemplate();
        $i = 0;

        foreach ($objetivosEspec as $objetivoEspec) {
            $rows[$i]['id'] = $objetivoEspec->getIdResEspTempl();
            $rows[$i]['cell'] = array($objetivoEspec->getIdResEspTempl(),
                $objetivoEspec->getIdObjEspecTempl(),
                $objetivoEspec->getResEspTemplDescripcion(),
                $objetivoEspec->getResEspTemplIndicador()
            );
            $i++;
        }

        $datos = json_encode($rows);


        $jsonresponse = '{
               "page":"1",
               "total":"' . ($numfilas / 10) . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';


        $response = new Response($jsonresponse);
        return $response;
    }

    public function manttResultadosEsperadosTemplateAction() {

        $request = $this->getRequest();
        $id = $request->get('id');
        $idobjetivo = $request->get('idfila'); //id objetivo
        $idResTempl = $request->get('idResTempl');
        $idTipoMeta = $request->get('idTipoMeta');
        $resEspeDesc = $request->get('resEspeDesc');
        $resEspNomencl = $request->get('resEspNomencl');
        $resEspCondi = $request->get('resEspCondi');
        $resEspMetAnual = $request->get('resEspMetAnual');
        $resEspDescMetAnual = $request->get('resEspDescMetAnual');
        $resEspResponsable = $request->get('resEspResponsable');
        $resEspEntidadControl = $request->get('resEspEntidadControl');
        $resEspIndicador = $request->get('resEspIndicador');


        $operacion = $request->get('oper');

        $objDao = new ResultadoEsperadoDao($this->getDoctrine());

        if ($operacion == 'edit') {
            $objDao->editResulEsp($idResTempl, $idTipoMeta, $resEspeDesc, $resEspNomencl, $resEspCondi, $resEspMetAnual, $resEspDescMetAnual, $resEspResponsable, $resEspEntidadControl, $resEspIndicador, $idobjetivo, $id);
        }

        if ($operacion == 'del') {
            $objDao->delObjEspec($id);
        }

        if ($operacion == 'add') {
            $objetivoDao = new ObjetivoEspecificoDao($this->getDoctrine());
            $objetivoDao->agregarResulEsperado($idResTempl, $idTipoMeta, $resEspeDesc, $resEspNomencl, $resEspCondi, $resEspMetAnual, $resEspDescMetAnual, $resEspResponsable, $resEspEntidadControl, $resEspIndicador, $idobjetivo);
        }

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
        $medioverificacion = $request->get('medioverificacion');
        $resEspResponsable = $request->get('responsable');
        $resEspCondi = $request->get('supuestosfactores');
        $resEspMetAnual = $request->get('metaAnual');
        $tipometa = $request->get('selectipometa');
        $resEspDescMetAnual = $request->get('descripMetaAnual');


        //estos tres valores son fusilados porque no se bien como  funcionan
        //asi que solo los asigno y los mando
        $resEspNomencl = "pruebanomenc";
        $restmpcodigo = 1;
        $resEspEntidadControl = true;


        $trimUno = $request->get('trimUno');
        $trimDos = $request->get('trimDos');
        $trimTres = $request->get('trimTres');
        $trimCuatro = $request->get('trimCuatro');





        $objetivoDao = new ObjetivoEspecificoDao($this->getDoctrine());
        $idResultadoEsp = $objetivoDao->agregarResulEsperado($restmpcodigo, $tipometa, $resEspeDesc, $resEspNomencl, $resEspCondi, $resEspMetAnual, $resEspDescMetAnual, $resEspResponsable, $resEspEntidadControl, $resEspIndicador, $idobjetivo, $medioverificacion);


        $trimesuno = 1;
        $trimesdos = 2;
        $trimestres = 3;
        $trimescuatro = 4;


        $paoElaboracion = $this->obtenerPaoElaboracionAction();
        $programacionMonitoreo = $paoElaboracion->getProgramacionMonitoreo();



        //inicia proceso de guardar el valor de lo programado en sidpla_resultadore
        $resultadoDao = new ResultadoEsperadoDao($this->getDoctrine());
        $resultadoDao->agregarResultadore($idResultadoEsp, $trimesuno, $trimUno, $programacionMonitoreo);

        $resultadoDao = new ResultadoEsperadoDao($this->getDoctrine());
        $resultadoDao->agregarResultadore($idResultadoEsp, $trimesdos, $trimDos, $programacionMonitoreo);

        $resultadoDao = new ResultadoEsperadoDao($this->getDoctrine());
        $resultadoDao->agregarResultadore($idResultadoEsp, $trimestres, $trimTres, $programacionMonitoreo);

        $resultadoDao = new ResultadoEsperadoDao($this->getDoctrine());
        $resultadoDao->agregarResultadore($idResultadoEsp, $trimescuatro, $trimCuatro, $programacionMonitoreo);


        $objetivoAux = new ObjetivoEspecifico();
        $objetivoDao = new ObjetivoEspecificoDao($this->getDoctrine());
        $objetivoAux = $objetivoDao->getObjetEspecif($idfila);
        $objetivosEspec = $objetivoAux->getDescripcion();
        return $this->render('MinSalSidPlaGesObjEspBundle:GestionResultadosEsperados:manttResultadosEsperados.html.twig', array('opciones' => $opciones, 'idfila' => $idfila, 'descripcion' => $objetivosEspec));
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

    public function editarResultadosEsperadosAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $request = $this->getRequest();
        $idfila = $request->get('idfila');
        $id = $request->get('idfilaResultado');


        //obteniendo el objetivo especifico
        $objetivoAux = new ObjetivoEspecifico();
        $objetivoDao = new ObjetivoEspecificoDao($this->getDoctrine());
        $objetivoAux = $objetivoDao->getObjetEspecif($idfila);

        $objetivosEspec = $objetivoAux->getDescripcion();

        //obteniendo los datos del resultado esperado

        $resultadoAux = new ResultadoEsperado();
        $resultadoDao = new ResultadoEsperadoDao($this->getDoctrine());
        $resultadoAux = $resultadoDao->getResulEspera($id);

        $resultadoEsperadoDescrp = $resultadoAux->getResEspeDesc();
        $resultadoEsperadoIndicador = $resultadoAux->getResEspIndicador();
        $resultadoEsperadoMedioVerificacion = $resultadoAux->getmedioVerificacion();
        $resultadoEsperadoResponsable = $resultadoAux->getResEspResponsable();
        $resultadoEsperadoSupuestos = $resultadoAux->getResEspCondi();
        $resultadoEsperadoMetaAnual = $resultadoAux->getResEspMetAnual();
        $resultadoEsperadoTipoMeta = $resultadoAux->getIdTipoMeta();
        $resultadoEsperadoDescripcionMetaAnual = $resultadoAux->getResEspDescMetAnual();




        //inicia el proceso  de recuperar los atos de la tabla resultadore
        $resultAux = new ResultadoEsperado();
        $resultDao = new ResultadoEsperadoDao($this->getDoctrine());
        $resultAux = $resultDao->getResulEspera($id);
        $resultadoresEspe = $resultAux->getResultadore();
        $numfilas = count($resultadoresEspe);
        $resultadoreEspec = new Resultadore();
        $i = 0;
        $programadoPrimerTrimestre = 0;
        $programadoSegundoTrimestre = 0;
        $programadoTercerTrimestre = 0;
        $programadoCuartoTrimestre = 0;
        $iduno = 0;
        $iddos = 0;
        $idtres = 0;
        $idcuatro = 0;


        foreach ($resultadoresEspe as $resultadoreEspec) {

            $trimestre = $resultadoreEspec->getResultadoreTrimestre();
            if ($trimestre == 1) {
                $programadoPrimerTrimestre = $resultadoreEspec->getResultadoreProgramado();
                $iduno = $resultadoreEspec->getIdResultadore();
            }

            if ($trimestre == 2) {
                $programadoSegundoTrimestre = $resultadoreEspec->getResultadoreProgramado();
                $iddos = $resultadoreEspec->getIdResultadore();
            }

            if ($trimestre == 3) {
                $programadoTercerTrimestre = $resultadoreEspec->getResultadoreProgramado();
                $idtres = $resultadoreEspec->getIdResultadore();
            }

            if ($trimestre == 4) {
                $programadoCuartoTrimestre = $resultadoreEspec->getResultadoreProgramado();
                $idcuatro = $resultadoreEspec->getIdResultadore();
            }
        }






        return $this->render('MinSalSidPlaGesObjEspBundle:GestionResultadosEsperados:EditarResultadoEsperado.html.twig', array('opciones' => $opciones, 'idfila' => $idfila, 'descripcion' => $objetivosEspec, 'idfilaResultado' => $id,
                    'resultadoEsperadoDescrp' => $resultadoEsperadoDescrp
                    , 'resultadoEsperadoIndicador' => $resultadoEsperadoIndicador
                    , 'resultadoEsperadoMedioVerificacion' => $resultadoEsperadoMedioVerificacion
                    , 'resultadoEsperadoResponsable' => $resultadoEsperadoResponsable
                    , 'resultadoEsperadoSupuestos' => $resultadoEsperadoSupuestos
                    , 'resultadoEsperadoMetaAnual' => $resultadoEsperadoMetaAnual
                    , 'resultadoEsperadoTipoMeta' => $resultadoEsperadoTipoMeta
                    , 'resultadoEsperadoDescripcionMetaAnual' => $resultadoEsperadoDescripcionMetaAnual
                    , 'trim1' => $programadoPrimerTrimestre
                    , 'trim2' => $programadoSegundoTrimestre
                    , 'trim3' => $programadoTercerTrimestre
                    , 'trim4' => $programadoCuartoTrimestre
                    , 'iduno' => $iduno
                    , 'iddos' => $iddos
                    , 'idtres' => $idtres
                    , 'idcuatro' => $idcuatro
                ));
    }

    public function editandoResultadosEsperadosAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $request = $this->getRequest();
        $idfila = $request->get('idfila');

        $idobjetivo = $request->get('idfila'); //representa en este caso el codigo de objetivo
        $id = $request->get('idfilaResultado');
        $resEspeDesc = $request->get('resultadoEsperado');
        $resEspIndicador = $request->get('Indicador');
        $medioverificacion = $request->get('medioverificacion');
        $resEspResponsable = $request->get('responsable');
        $resEspCondi = $request->get('supuestosfactores');
        $resEspMetAnual = $request->get('metaAnual');
        $tipometa = $request->get('selectipometa');
        $resEspDescMetAnual = $request->get('descripMetaAnual');




        $trimUno = $request->get('trimUno');
        $trimDos = $request->get('trimDos');
        $trimTres = $request->get('trimTres');
        $trimCuatro = $request->get('trimCuatro');

        $iduno = $request->get('iduno');
        $iddos = $request->get('iddos');
        $idtres = $request->get('idtres');
        $idcuatro = $request->get('idcuatro');


        $resEspNomencl = "pruebanomenc";
        $restmpcodigo = 1;
        $resEspEntidadControl = true;


        $objDao = new ResultadoEsperadoDao($this->getDoctrine());
        $objDao->editResulEsp($restmpcodigo, $tipometa, $resEspeDesc, $resEspNomencl, $resEspCondi, $resEspMetAnual, $resEspDescMetAnual, $resEspResponsable, $resEspEntidadControl, $resEspIndicador, $idobjetivo, $medioverificacion, $id);

        $objetivoAux = new ObjetivoEspecifico();
        $objetivoDao = new ObjetivoEspecificoDao($this->getDoctrine());
        $objetivoAux = $objetivoDao->getObjetEspecif($idfila);
        $objetivosEspec = $objetivoAux->getDescripcion();


        //actualizando en sidpla resultadore 
        $ResultadoreDao = new ResultadoreDao($this->getDoctrine());
        $ResultadoreDao->editresultadore($trimUno, $iduno);

        $ResultadoreDao = new ResultadoreDao($this->getDoctrine());
        $ResultadoreDao->editresultadore($trimDos, $iddos);

        $ResultadoreDao = new ResultadoreDao($this->getDoctrine());
        $ResultadoreDao->editresultadore($trimTres, $idtres);

        $ResultadoreDao = new ResultadoreDao($this->getDoctrine());
        $ResultadoreDao->editresultadore($trimCuatro, $idcuatro);

        return $this->render('MinSalSidPlaGesObjEspBundle:GestionResultadosEsperados:manttResultadosEsperados.html.twig', array('opciones' => $opciones, 'idfila' => $idfila, 'descripcion' => $objetivosEspec));
    }

}

?>
