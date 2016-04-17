<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MapController extends Controller
{
    public function indexAction()
    {
        $repository = $this->get('app_bundle.repository');
        $tracks = $repository->getTracks();

        return $this->render('AppBundle:Map:index.html.twig', [
            'tracks' => $tracks,
        ]);
    }


}
