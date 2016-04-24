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
        $path  = './data/Tracks/';

$files = array();
        foreach (glob($path ."*.gpx") as $file) {
            $files[] = $json = json_encode(simplexml_load_string(file_get_contents($file)));
           // $files[] = file_get_contents($file);
        }
        $output->writeln($files);
    }
}