<?php

namespace MinSal\SidPla\IndicadoresTemplateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('MinSalSidPlaIndicadoresTemplateBundle:Default:index.html.twig', array('name' => $name));
    }
}
