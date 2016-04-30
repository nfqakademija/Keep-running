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

    public function persistTrack($trackPoints, $start1, $start2)
    {
        $this->truncateRecords();
        $this->connection->insert('running_tracks',
            [
                'trackStartPointLongtitude' => $start1,
                'trackStartPointLatitude' => $start2,
                'trackPoints' => $trackPoints,
                'trackDistance' => 5000,
                'trackLevelId' => 1
            ]);
    }

    private function truncateRecords()
    {
        $this->connection->query('truncate running_tracks;');
    }
}
