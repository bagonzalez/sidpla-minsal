<?php

namespace MinSal\SidPla\PrograMonitoreoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\PaoBundle\Entity\Pao;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;
use MinSal\SidPla\GesObjEspBundle\EntityDao\ActividadDao;
use MinSal\SidPla\GesObjEspBundle\EntityDao\ResulActividadDao;
use MinSal\SidPla\GesObjEspBundle\Entity\ResulActividad;
use MinSal\SidPla\GesObjEspBundle\Entity\Actividad;
use MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico;
use MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado;
use MinSal\SidPla\GesObjEspEntControlBundle\EntityDao\ObjTemplateDao;
use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjTemplate;
use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjespTemplate;
use MinSal\SidPla\PrograMonitoreoBundle\EntityDao\ProgramacionMonitoreoDao;
//COMPROMISO CUMPLIMIENTO
use MinSal\SidPla\PrograMonitoreoBundle\EntityDao\CompromisoCumplimientoDao;
use MinSal\SidPla\PrograMonitoreoBundle\Entity\CompromisoCumplimiento;
use MinSal\SidPla\UnidadOrgBundle\EntityDao\ObjetivoEspecificoDao;
use MinSal\SidPla\GesObjEspBundle\EntityDao\ResultadoEsperadoDao;
//PARA REPROGRAMACION
use MinSal\SidPla\PrograMonitoreoBundle\Entity\Reprogramacion;
use MinSal\SidPla\PrograMonitoreoBundle\EntityDao\ReprogramacionDao;

class AccionCompromisoCumplimientoController extends Controller {

    //para el caso de la creacion de la hoja compromiso cumplimiento 
    //se trabajara con la PAO EN SEGUIMIENTO

    public function obtenerPaoSeguimiento() {

        $user = new User();
        $empleado = new Empleado();
        $user = $this->get('security.context')->getToken()->getUser();
        $empleado = $user->getEmpleado();
        $idUnidad = $empleado->getUnidadOrganizativa()->getIdUnidadOrg();
        $unidaDao = new UnidadOrganizativaDao($this->getDoctrine());


        $paoSegumiento = new Pao();
        $paoSegumiento = $unidaDao->getPaoSeguimiento($idUnidad);

        return $paoSegumiento;
    }

    public function consultarObjetivosEspecificosEntControl() {
        $request = $this->getRequest();
        $anio = date('Y') + 1;

        $objTmpDao = new ObjTemplateDao($this->getDoctrine());
        if ($objTmpDao->existeObjTmp($anio) == 0)
            $objTmpDao->agregarObjetivoTemplate($anio);
        $objTmp = $objTmpDao->obtenerObjTempAnio($anio);

        $numfilas = 0;
        $objTmpAux = new ObjTemplate();
        $rows = '';

        $obEspecificos = new ArrayCollection();


        $uniControl = new UnidadOrganizativa();
        $uniControl = $this->obtenerUnidadOrg();
        $resultadosEsperados = $uniControl->getResultadosEsperados();

        foreach ($objTmp as $objTmpAux) {
            $i = 0;
            $objEspTmps = $objTmpAux->getEspecificoObjTmp();
            $aux = new ObjespTemplate();
            $numfilas = count($objEspTmps);

            foreach ($objEspTmps as $aux) {
                $objEspec = $aux->getIdObjEspec();
                $obEspecificos[] = $objEspec;
                //$resultadosEspec = new  ArrayCollection();

                /* foreach ($resultadosEsperados as $resulEspec) {
                  if($resulEspec->getIdObjEsp()->getIdObjEspec()==$objEspec->getIdObjEspec()){
                  $resultadosEspec[]=$resulEspec;
                  $objEspec->addResultadoEsperado($resulEspec);
                  }
                  } */
            }
        }



        return $obEspecificos;
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

    public function obtenerUnidadOrgObjEspec() {

        $user = new User();
        $empleado = new Empleado();
        $user = $this->get('security.context')->getToken()->getUser();
        $empleado = $user->getEmpleado();
        $idUnidad = $empleado->getUnidadOrganizativa()->getIdUnidadOrg();
        $unidaDao = new UnidadOrganizativaDao($this->getDoctrine());
        $unidad = new UnidadOrganizativa();
        $unidad = $unidaDao->getUnidadOrg($idUnidad);

        if ($unidad->getTipoUnidad() == 3) {
            $objetivosEscpec = $this->consultarObjetivosEspecificosEntControl();
        } else {
            $objetivosEscpec = $unidad->getCaractOrg()->getObjetivosEspec();
        }


        return $objetivosEscpec;
    }

    public function ActividadesEnRetrasoJSONAction() {

        $paoElaboracion = $this->obtenerPaoSeguimiento();
        $programacionMonitoreo = $paoElaboracion->getProgramacionMonitoreo();
        $idProgramon = $programacionMonitoreo->getIdPrograMon();
        $trim = 1;
        $promMonDao = new ProgramacionMonitoreoDao($this->getDoctrine());
        $actividadesProgramon = $promMonDao->getActividades($idProgramon, $trim);

        $numfilas = count($actividadesProgramon);

        $i = 0;
        $rows = '';
        $actividad = new Actividad();
        $actividadAux = new Actividad();
        $resultadoActividad = new ResulActividad();
        $objEspec = new ObjetivoEspecifico();
        $resulEspec = new ResultadoEsperado();


        $actividadDao = new ActividadDao($this->getDoctrine());

        $objetivosEscpec = $this->obtenerUnidadOrgObjEspec();


        foreach ($objetivosEscpec as $objEspec) {
            $resultadosEsperados = $objEspec->getResultadoEsperado();

            foreach ($resultadosEsperados as $resulEspec) {
                $actividadesResulEspec = $resulEspec->getActividades();

                foreach ($actividadesResulEspec as $actividadAux) {
                    foreach ($actividadesProgramon as $actividad) {
                        if ($actividadAux->getIdAct() == $actividad->getIdAct()) {

                            $actividad = $actividadDao->getActividad($actividad->getIdAct());
                            $resultadosActividad = $actividad->getResulAct();

                            //   $arrayDatosResulAct=array($objEspec->getDescripcion(),
                            //                           $resulEspec->getResEspeDesc(),
                            //                         $actividad->getIdAct(),
                            //                       $actividad->getActDescripcion()); 

                            foreach ($resultadosActividad as $resultadoActividad) {
                                $rows[$i]['id'] = $resultadoActividad->getIdResulAct();
                                $rows[$i]['cell'] = array($resultadoActividad->getIdResulAct(),
                                    $resultadoActividad->getIdActividad()->getActDescripcion(),
                                    $resultadoActividad->getResulActProgramado(),
                                    $resultadoActividad->getResulActRealizado(),
                                    $resultadoActividad->getResulActFechaFin()
                                );

                                $i++;
                            }
                        }
                    }
                }
            }
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

    public function showActividadesEnRetrasoAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $objetivos = $this->obtenerUnidadOrgObjEspec();

        $paoElaboracion = $this->obtenerPaoSeguimiento();
        $programacionMonitoreo = $paoElaboracion->getProgramacionMonitoreo();
        $idProgramon = $programacionMonitoreo->getIdPrograMon();

        $trimestre = 1;
        $promMonDao = new CompromisoCumplimientoDao($this->getDoctrine());
        $actividadesProgramon = $promMonDao->getActividades($idProgramon, $trimestre);
        $anio=$paoElaboracion->getAnio();
        $idUniOrg=$paoElaboracion->getUnidadOrganizativa()->getIdUnidadOrg();
        $uniControl = new UnidadOrganizativa();
        $uniControl = $this->obtenerUnidadOrg();
        $idUnidad = $uniControl->getIdUnidadOrg();

        $compromisoDao = new CompromisoCumplimientoDao($this->getDoctrine());
        $resultadoActividadDao=new ResulActividadDao($this->getDoctrine());
        

        return $this->render('MinSalSidPlaPrograMonitoreoBundle:CompromisoCumplimiento:CompromisoCumplimiento.html.twig', array('opciones' => $opciones, 'objetivos' => $objetivos, 'actividades' => $actividadesProgramon,
                    'trimestre' => $trimestre, 'idUnidad' => $idUnidad, 'id' => $idProgramon, 'compromisoDao' => $compromisoDao,
                    'anio'=>$anio,'idUniOrg'=>$idUniOrg));
    }

    public function ingresoActividadesEnRetrasoAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $idfila = $request->get('idfila');
        $idfilaResultado = $request->get('idfilaResultado');
        $idfilaActividad = $request->get('idfilaActividad');
        $idResultActividad = $request->get('idresact');
        $trimestre = $request->get('trimestre');

        $resultadoDao = new ResulActividadDao($this->getDoctrine());
        $resAct = $resultadoDao->getResulActividad($idResultActividad);
        $descrObjetivo = $resAct->getIdActividad()->getIdResEsp()->getIdObjEsp()->getDescripcion();
        $descrResultado = $resAct->getIdActividad()->getIdResEsp()->getResEspeDesc();
        $descrActividad = $resAct->getIdActividad()->getActDescripcion();
        $fechaOrigal = DATE_FORMAT($resAct->getResulActFechaFin(), 'd/m/Y');
        $totalReprogramar = $resAct->getResulActProgramado() - $resAct->getResulActRealizado();

        //PARA OBTENER LAS FECHAS DEL DATEPICKER
        $pao = $this->obtenerPaoSeguimiento();
        $periodoPaoAux = new \MinSal\SidPla\PaoBundle\Entity\PeriodoPao();
        foreach ($pao->getPeriodoCalendarizacion() as $periodoPaoAux) {
            switch ($periodoPaoAux->getTipPeriodoPerPao()->getIdTipPer()) {
                case 4://SEGUNDO TRIMESTRE
                    $fechIniTrm2 = $periodoPaoAux->getFechIniPerPao();
                    $fechFinTrm2 = $periodoPaoAux->getFechFinPerPao();
                    break;
                case 5://TERCER TRIMESTRE
                    $fechIniTrm3 = $periodoPaoAux->getFechIniPerPao();
                    $fechFinTrm3 = $periodoPaoAux->getFechFinPerPao();
                    break;
                case 6://CUARTO TRIMESTRE
                    $fechIniTrm4 = $periodoPaoAux->getFechIniPerPao();
                    $fechFinTrm4 = $periodoPaoAux->getFechFinPerPao();
                    break;
            }
        }

        switch ($trimestre) {
            case 1:
                $resultadoTrimestre2 = $resultadoDao->consultarResulActPorTrim(2, $idfilaActividad);
                $resultadoTrimestre3 = $resultadoDao->consultarResulActPorTrim(3, $idfilaActividad);
                $resultadoTrimestre4 = $resultadoDao->consultarResulActPorTrim(4, $idfilaActividad);
                return $this->render('MinSalSidPlaPrograMonitoreoBundle:CompromisoCumplimiento:IngresoCompromisoCumplimiento.html.twig', array('opciones' => $opciones, 'objetivo' => $descrObjetivo, 'actividad' => $descrActividad,
                            'resultado' => $descrResultado, 'idresact' => $idResultActividad, 'idfilaResultado' => $idfilaResultado,
                            'idfila' => $idfila, 'idfilaActividad' => $idfilaActividad, 'trimestre' => $trimestre, 'reprogramar' => $totalReprogramar,
                            'fechaOriginal' => $fechaOrigal, 'trimestre2' => $resultadoTrimestre2, 'trimestre3' => $resultadoTrimestre3, 'trimestre4' => $resultadoTrimestre4,
                            'fechIniTrm2' => $fechIniTrm2, 'fechIniTrm3' => $fechIniTrm3, 'fechIniTrm4' => $fechIniTrm4, 'fechFinTrm2' => $fechFinTrm2, 'fechFinTrm3' => $fechFinTrm3, 'fechFinTrm4' => $fechFinTrm4));
                break;
            case 2:
                $resultadoTrimestre3 = $resultadoDao->consultarResulActPorTrim(3, $idfilaActividad);
                $resultadoTrimestre4 = $resultadoDao->consultarResulActPorTrim(4, $idfilaActividad);
                return $this->render('MinSalSidPlaPrograMonitoreoBundle:CompromisoCumplimiento:IngresoCompromisoCumplimiento.html.twig', array('opciones' => $opciones, 'objetivo' => $descrObjetivo, 'actividad' => $descrActividad,
                            'resultado' => $descrResultado, 'idresact' => $idResultActividad, 'idfilaResultado' => $idfilaResultado,
                            'idfila' => $idfila, 'idfilaActividad' => $idfilaActividad, 'trimestre' => $trimestre, 'reprogramar' => $totalReprogramar,
                            'fechaOriginal' => $fechaOrigal, 'trimestre3' => $resultadoTrimestre3, 'trimestre4' => $resultadoTrimestre4,
                            'fechIniTrm2' => $fechIniTrm2, 'fechIniTrm3' => $fechIniTrm3, 'fechIniTrm4' => $fechIniTrm4, 'fechFinTrm2' => $fechFinTrm2, 'fechFinTrm3' => $fechFinTrm3, 'fechFinTrm4' => $fechFinTrm4));
                break;
            case 3:
                $resultadoTrimestre4 = $resultadoDao->consultarResulActPorTrim(4, $idfilaActividad);
                return $this->render('MinSalSidPlaPrograMonitoreoBundle:CompromisoCumplimiento:IngresoCompromisoCumplimiento.html.twig', array('opciones' => $opciones, 'objetivo' => $descrObjetivo, 'actividad' => $descrActividad,
                            'resultado' => $descrResultado, 'idresact' => $idResultActividad, 'idfilaResultado' => $idfilaResultado,
                            'idfila' => $idfila, 'idfilaActividad' => $idfilaActividad, 'trimestre' => $trimestre, 'reprogramar' => $totalReprogramar,
                            'fechIniTrm2' => $fechIniTrm2, 'fechIniTrm3' => $fechIniTrm3, 'fechIniTrm4' => $fechIniTrm4, 'fechFinTrm2' => $fechFinTrm2, 'fechFinTrm3' => $fechFinTrm3, 'fechFinTrm4' => $fechFinTrm4));
                break;
            case 4:
                $resultadoTrimestre4 = $resultadoDao->consultarResulActPorTrim(4, $idfilaActividad);
                return $this->render('MinSalSidPlaPrograMonitoreoBundle:CompromisoCumplimiento:IngresoCompromisoCumplimiento.html.twig', array('opciones' => $opciones, 'objetivo' => $descrObjetivo, 'actividad' => $descrActividad,
                            'resultado' => $descrResultado, 'idresact' => $idResultActividad, 'idfilaResultado' => $idfilaResultado,
                            'idfila' => $idfila, 'idfilaActividad' => $idfilaActividad, 'trimestre' => $trimestre, 'reprogramar' => $totalReprogramar,
                            'fechIniTrm2' => $fechIniTrm2, 'fechIniTrm3' => $fechIniTrm3, 'fechIniTrm4' => $fechIniTrm4, 'fechFinTrm2' => $fechFinTrm2, 'fechFinTrm3' => $fechFinTrm3, 'fechFinTrm4' => $fechFinTrm4));
                break;
        }
    }

    public function guardarActividadesEnRetrasoAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();

        $idResultActividad = $request->get('idresact');
        $hallazgos = $request->get('hallazgosAct');
        $medidasadoptar = $request->get('medidasAct');
        $responsable = $request->get('responsable');

        $idfila = $request->get('idfila');
        $idfilaResultado = $request->get('idfilaResultado');
        $idfilaActividad = $request->get('idfilaActividad');
        $idCompromiso = $request->get('idcompromiso');
        $idReprogramacion = $request->get('idReprogramacion');
        $operacion=$request->get('oper');

        //OBTIENE LOS VALORES DE REPROGRAMACION
        //segundo trimestre
        $dia = substr($request->get('fechIni2'), 0, 2);
        $mes = substr($request->get('fechIni2'), 3, 2);
        $anio = substr($request->get('fechIni2'), 6, 4);
        $fechIniOrSeg = $anio . '-' . $mes . '-' . $dia;
        $dia = substr($request->get('fechFin2'), 0, 2);
        $mes = substr($request->get('fechFin2'), 3, 2);
        $anio = substr($request->get('fechFin2'), 6, 4);
        $fechFinOrSeg = $anio . '-' . $mes . '-' . $dia;
        $prograOrSeg = $request->get('progra2');
        $dia = substr($request->get('nfechIni2'), 0, 2);
        $mes = substr($request->get('nfechIni2'), 3, 2);
        $anio = substr($request->get('nfechIni2'), 6, 4);
        $fechIniNuSeg = $anio . '-' . $mes . '-' . $dia;
        $dia = substr($request->get('nfechFin2'), 0, 2);
        $mes = substr($request->get('nfechFin2'), 3, 2);
        $anio = substr($request->get('nfechFin2'), 6, 4);
        $fechFinNuSeg = $anio . '-' . $mes . '-' . $dia;
        $prograNuSeg = $request->get('nprogra2');

        //tercer trimestre
        $dia = substr($request->get('fechIni3'), 0, 2);
        $mes = substr($request->get('fechIni3'), 3, 2);
        $anio = substr($request->get('fechIni3'), 6, 4);
        $fechIniOrTer = $anio . '-' . $mes . '-' . $dia;
        $dia = substr($request->get('fechFin3'), 0, 2);
        $mes = substr($request->get('fechFin3'), 3, 2);
        $anio = substr($request->get('fechFin3'), 6, 4);
        $fechFinOrTer = $anio . '-' . $mes . '-' . $dia;
        $prograOrTer = $request->get('progra3');
        $dia = substr($request->get('nfechIni3'), 0, 2);
        $mes = substr($request->get('nfechIni3'), 3, 2);
        $anio = substr($request->get('nfechIni3'), 6, 4);
        $fechIniNuTer = $anio . '-' . $mes . '-' . $dia;
        $dia = substr($request->get('nfechFin3'), 0, 2);
        $mes = substr($request->get('nfechFin3'), 3, 2);
        $anio = substr($request->get('nfechFin3'), 6, 4);
        $fechFinNuTer = $anio . '-' . $mes . '-' . $dia;
        $prograNuTer = $request->get('nprogra3');

        //cuarto trimestre
        $dia = substr($request->get('fechIni4'), 0, 2);
        $mes = substr($request->get('fechIni4'), 3, 2);
        $anio = substr($request->get('fechIni4'), 6, 4);
        $fechIniOrCua = $anio . '-' . $mes . '-' . $dia;
        $dia = substr($request->get('fechFin4'), 0, 2);
        $mes = substr($request->get('fechFin4'), 3, 2);
        $anio = substr($request->get('fechFin4'), 6, 4);
        $fechFinOrCua = $anio . '-' . $mes . '-' . $dia;
        $prograOrCua = $request->get('progra4');
        $dia = substr($request->get('nfechIni4'), 0, 2);
        $mes = substr($request->get('nfechIni4'), 3, 2);
        $anio = substr($request->get('nfechIni4'), 6, 4);
        $fechIniNuCua = $anio . '-' . $mes . '-' . $dia;
        $dia = substr($request->get('nfechFin4'), 0, 2);
        $mes = substr($request->get('nfechFin4'), 3, 2);
        $anio = substr($request->get('nfechFin4'), 6, 4);
        $fechFinNuCua = $anio . '-' . $mes . '-' . $dia;
        $prograNuCua = $request->get('nprogra4');
        //SE OBTUVIERON LOS VALORES DE REPROGRAMACION

        if ($prograNuCua != 0)
            $fechacumplimiento = $fechFinNuCua;
        else
        if ($prograNuTer != 0)
            $fechacumplimiento = $fechFinNuTer;
        else
            $fechacumplimiento = $fechFinNuSeg;
        
        $rDao = new ResulActividadDao($this->getDoctrine());
        $compromisoDao=new CompromisoCumplimientoDao($this->getDoctrine());
        $reprogramacionDao = new ReprogramacionDao($this->getDoctrine());
        switch ($operacion){
            case 'add':
                $compromisoGenerado = $rDao->addCompromisoCumplimiento($hallazgos, $medidasadoptar, $fechacumplimiento, $responsable, $idResultActividad, $idfilaResultado);
                $reprogramacionDao->agregarReprogramacion($fechIniOrSeg, $fechFinOrSeg, $prograOrSeg, $fechIniNuSeg,$fechFinNuSeg, $prograNuSeg, 
                                    $fechIniOrTer, $fechFinOrTer, $prograOrTer, $fechIniNuTer, $fechFinNuTer, $prograNuTer, 
                                    $fechIniOrCua, $fechFinOrCua, $prograOrCua,$fechIniNuCua, $fechFinNuCua, $prograNuCua, $compromisoGenerado);
                break;
            case 'edit':
                $compromisoEditado=$compromisoDao->editCompromisoCumplimiento($idCompromiso, $hallazgos, $medidasadoptar, $fechacumplimiento, $responsable);
                $reprogramacionDao->editarReprogramacion($idReprogramacion, $fechIniOrSeg, $fechFinOrSeg, $prograOrSeg, $fechIniNuSeg, $fechFinNuSeg, $prograNuSeg, $fechIniOrTer, $fechFinOrTer, $prograOrTer, $fechIniNuTer, $fechFinNuTer, $prograNuTer, $fechIniOrCua, $fechFinOrCua, $prograOrCua, $fechIniNuCua, $fechFinNuCua, $prograNuCua, $compromisoEditado);
                break;
            
        }
        
        return $this->showActividadesEnRetrasoAction();
    }

    public function editandoActividadesEnRetrasoAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $idfila = $request->get('idfila');
        $idfilaResultado = $request->get('idfilaResultado');
        $idfilaActividad = $request->get('idfilaActividad');
        $idResultActividad = $request->get('idresact');
        $trimestre = $request->get('trimestre');
        $idCompromisoCumplimiento = $request->get('trimestre');

        $resultadoDao = new ResulActividadDao($this->getDoctrine());
        $resAct = $resultadoDao->getResulActividad($idResultActividad);
        $descrObjetivo = $resAct->getIdActividad()->getIdResEsp()->getIdObjEsp()->getDescripcion();
        $descrResultado = $resAct->getIdActividad()->getIdResEsp()->getResEspeDesc();
        $descrActividad = $resAct->getIdActividad()->getActDescripcion();
        $fechaOrigal = DATE_FORMAT($resAct->getResulActFechaFin(), 'd/m/Y');
        $totalReprogramar = $resAct->getResulActProgramado() - $resAct->getResulActRealizado();
        $compromisoCumplimiento2=$resAct->getCompromisoCumplimiento();
        
        //PARA OBTENER LAS FECHAS DEL DATEPICKER
        $pao = $this->obtenerPaoSeguimiento();
        $periodoPaoAux = new \MinSal\SidPla\PaoBundle\Entity\PeriodoPao();
        foreach ($pao->getPeriodoCalendarizacion() as $periodoPaoAux) {
            switch ($periodoPaoAux->getTipPeriodoPerPao()->getIdTipPer()) {
                case 4://SEGUNDO TRIMESTRE
                    $fechIniTrm2 = $periodoPaoAux->getFechIniPerPao();
                    $fechFinTrm2 = $periodoPaoAux->getFechFinPerPao();
                    break;
                case 5://TERCER TRIMESTRE
                    $fechIniTrm3 = $periodoPaoAux->getFechIniPerPao();
                    $fechFinTrm3 = $periodoPaoAux->getFechFinPerPao();
                    break;
                case 6://CUARTO TRIMESTRE
                    $fechIniTrm4 = $periodoPaoAux->getFechIniPerPao();
                    $fechFinTrm4 = $periodoPaoAux->getFechFinPerPao();
                    break;
            }
        }
        $aux= new CompromisoCumplimiento();
        foreach ($compromisoCumplimiento2 as $aux){
           
            $compromisoCumplimiento=$aux;
           
            
        }
        
       switch ($trimestre) {
            case 1:
                $resultadoTrimestre2 = $resultadoDao->consultarResulActPorTrim(2, $idfilaActividad);
                $resultadoTrimestre3 = $resultadoDao->consultarResulActPorTrim(3, $idfilaActividad);
                $resultadoTrimestre4 = $resultadoDao->consultarResulActPorTrim(4, $idfilaActividad);
                return $this->render('MinSalSidPlaPrograMonitoreoBundle:CompromisoCumplimiento:IngresoCompromisoCumplimiento.html.twig', array('opciones' => $opciones, 'objetivo' => $descrObjetivo, 'actividad' => $descrActividad,
                            'resultado' => $descrResultado, 'idresact' => $idResultActividad, 'idfilaResultado' => $idfilaResultado,'compromisoCumplimiento'=>$compromisoCumplimiento,
                            'idfila' => $idfila, 'idfilaActividad' => $idfilaActividad, 'trimestre' => $trimestre, 'reprogramar' => $totalReprogramar,
                            'fechaOriginal' => $fechaOrigal, 'trimestre2' => $resultadoTrimestre2, 'trimestre3' => $resultadoTrimestre3, 'trimestre4' => $resultadoTrimestre4,
                            'fechIniTrm2' => $fechIniTrm2, 'fechIniTrm3' => $fechIniTrm3, 'fechIniTrm4' => $fechIniTrm4, 'fechFinTrm2' => $fechFinTrm2, 'fechFinTrm3' => $fechFinTrm3, 'fechFinTrm4' => $fechFinTrm4));
                break;
            case 2:
                $resultadoTrimestre3 = $resultadoDao->consultarResulActPorTrim(3, $idfilaActividad);
                $resultadoTrimestre4 = $resultadoDao->consultarResulActPorTrim(4, $idfilaActividad);
                return $this->render('MinSalSidPlaPrograMonitoreoBundle:CompromisoCumplimiento:IngresoCompromisoCumplimiento.html.twig', array('opciones' => $opciones, 'objetivo' => $descrObjetivo, 'actividad' => $descrActividad,
                            'resultado' => $descrResultado, 'idresact' => $idResultActividad, 'idfilaResultado' => $idfilaResultado,'compromisoCumplimiento'=>$compromisoCumplimiento,
                            'idfila' => $idfila, 'idfilaActividad' => $idfilaActividad, 'trimestre' => $trimestre, 'reprogramar' => $totalReprogramar,
                            'fechaOriginal' => $fechaOrigal, 'trimestre3' => $resultadoTrimestre3, 'trimestre4' => $resultadoTrimestre4,
                            'fechIniTrm2' => $fechIniTrm2, 'fechIniTrm3' => $fechIniTrm3, 'fechIniTrm4' => $fechIniTrm4, 'fechFinTrm2' => $fechFinTrm2, 'fechFinTrm3' => $fechFinTrm3, 'fechFinTrm4' => $fechFinTrm4));
                break;
            case 3:
                $resultadoTrimestre4 = $resultadoDao->consultarResulActPorTrim(4, $idfilaActividad);
                return $this->render('MinSalSidPlaPrograMonitoreoBundle:CompromisoCumplimiento:IngresoCompromisoCumplimiento.html.twig', array('opciones' => $opciones, 'objetivo' => $descrObjetivo, 'actividad' => $descrActividad,
                            'resultado' => $descrResultado, 'idresact' => $idResultActividad, 'idfilaResultado' => $idfilaResultado,'compromisoCumplimiento'=>$compromisoCumplimiento,
                            'idfila' => $idfila, 'idfilaActividad' => $idfilaActividad, 'trimestre' => $trimestre, 'reprogramar' => $totalReprogramar,
                            'fechIniTrm2' => $fechIniTrm2, 'fechIniTrm3' => $fechIniTrm3, 'fechIniTrm4' => $fechIniTrm4, 'fechFinTrm2' => $fechFinTrm2, 'fechFinTrm3' => $fechFinTrm3, 'fechFinTrm4' => $fechFinTrm4));
                break;
            case 4:
                $resultadoTrimestre4 = $resultadoDao->consultarResulActPorTrim(4, $idfilaActividad);
                return $this->render('MinSalSidPlaPrograMonitoreoBundle:CompromisoCumplimiento:IngresoCompromisoCumplimiento.html.twig', array('opciones' => $opciones, 'objetivo' => $descrObjetivo, 'actividad' => $descrActividad,
                            'resultado' => $descrResultado, 'idresact' => $idResultActividad, 'idfilaResultado' => $idfilaResultado,'compromisoCumplimiento'=>$compromisoCumplimiento,
                            'idfila' => $idfila, 'idfilaActividad' => $idfilaActividad, 'trimestre' => $trimestre, 'reprogramar' => $totalReprogramar,
                            'fechIniTrm2' => $fechIniTrm2, 'fechIniTrm3' => $fechIniTrm3, 'fechIniTrm4' => $fechIniTrm4, 'fechFinTrm2' => $fechFinTrm2, 'fechFinTrm3' => $fechFinTrm3, 'fechFinTrm4' => $fechFinTrm4));
                break;
        }
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

}

?>
