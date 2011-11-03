<?php

namespace MinSal\SidPla\CensoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\CensoBundle\EntityDao\CategoriaCensoDao;
use MinSal\SidPla\CensoBundle\Entity\CategoriaCenso;
use MinSal\SidPla\CensoBundle\Form\Type\CategoriaCesoType;

class AccionAdminCategoriaCensoController extends Controller {

    public function manttCatCensoAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        return $this->render('MinSalSidPlaCensoBundle:CategoriaCenso:manttCategoriaCenso.html.twig', array('opciones' => $opciones));
    }

    public function ingresarCategoriaFormAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $categoria = new CategoriaCenso();

        $form = $this->createForm(new CategoriaCesoType(), $categoria);
        return $this->render('MinSalSidPlaCensoBundle:CategoriaCenso:ingresoCategoriaCenso.html.twig', array('form' => $form->createView(), 'opciones' => $opciones));
    }

    public function consultarCategoriaCensoJSONAction() {

        $request = $this->getRequest();
        $categoriaDao = new CategoriaCensoDao($this->getDoctrine());
        $categorias = $categoriaDao->getCategorias();

        $numfilas = count($categorias);


        $i = 0;

        $categoria = new CategoriaCenso();

        foreach ($categorias as $categoria) {

            $rows[$i]['id'] = $categoria->getIdCategoriaCenso();
            $rows[$i]['cell'] = array($categoria->getIdCategoriaCenso(),
                $categoria->getDescripcionCategoria(),
                $categoria->getActivo(),
                $categoria->getDivTabla(),
                $categoria->getBloque()->getNombreBloque()
            );
             if ($categoria->getActivo())
                $rows[$i]['cell'][2] = 'SI';
            else
                $rows[$i]['cell'][2] = 'NO';
            $i++;
        }

        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ', ' ', ' ',' ');
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

    public function addCategoriaAction(Request $peticion) {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $categoria = new CategoriaCenso();
        $form = $this->createForm(new CategoriaCesoType(), $categoria);

        if ($peticion->getMethod() == 'POST') {
            $form->bindRequest($peticion);

            if ($form->isValid()) {
                $catCensoDao = new CategoriaCensoDao($this->getDoctrine());
                $mensajesSistema = $catCensoDao->addCategoria($categoria);
                return $this->render('MinSalSidPlaCensoBundle:CategoriaCenso:manttCategoriaCenso.html.twig', array('mensaje' => $mensajesSistema[0], 'opciones' => $opciones));
            }
        }
        return $this->redirect($this->generateUrl('MinSalSidPlaCensoBundle_manttCatCenso'));
    }

}

?>
