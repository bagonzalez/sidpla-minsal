<?php


/*

  SIDPLA - MINSAL
  Copyright (C) 2011  Bruno González   e-mail: bagonzalez.sv EN gmail.com
  Copyright (C) 2011  Universidad de El Salvador

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.


 */

namespace MinSal\SidPla\ReportesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\PaoBundle\Entity\Pao;
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
        $id = $request->get('id');
        $idDepen=$request->get('idDepen');
        
        try {

            $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");
            $report = $compileManager->compileReport(__DIR__ . "/../Resources/jasperReports/reportProgMonito/reportActividadesAtrasadas.jrxml");
            $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");

            $params = new Java("java.util.HashMap");
            if(isset($idDepen)){
                $unidaDao = new UnidadOrganizativaDao($this->getDoctrine());
                $paoSegumiento = new Pao();
                $paoSegumiento = $unidaDao->getPaoSeguimiento($idDepen);
                $id=$paoSegumiento->getProgramacionMonitoreo()->getIdPrograMon();
                
            }
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
        $tipoUnidad = $request->get('tipoUnidadec');
        $anio = $request->get('anioec');

        try {
            //compilado reporte y cargando en memoria
            $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");
            $report = $compileManager->compileReport(__DIR__ . "/../Resources/jasperReports/reportMatrizdeObjetivosyResultados/reportMatrizdeObetivosMaestro.jrxml");
            $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
            //pasando parametros al reporte
            $params = new Java("java.util.HashMap");
            $params->put("tipoUnidad", new java("java.lang.String", $tipoUnidad)); //asignando valor al parametro
            $params->put("anioPao", new java("java.lang.Integer", $anio));
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
         $params->put("anioPao", new java("java.lang.Integer", $anio)); //asignando valor al parametro
         
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

    
    public function reporteCaracOrgAction() {
       $request = $this->getRequest();
       $idUnidad = $request->get('idUnidad');
       $idDepen=$request->get('idDepen');
      
     try {
         $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");
         $report = $compileManager->compileReport(__DIR__ . "/../Resources/jasperReports/reportCaracteristicasOrg/reportCaractOrgMaster.jrxml");
         $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
         
         $params = new Java("java.util.HashMap");
         if(isset($idDepen)){
                $idUnidad=$idDepen;
                
            }
         $params->put("idUorg", new java("java.lang.Integer", $idUnidad)); //asignando valor al parametro
         
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
