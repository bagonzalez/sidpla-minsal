<?php

namespace MinSal\SidPla\ReportesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\PaoBundle\Entity\Pao;
use \Java;
use \JavaClass;

class PaoController extends Controller {

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

    public function reporteJustificacionAction() {
        $request = $this->getRequest();
        $JustiPao = $request->get('justificacion');
        $id = $request->get('id');
        $idUniSal=$request->get('idUniSal');
        try {

            $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");
            $report = $compileManager->compileReport(__DIR__ . "/../Resources/jasperReports/reportJustificacion/reporteJustificacion.jrxml");
            $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");

            $params = new Java("java.util.HashMap");
            if(isset($idUniSal)){
                $unidaDao = new UnidadOrganizativaDao($this->getDoctrine());
                $paoSegumiento = new Pao();
                $paoSegumiento = $unidaDao->getPaoSeguimiento($idUniSal);
                $id=$paoSegumiento->getJustificacion()->getIdJustificacion();
                
            }
            $params->put("idJustificacion", new java("java.lang.Integer", $id));

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
    
    
    
    public function reporteIndicadoresSaludAction() {
        $request = $this->getRequest();
        
        $id = $request->get('id');
        $idUniSal=$request->get('idUniSal');
        try {

            $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");
            $report = $compileManager->compileReport(__DIR__ . "/../Resources/jasperReports/reportIndicadoresSalud/reportIndicadoresSaludPorUnidad.jrxml");
            $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");

            $params = new Java("java.util.HashMap");
            if(isset($idUniSal)){
                $unidaDao = new UnidadOrganizativaDao($this->getDoctrine());
                $paoSegumiento = new Pao();
                $paoAnioAnt = new Pao();
                $paoSegumiento = $unidaDao->getPaoSeguimiento($idUniSal);
                $paoAnioAnt=$unidaDao->getPaoAnioAnterior($idUniSal);
                $idPaoActual=$paoSegumiento->getIdPao();
                $idPaoAnterior=$paoAnioAnt->getIdPao();
                
            }
            $params->put("paoActual", new java("java.lang.Integer", $idPaoActual));
            $params->put("paoAnterior", new java("java.lang.Integer", $idPaoAnterior));
            
            

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
