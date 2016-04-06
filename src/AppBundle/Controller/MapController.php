<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MapController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle:Map:index.html.twig', array(
            // ...
        ));
    }

}
