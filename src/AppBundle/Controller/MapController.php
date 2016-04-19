<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MapController extends Controller
{
    public function indexAction()
    {
        $repository = $this->get('app_bundle.repository.tracks');
        $points = $repository->getFirstTrackPoints();
        var_dump($points[0]['trackPoints']);
        return $this->render('AppBundle:Map:index.html.twig', [
            'points' => $points[0]['trackPoints'],
        ]);
    }


}
