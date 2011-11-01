<?php

namespace MinSal\SidPla\ReportesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Java;
use \JavaClass;

class DefaultController extends Controller {

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

    public function indexAction() {
        return $this->render('MinSalSidPlaReportesBundle:Default:index.html.twig');
    }

    public function reporteActividadesAtrasadasAction() {
        $request = $this->getRequest();
        //  $JustiPao=$request->get('justificacion');            
        $id = $request->get('id');
        //$id="874";
        try {

            $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");
            $report = $compileManager->compileReport(__DIR__ . "/../Resources/jasperReports/reportProgMonito/reportActividadesAtrasadas.jrxml");
            $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");

            $params = new Java("java.util.HashMap");
            $params->put("idPrograMonit", new java("java.lang.Integer", $id));

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

    public function reporteMatrizdeObjetivosyResultadosAction() {
        $request = $this->getRequest();
        $tipoUnidad = $request->get('tipoUnidad');

        try {
            //compilado reporte y cargando en memoria
            $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");
            $report = $compileManager->compileReport(__DIR__ . "/../Resources/jasperReports/reportMatrizdeObjetivosyResultados/reportMatrizdeObetivosMaestro.jrxml");
            $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
            //pasando parametros al reporte
            $params = new Java("java.util.HashMap");
            $params->put("tipoUnidad", new java("java.lang.Integer", $tipoUnidad)); //asignando valor al parametro

            $Conn = $this->crearConexion();
            //se llena el reporte con la informacion y parametros 
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

    public function reporteConsolidadoNivelCentralAction() {
       $request = $this->getRequest();
       $tipoUnidad = $request->get('tipoUnidad');
       $anio = $request->get('anio');
     try {
         $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");
         $report = $compileManager->compileReport(__DIR__ . "/../Resources/jasperReports/reportConsolidadosDep/consolidadocentral.jrxml");
         $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
         $params = new Java("java.util.HashMap");
         $params->put("tipoUnidad", new java("java.lang.String", $tipoUnidad)); //asignando valor al parametro
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
        } 
        catch (Exception $ex) {
            print $ex->getCause();
            if ($Conn != null) {
                $Conn->close();
            }
        throw $ex;
        }
        return $this->getResponse();
    }

}
