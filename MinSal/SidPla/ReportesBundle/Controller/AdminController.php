<?php

namespace MinSal\SidPla\ReportesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Java;
use \JavaClass;

class AdminController extends Controller {

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

    //Reporte informacion general de las inidades organizativas.
    public function reporteInfoGeneralAction() {
            
        //$id = "Reporte";
        try {
            // obtiene la ruta del reporte 
            $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");
            $report = $compileManager->compileReport(__DIR__ . "/../Resources/jasperReports/reportInfoGeneralUniOrg/ReporteInfoGeneral.jrxml");
            $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");

            $params = new Java("java.util.HashMap");
          //  $params->put("nomrepot", new java("java.lang.String", $id));

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

    //Reporte Empleados de Unidades organizativas.
    public function reporteEmpleadosOrgAction() {
         try {
            // obtiene la ruta del reporte 
            $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");
            $report = $compileManager->compileReport(__DIR__ . "/../Resources/jasperReports/reportEmpleadosUnidad/reportEmpleadosUnidadOrg.jrxml");
            $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");

            $params = new Java("java.util.HashMap");
           // $params->put("nomrepot", new java("java.lang.String", $id));

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
    
    public function reporteFormulario1Action() {
        $request=$this->getRequest();
        $idUniOrg=$request->get('unidadorgcod');           
        $idDepen=$request->get('idDepen');
        try {
            // obtiene la ruta del reporte 
            $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");
            $report = $compileManager->compileReport(__DIR__ . "/../Resources/jasperReports/reportInfoGeneralUniOrg/ReporteInfoEspecifico.jrxml");
            $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");

            $params = new Java("java.util.HashMap");
            if(isset($idDepen))
                $idUniOrg=$idDepen;
                
            $params->put("ve_uniorg", new java("java.lang.Integer", $idUniOrg));

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

}

?>
