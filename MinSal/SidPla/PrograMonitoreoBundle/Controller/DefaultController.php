<?php

namespace MinSal\SidPla\PrograMonitoreoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('MinSalSidPlaPrograMonitoreoBundle:Default:index.html.twig');
    }
}
