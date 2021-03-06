<?php

namespace MinSal\SidPla\GesObjEspBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico;
use MinSal\SidPla\UnidadOrgBundle\EntityDao\ObjetivoEspecificoDao;
use MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado;
use MinSal\SidPla\GesObjEspBundle\EntityDao\ResultadoEsperadoDao;
use MinSal\SidPla\GesObjEspBundle\Entity\TipoMeta;
use MinSal\SidPla\GesObjEspBundle\EntityDao\TipoMetaDao;
use MinSal\SidPla\GesObjEspBundle\Entity\Resultadore;
use MinSal\SidPla\GesObjEspBundle\EntityDao\ResultadoreDao;
use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\PaoBundle\Entity\Pao;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;

class AccionAdminResultadosEsperadosController extends Controller {

    public function obtenerPaoElaboracionAction() {

        $user = new User();
        $empleado = new Empleado();
        $user = $this->get('security.context')->getToken()->getUser();
        $empleado = $user->getEmpleado();
        $idUnidad = $empleado->getUnidadOrganizativa()->getIdUnidadOrg();
        $unidaDao = new UnidadOrganizativaDao($this->getDoctrine());
        $unidad = new UnidadOrganizativa();
        $unidad = $unidaDao->getUnidadOrg($idUnidad);

        $paoElaboracion = new Pao();
        $paoElaboracion = $unidaDao->getPaoElaboracion($idUnidad);

        return $paoElaboracion;
    }

    public function obtenerUnidadOrg() {

        $user = new User();
        $empleado = new Empleado();
        $user = $this->get('security.context')->getToken()->getUser();
        $empleado = $user->getEmpleado();
        $idUnidad = $empleado->getUnidadOrganizativa()->getIdUnidadOrg();
        $unidaDao = new UnidadOrganizativaDao($this->getDoctrine());
        $unidad = new UnidadOrganizativa();
        $unidad = $unidaDao->getUnidadOrg($idUnidad);

        return $unidad;
    }

    public function consultarResultadosEsperadosAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $request = $this->getRequest();
        $idfila = $request->get('idfila');
        $objUniControl = $request->get('objUniControl');
        $objetivoDao = new ObjetivoEspecificoDao($this->getDoctrine());
        $objetivoAux = $objetivoDao->getObjetEspecif($idfila);
        $objetivosEspec = $objetivoAux->getDescripcion();
        $resultadoReDao = new ResultadoreDao($this->getDoctrine());
        if (isset($objUniControl)) {
            if ($objUniControl == 'true') {
                $uniOrg = $this->obtenerUnidadOrg();
                $resultadoDao = new ResultadoEsperadoDao($this->getDoctrine());
                $resultadosEsperados = $resultadoDao->consultarResultadosEntidadControl($idfila, $uniOrg->getIdUnidadOrg());
            }
            else
                $resultadosEsperados = $objetivoAux->getResultadoEsperado();
        }else
            $resultadosEsperados = $objetivoAux->getResultadoEsperado();
        $x = count($resultadosEsperados);
        
        $idUnidad=$this->obtenerUnidadOrg()->getIdUnidadOrg();
        if ($x == 0) {
            if (isset($objUniControl)) {
                if ($objUniControl == 'true')
                    return $this->render('MinSalSidPlaGesObjEspBundle:GestionResultadosEsperados:manttResultadosEsperados.html.twig', 
                            array('opciones' => $opciones, 'idfila' => $idfila, 'descripcion' => $objetivosEspec,
                                'objUniControl' => $objUniControl,'resultadoDao'=>$resultadoReDao,'idDepen' => $idUnidad));
                else
                    return $this->render('MinSalSidPlaGesObjEspBundle:GestionResultadosEsperados:manttResultadosEsperados.html.twig', 
                            array('opciones' => $opciones, 'idfila' => $idfila, 'descripcion' => $objetivosEspec,'idDepen' => $idUnidad));
            }
            else
                return $this->render('MinSalSidPlaGesObjEspBundle:GestionResultadosEsperados:manttResultadosEsperados.html.twig', 
                        array('opciones' => $opciones, 'idfila' => $idfila, 'descripcion' => $objetivosEspec,'idDepen' => $idUnidad));
        }
        else {
            if (isset($objUniControl)) {
                if ($objUniControl == 'true')
                    return $this->render('MinSalSidPlaGesObjEspBundle:GestionResultadosEsperados:manttResultadosEsperados.html.twig', array('opciones' => $opciones, 'idfila' => $idfila, 'descripcion' => $objetivosEspec, 'resultadosEsperado' => $resultadosEsperados,
                                'objUniControl' => $objUniControl,'resultadoDao'=>$resultadoReDao,'idDepen' => $idUnidad));
                else
                    return $this->render('MinSalSidPlaGesObjEspBundle:GestionResultadosEsperados:manttResultadosEsperados.html.twig', 
                            array('opciones' => $opciones, 'idfila' => $idfila, 'descripcion' => $objetivosEspec, 
                                'resultadosEsperado' => $resultadosEsperados,'idDepen' => $idUnidad));
            }
            else
                return $this->render('MinSalSidPlaGesObjEspBundle:GestionResultadosEsperados:manttResultadosEsperados.html.twig', 
                        array('opciones' => $opciones, 'idfila' => $idfila, 'descripcion' => $objetivosEspec, 
                            'resultadosEsperado' => $resultadosEsperados,'idDepen' => $idUnidad));
        }
    }

    public function ingresoResultadosEsperadosAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $request = $this->getRequest();
        $idfila = $request->get('idfila');
        $objUniControl = $request->get('objUniControl');

        $objetivoAux = new ObjetivoEspecifico();
        $objetivoDao = new ObjetivoEspecificoDao($this->getDoctrine());
        $objetivoAux = $objetivoDao->getObjetEspecif($idfila);

        $objetivosEspec = $objetivoAux->getDescripcion();

        if (isset($objUniControl))
            if ($objUniControl == 'true')
                return $this->render('MinSalSidPlaGesObjEspBundle:GestionResultadosEsperados:IngresoResultadoEsperado.html.twig', array('opciones' => $opciones, 'idfila' => $idfila, 'descripcion' => $objetivosEspec, 'objUniControl' => $objUniControl));
            else
                return $this->render('MinSalSidPlaGesObjEspBundle:GestionResultadosEsperados:IngresoResultadoEsperado.html.twig', array('opciones' => $opciones, 'idfila' => $idfila, 'descripcion' => $objetivosEspec));
        else
            return $this->render('MinSalSidPlaGesObjEspBundle:GestionResultadosEsperados:IngresoResultadoEsperado.html.twig', array('opciones' => $opciones, 'idfila' => $idfila, 'descripcion' => $objetivosEspec));
    }

    public function guardarResultadosEsperadosAction() {
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
        $entControl = $request->get('entControl');
        $objUniControl = $request->get('objUniControl');

        if (isset($entControl)) {
            $resEspEntidadControl = true;
            $restmpcodigo = null; //ENVIAR EL VALOR DEL RESTMPCODIGO
        } else {
            $resEspEntidadControl = false;
            $restmpcodigo = null;
        }

        $trimUno = $request->get('trimUno');
        $trimDos = $request->get('trimDos');
        $trimTres = $request->get('trimTres');
        $trimCuatro = $request->get('trimCuatro');

        // $unidad = new UnidadOrganizativa();
        $unidad = $this->obtenerUnidadOrg();

        $objetivoDao = new ObjetivoEspecificoDao($this->getDoctrine());
        //$pao=new Pao();
        $paoElaboracion = $this->obtenerPaoElaboracionAction();
        $programacionMonitoreo = $paoElaboracion->getProgramacionMonitoreo();

        $idResultadoEsp = $objetivoDao->agregarResulEsperado($tipometa, $resEspeDesc, $resEspCondi, $resEspMetAnual, $resEspDescMetAnual, $resEspResponsable, $resEspEntidadControl, $resEspIndicador, $idobjetivo, $medioverificacion, $unidad);

        //inicia proceso de guardar el valor de lo programado en sidpla_resultadore
        $trimesuno = 1;
        $trimesdos = 2;
        $trimestres = 3;
        $trimescuatro = 4;

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
        $objetivoDao->actualizaNomenclatura((int) $unidad->getCaractOrg()->getIdCaractOrg(), (int) $paoElaboracion->getAnio());

        if (isset($objUniControl))
            if ($objUniControl== 'true')
                $resultadoDao->actualizaNomenclatura($paoElaboracion->getUnidadOrganizativa()->getIdUnidadOrg(), $paoElaboracion->getAnio());
            else
                $objetivoDao->actualizaNomenclatura((int) $unidad->getCaractOrg()->getIdCaractOrg(), (int) $paoElaboracion->getAnio());
        else {
            $objetivoDao->actualizaNomenclatura((int) $unidad->getCaractOrg()->getIdCaractOrg(), (int) $paoElaboracion->getAnio());
        }
        return $this->consultarResultadosEsperadosAction();
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
        $objUniControl = $request->get('objUniControl');
        if (isset($objUniControl))
            if ($objUniControl == 'true')
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
                            , 'idcuatro' => $idcuatro,
                            'objUniControl' => $objUniControl));
            else
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
        else
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

        //LO CAMBIE POR NULL PERO TENIA 1 Y ME DABA ERROR
        $restmpcodigo = null;
        //
        $resEspEntidadControl = true;

        $objDao = new ResultadoEsperadoDao($this->getDoctrine());
        $objDao->editResulEsp($restmpcodigo, $tipometa, $resEspeDesc, $resEspCondi, $resEspMetAnual, $resEspDescMetAnual, $resEspResponsable, $resEspEntidadControl, $resEspIndicador, $idobjetivo, $medioverificacion, $id);

        $objetivoAux = new ObjetivoEspecifico();
        $objetivoDao = new ObjetivoEspecificoDao($this->getDoctrine());
        $objetivoAux = $objetivoDao->getObjetEspecif($idfila);
        $objetivosEspec = $objetivoAux->getDescripcion();

        //actualizando en sidpla resultadore

        $ResultadoreDao = new ResultadoreDao($this->getDoctrine());
        if ($ResultadoreDao->hayResultadosRe($id) != 0) {
            $ResultadoreDao->editresultadore($trimUno, $iduno);
            $ResultadoreDao->editresultadore($trimDos, $iddos);
            $ResultadoreDao->editresultadore($trimTres, $idtres);
            $ResultadoreDao->editresultadore($trimCuatro, $idcuatro);
        } else {
            $paoElaboracion = $this->obtenerPaoElaboracionAction();
            $programacionMonitoreo = $paoElaboracion->getProgramacionMonitoreo();
            //inicia proceso de guardar el valor de lo programado en sidpla_resultadore
            $trimesuno = 1;
            $trimesdos = 2;
            $trimestres = 3;
            $trimescuatro = 4;

            $resultadoDao = new ResultadoEsperadoDao($this->getDoctrine());
            $resultadoDao->agregarResultadore($id, $trimesuno, $trimUno, $programacionMonitoreo);
            $resultadoDao->agregarResultadore($id, $trimesdos, $trimDos, $programacionMonitoreo);
            $resultadoDao->agregarResultadore($id, $trimestres, $trimTres, $programacionMonitoreo);
            $resultadoDao->agregarResultadore($id, $trimescuatro, $trimCuatro, $programacionMonitoreo);
            $objDao->actualizaNomenclatura($paoElaboracion->getUnidadOrganizativa()->getIdUnidadOrg(), $paoElaboracion->getAnio());
        }

        return $this->consultarResultadosEsperadosAction();
    }

}

?>
