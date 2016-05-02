<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MapController extends Controller
{
    public function indexAction(Request $request)
    {
        $distance = $request->query->get('distance')?:NULL;
        $distanceToKm = $distance*1000;
        $difficulty = (integer) $request->query->get('difficulty')?:NULL;
        $repository = $this->get('app_bundle.repository.tracks');
        $tracksAfterFilter=$repository->getTracksByFilter($distanceToKm,$difficulty);
        $countTracksAfterFilter=count($tracksAfterFilter)-1;
        $randomTrackNumber=rand(0,$countTracksAfterFilter);
        $trackId=$tracksAfterFilter[$randomTrackNumber]['trackId'];
        $track=$repository->getTrackById($trackId);
        $points = $track[0]['trackPoints'];
        echo $trackId;
        return $this->render('AppBundle:Map:index.html.twig', [
            'points' => $points,
        ]);
    }


}
