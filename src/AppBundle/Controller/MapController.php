<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MapController extends Controller
{
    public function kilometersToMeters($kilometers)
    {
        return (float)$kilometers / 1000;
    }

    public function meterToKilometers($meters)
    {
        return (integer)$meters * 1000;
    }

    public function indexAction(Request $request)
    {
        $repositoryLevels = $this->get('app_bundle.repository.trackslevels');
        $repositoryTracks = $this->get('app_bundle.repository.tracks');
        $trackLevels = $repositoryLevels->getLevels();
        $maxDistance = $repositoryTracks->getMaxDistance();
        $tracksMaxDistance = $maxDistance[0]['MAX(`running_tracks`.`trackDistance`)'];
        $trackMaxDistanceKm= ceil( $this->kilometersToMeters($tracksMaxDistance));
        $trackId = $request->query->get('trackId') ?: null;
        $distanceFrom = $request->query->get('distance_from') ?: 2;
        $distanceTo = $request->query->get('distance_to') ?: $trackMaxDistanceKm;
        $difficulty = (integer)$request->query->get('difficulty') ?: null;
        $distance = [];
        $distanceFromKm = $this->meterToKilometers($distanceFrom) ;
        $distanceToKm = $this->meterToKilometers($distanceTo) ;
        $distance = [
            'distanceFrom' => $distanceFromKm,
            'distanceTo' => $distanceToKm
        ];
        if ($trackId) {
            $track = $repositoryTracks->getTrackById($trackId);
            if (!$track) {
                $track = $repositoryTracks->getTracksByFilter($distance, $difficulty);
                $trackId = $track[0]['trackId'];
            }
        } else {
            $track = $repositoryTracks->getTracksByFilter($distance, $difficulty);
            $trackId = $track[0]['trackId'];
        }
        $points = $track[0]['trackPoints'];
        $trackInformation = $repositoryTracks->getInformationAboutTrack($trackId)[0];
        $trackUrl = $request->getScheme() . '://' . $request->getHttpHost()
            . $request->getPathInfo() . '?trackId=' . $trackId;
        return $this->render('AppBundle:Map:index.html.twig', [
            'points' => $points,
            'tracks_levels' => $trackLevels,
            'max_distance' => $trackMaxDistanceKm,
            'track_info' => $trackInformation,
            'distance_from' => $distanceFrom,
            'distance_to' => $distanceTo,
            'track_url' => $trackUrl
        ]);
    }
}
