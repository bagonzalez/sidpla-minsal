<?php

namespace MinSal\SidPlaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('MinSalSidPlaBundle:Default:index.html.twig', array('name' => $name));
    }
}
