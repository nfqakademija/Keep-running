<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MapController extends Controller
{
    public function indexAction(Request $request)
    {
        $repositoryLevels = $this->get('app_bundle.repository.trackslevels');
        $repositoryTracks = $this->get('app_bundle.repository.tracks');
        $trackLevels = $repositoryLevels->getLevels();
        $maxDistance = $repositoryTracks->getMaxDistance();
        $maxDistanceToKilometer = ceil($maxDistance[0]['MAX(`running_tracks`.`trackDistance`)'] / 1000);
        $trackId = $request->query->get('trackId') ?: null;
        $distanceFrom = $request->query->get('distance_from') ?: 2;
        $distanceTo = $request->query->get('distance_to') ?: $maxDistanceToKilometer;
        $difficulty = (integer)$request->query->get('difficulty') ?: null;
        if ($trackId) {
            $track = $repositoryTracks->getTrackById($trackId);
        } else {
            $distance = [];
            $distanceFromKm = (integer)$distanceFrom * 1000;
            $distanceToKm = (integer)$distanceTo * 1000;
            $distance = [
                'distanceFrom' => $distanceFromKm,
                'distanceTo' => $distanceToKm
            ];
            $tracksAfterFilter = $repositoryTracks->getTracksByFilter($distance, $difficulty);
            $countTracksAfterFilter = count($tracksAfterFilter) - 1;
            $randomTrackNumber = rand(0, $countTracksAfterFilter);
            $trackId = $tracksAfterFilter[$randomTrackNumber]['trackId'];
            $track = $repositoryTracks->getTrackById($trackId);
        }
        $points = $track[0]['trackPoints'];
        $trackInformation = $repositoryTracks->getInformationAboutTrack($trackId)[0];
        $trackUrl = $request->getScheme() . '://' . $request->getHttpHost()
            . $request->getPathInfo() . '?trackId=' . $trackId;
        return $this->render('AppBundle:Map:index.html.twig', [
            'points' => $points,
            'tracks_levels' => $trackLevels,
            'max_distance' => $maxDistanceToKilometer,
            'track_info' => $trackInformation,
            'distance_from' => $distanceFrom,
            'distance_to' => $distanceTo,
            'track_url' => $trackUrl
        ]);
    }
}
