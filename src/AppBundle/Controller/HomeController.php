<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * Home page index action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Home:index.html.twig', array(
            // ...
        ));
    }

    public function aboutAction()
    {

        return $this->render('AppBundle:Home:about.html.twig');
    }

}
