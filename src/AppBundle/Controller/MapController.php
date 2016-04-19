<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MapController extends Controller
{
    public function indexAction()
    {
        $repository = $this->get('app_bundle.repository.tracks');
        $tracks = $repository->getTracks();
        var_dump($tracks);
        return $this->render('AppBundle:Map:index.html.twig', [
            'tracks' => [],
        ]);
    }


}
