<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MapController extends Controller
{
    public function indexAction(Request $request)
    {
        $distance = $request->query->get('distance');
        $difficulty = (integer) $request->query->get('difficulty');
        $repository = $this->get('app_bundle.repository.tracks');
        $repositoryLevels = $this->get('app_bundle.repository.trackslevels');
      echo  count($repository->getTracksByFilter($distance,$difficulty));
        $points = $repository->getFirstTrackPoints();
        $trackLevels=$repositoryLevels->getLevels();
        return $this->render('AppBundle:Map:index.html.twig', [
            'points' => $points[0]['trackPoints'],
        ]);
    }


}
