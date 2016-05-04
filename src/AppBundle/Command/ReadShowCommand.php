<?php

/**
 * Created by PhpStorm.
 * User: povilas
 * Date: 16.4.24
 * Time: 12.36
 */
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ReadShowCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('read:run')
            ->setDescription('Read and list files');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = './data/Tracks';
        $files = scandir($dir);
        $output->writeln($files);
    }
}