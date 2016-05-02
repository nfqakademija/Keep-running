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
        $repositoryLevels = $this->get('app_bundle.repository.trackslevels');
        $repositoryTracks = $this->get('app_bundle.repository.tracks');
        $trackLevels = $repositoryLevels->getLevels();
        $maxDistance = $repositoryTracks->getMaxDistance();
        $maxDistanceToKilometer = ceil($maxDistance[0]['MAX(`running_tracks`.`trackDistance`)'] / 1000);
        return $this->render('AppBundle:Home:index.html.twig', array(
            'tracks_levels' => $trackLevels,
            'max_distance' => $maxDistanceToKilometer
        ));
    }
}
