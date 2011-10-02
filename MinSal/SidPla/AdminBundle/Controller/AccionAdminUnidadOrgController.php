<?php

namespace MinSal\SidPla\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;
use MinSal\SidPla\AdminBundle\EntityDao\DepartametoPaisDao;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\AdminBundle\Entity\Municipio;
use MinSal\SidPla\AdminBundle\Entity\InformacionGeneral;

/**
 * Description of AccionAdminUnidadOrgController
 *
 * @author bagonzalez
 */
class AccionAdminUnidadOrgController extends Controller {

    public function consultarUnidadesOrgAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');

        $unidadOrgDao = new UnidadOrganizativaDao($this->getDoctrine());
        $unidadesOrg = $unidadOrgDao->getUnidadesOrg();

        return $this->render('MinSalSidPlaAdminBundle:UnidadOrganizativa:showAllUnidadesOrganizativas.html.twig'
                        , array('opciones' => $opciones, 'unidadesorg' => $unidadesOrg));
    }

    public function consultarUnidadesOrgJSONAction() {

        $unidadOrgDao = new UnidadOrganizativaDao($this->getDoctrine());
        $unidadesOrg = $unidadOrgDao->getUnidadesOrg();

        $numfilas = count($unidadesOrg);

        $uni = new UnidadOrganizativa();
        $i = 0;

        foreach ($unidadesOrg as $uni) {

            $infogeneral = $uni->getInformacionGeneral();
            if ($infogeneral == null)
                $infogeneral = new InformacionGeneral();


            $rows[$i]['id'] = $uni->getIdUnidadOrg();
            $rows[$i]['cell'] = array($uni->getIdUnidadOrg(),
                $uni->getNombreUnidad(),
                $uni->getDescripcionUnidad(),
                '',
                $infogeneral->getDireccion(),
                $infogeneral->getTelefono());
            $i++;
        }

        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ', ' ', ' ', ' ' . ' ');
        }
        $datos = json_encode($rows);

        $pages = floor($numfilas / 10) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';



        $response = new Response($jsonresponse);
        return $response;
    }

    public function consultarUnidadesOrgJSONSelectAction() {

        $unidadOrgDao = new UnidadOrganizativaDao($this->getDoctrine());
        $unidadesOrg = $unidadOrgDao->getUnidadesOrg();

        $numfilas = count($unidadesOrg);

        $select = "<select>";

        $uni = new UnidadOrganizativa();
        $i = 0;

        foreach ($unidadesOrg as $uni) {

            $infogeneral = $uni->getInformacionGeneral();
            if ($infogeneral == null)
                $infogeneral = new InformacionGeneral();

            $select = $select . "<option value=" . $uni->getIdUnidadOrg() . ">" . $uni->getNombreUnidad() . "</option>";
        }

        $select = $select . "</select>";

        $response = new Response($select);
        return $response;
    }

    public function ingresoNuevaUnidadesOrgAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $departamDao = new DepartametoPaisDao($this->getDoctrine());
        $departamentos = $departamDao->getDepartametos();

        return $this->render('MinSalSidPlaAdminBundle:UnidadOrganizativa:ingresoUnidadOrganizativa.html.twig', array('opciones' => $opciones, 'deptos' => $departamentos));
    }

    public function ingresarUnidadOrgAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();

        $nombreUnidad = $request->get('nombreUnidad');
        $direccion = $request->get('direccion');
        $responsable = $request->get('responsable');
        $telefono = $request->get('telefono');
        $fax = $request->get('fax');
        $tipoUnidad = $request->get('tipoUnidad');
        $unidadPadre = $request->get('unidadPadre');
        $departameto = $request->get('departamento');
        $municipio = $request->get('municipio');
        $descripcion = $request->get('descripcion');

        $unidadOrgDao = new UnidadOrganizativaDao($this->getDoctrine());
        $unidadOrgDao->ingresarUnidadOrg($nombreUnidad, $direccion, $responsable, $telefono, $fax, $tipoUnidad, $unidadPadre, $departameto, $municipio, $descripcion);

        $departamDao = new DepartametoPaisDao($this->getDoctrine());
        $departamentos = $departamDao->getDepartametos();


        return $this->render('MinSalSidPlaAdminBundle:UnidadOrganizativa:manttUnidadesOrganizativas.html.twig', array('opciones' => $opciones,));
    }

    public function consultarMunicipiosJSONAction() {
        $request = $this->getRequest();
        $idDpto = $request->get('departamento');
        $departamDao = new DepartametoPaisDao($this->getDoctrine());
        $municipios = $departamDao->consultarMunicipioDpto($idDpto);

        $numfilas = count($municipios);

        $muni = new Municipio();
        $i = 0;

        foreach ($municipios as $muni) {
            $rows[$i]['id'] = $muni->getIdMunicipio();
            $rows[$i]['cell'] = array($muni->getIdMunicipio(),
                $muni->getNombreMunicipio(),
                $muni->getIdDepto());
            $i++;
        }

        $datos = json_encode($rows);
        $pages = floor($numfilas / 10) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';



        $response = new Response($jsonresponse);
        return $response;
    }

    public function mattUnidadesOrgAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        return $this->render('MinSalSidPlaAdminBundle:UnidadOrganizativa:manttUnidadesOrganizativas.html.twig', array('opciones' => $opciones,));
    }

}

?>
