<?php

namespace AppBundle\Repository;

use Doctrine\DBAL\Connection;

class Tracks
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @return array
     */
    public function getTracks()
    {
        return $this->connection->fetchAll('select * from running_tracks');
    }

    /**
     * @return array
     */
    public function getFirstTrackPoints()
    {
        return $this->connection->fetchAll('select trackPoints from running_tracks limit 1 offset 1 ');
    }

    /**
     * @param Connection $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    /**
     *
     */

    public function persistTrack()
    {
        $this->connection->insert();
    }

}
