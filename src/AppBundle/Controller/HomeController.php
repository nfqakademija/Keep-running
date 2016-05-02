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
        $repository = $this->get('app_bundle.repository.trackslevels');
        $trackLevels = $repository->getLevels();
        return $this->render('AppBundle:Home:index.html.twig', array(
            'tracks_levels' => $trackLevels
        ));
    }
}
