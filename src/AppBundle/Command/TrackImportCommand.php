<?php
/**
 * Created by PhpStorm.
 * User: povilas
 * Date: 16.4.24
 * Time: 19.02
 */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TrackImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('track:import')
            ->setDescription('Read and list files and convert them to sql data')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $repository = $this->getContainer()->get('app_bundle.repository.tracks');
        $repository->eraseTrack();
        $path  = './data/Tracks/';
        foreach (glob($path ."*/*.gpx") as $file) {
            list($fileName,$extension)=explode('.',basename($file));
            $trackDistance=(integer)$fileName;
            $file = simplexml_load_string(file_get_contents($file));
            $points = [];
            foreach ($file->{'trk'}->{'trkseg'}->{'trkpt'} as $point) {
                $points[] = [
                    'lat' => (string) $point['lat'],
                    'lon' => (string) $point['lon'],
                ];
            }
            $pointsInJson = json_encode(['points' => $points]);
            $startLat= $points[0]['lat'];
            $startLon =$points[0]['lon'];
            $trackDifficulty=rand(1,3);
            // persist to mysql
            $repository->persistTrack($pointsInJson, $startLat,$startLon,$trackDistance,$trackDifficulty);
        }
    }

}