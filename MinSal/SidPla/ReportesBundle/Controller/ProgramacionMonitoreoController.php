<?php

namespace MinSal\SidPla\ReportesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\PaoBundle\Entity\Pao;
use MinSal\SidPla\PrograMonitoreoBundle\EntityDao\ProgramacionMonitoreoDao;
use \Java;
use \JavaClass;

class ProgramacionMonitoreoController extends Controller {

    public function crearConexion() {
        $memo = new Java('org.postgresql.Driver');
        $drm = new JavaClass("java.sql.DriverManager");

        $host = $this->container->getParameter('database_host');
        $userdb = $this->container->getParameter('database_user');
        $password = $this->container->getParameter('database_password');
        $port = $this->container->getParameter('database_port');
        $db = $this->container->getParameter('database_name');

        $Conn = $drm->getConnection("jdbc:postgresql://" . $host . ":" . $port . "/" . $db, $userdb, $password);
        return $Conn;
    }

    //HOJA DE COMPROMISO CUMPLIMIENTO
    public function reporteCompromisoCumplimientoAction() {
        $request = $this->getRequest();
        $anio = $request->get('anio');
        $trimestre = $request->get('trimestre');
        $uniOrg = $request->get('idUniOrg');
        $idDepen = $request->get('idDepen');

        try {

            $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");
            $report = $compileManager->compileReport(__DIR__ . "/../Resources/jasperReports/reportCompromisoCumplimiento/CompromisoCumplimiento.jrxml");
            $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");

            $params = new Java("java.util.HashMap");
            if (isset($idDepen)) {
                $uniOrg = $idDepen;
                $unidaDao = new UnidadOrganizativaDao($this->getDoctrine());
                $programonDao = new ProgramacionMonitoreoDao($this->getDoctrine());
                $paoSegumiento = new Pao();
                $paoSegumiento = $unidaDao->getPaoSeguimiento($idDepen);
                $anio = $paoSegumiento->getAnio();
                $uniOrg = $idDepen;
                $trimestre = $programonDao->trimestrePao();
            }
            $params->put("ve_anio", new java("java.lang.Integer", $anio));
            $params->put("ve_trimestre", new java("java.lang.Integer", $trimestre));
            $params->put("ve_uniorg", new java("java.lang.Integer", $uniOrg));

            $Conn = $this->crearConexion();

            $jasperPrint = $fillManager->fillReport($report, $params, $Conn);
            $outputPath = realpath(".") . "/" . "output.pdf";

            $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");
            $exportManager->exportReportToPdfFile($jasperPrint, $outputPath);

            header("Content-type: application/pdf");
            readfile($outputPath);
            unlink($outputPath);
            $Conn->close();

            $this->getResponse()->clearHttpHeaders();
            $this->getResponse()->setHttpHeader('Pragma: public', true);
            $this->getResponse()->setContentType('application/pdf');
            $this->getResponse()->sendHttpHeaders();
        } catch (Exception $ex) {
            print $ex->getCause();
            if ($Conn != null) {
                $Conn->close();
            }
            throw $ex;
        }

        return $this->getResponse();
    }

    public function reporteDependenciaInvidualAction() {
        $request = $this->getRequest();
        $unidad = (int) $request->get('idDepen');
        $anio = (int) $request->get('anioConsultar');
        $idDepen = $request->get('idDepen');
        try {
            $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");
            $report = $compileManager->compileReport(__DIR__ . "/../Resources/jasperReports/reportConsolidadoIndividualDep/consolidadocentral.jrxml");
            $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");

            $params = new Java("java.util.HashMap");
            if (isset($idDepen)) {
                $unidaDao = new UnidadOrganizativaDao($this->getDoctrine());
                $programonDao = new ProgramacionMonitoreoDao($this->getDoctrine());
                $paoSegumiento = new Pao();
                $paoSegumiento = $unidaDao->getPaoElaboracion($idDepen);
                $anio = $paoSegumiento->getAnio();
                $unidad=$idDepen;
            }
            $params->put("anioPao", new java("java.lang.Integer", $anio)); //asignando valor al parametro
            $params->put("idUnidadOrg", new java("java.lang.Integer", $unidad)); //asignando valor al parametro

            $Conn = $this->crearConexion();

            $jasperPrint = $fillManager->fillReport($report, $params, $Conn);

            $outputPath = realpath(".") . "/" . "output.pdf"; //mostrar el reporte en pdf
            $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");
            $exportManager->exportReportToPdfFile($jasperPrint, $outputPath);
            header("Content-type: application/pdf");
            readfile($outputPath);
            unlink($outputPath);
            $Conn->close();
            $this->getResponse()->clearHttpHeaders();
            $this->getResponse()->setHttpHeader('Pragma: public', true);
            $this->getResponse()->setContentType('application/pdf');
            $this->getResponse()->sendHttpHeaders();
        } catch (Exception $ex) {
            print $ex->getCause();
            if ($Conn != null) {
                $Conn->close();
            }
            throw $ex;
        }
        return $this->getResponse();
    }

}

?>
