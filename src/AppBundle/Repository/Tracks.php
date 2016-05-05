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
    public function getMaxDistance()
    {
        $sql = 'SELECT MAX(`running_tracks`.`trackDistance`) FROM `running_tracks` ';
        return $this->connection->fetchAll($sql);
    }

    /**
     * @return array
     */
    public function getTracksByFilter($distance = null, $difficulty = null)
    {
        $sql = 'SELECT `running_tracks`.`trackId` FROM `running_tracks` WHERE TRUE';
        if ($distance) {
            $distanceFrom = $distance['distanceFrom'];
            $distanceTo = $distance['distanceTo'];
            $sql .= ' AND `running_tracks`.`trackDistance` BETWEEN ' . $distanceFrom . ' AND ' . $distanceTo;
        }
        if ($difficulty) {
            $sql .= ' AND `running_tracks`.`trackLevelId` = ' . $difficulty;
        }
        return $this->connection->fetchAll($sql);
    }

    /**
     * @return array
     */
    public function getTrackById($trackId)
    {
        $sql = 'SELECT `running_tracks`.`trackPoints`,`running_tracks`.`trackDistance`FROM `running_tracks` ';
        if ($trackId) {
            $sql .= 'WHERE `running_tracks`.`trackId`=' . (integer)$trackId;
        }
        $sql .= ' LIMIT 1';
        return $this->connection->fetchAll($sql);
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

    public function persistTrack($trackPoints, $start1, $start2, $distance, $difficulty, $name)
    {
        $this->connection->insert(
            'running_tracks',
            [
                'trackStartPointLongtitude' => $start1,
                'trackStartPointLatitude' => $start2,
                'trackPoints' => $trackPoints,
                'trackDistance' => $distance,
                'trackLevelId' => $difficulty,
                'trackName' => $name
            ]
        );
    }

    public function eraseTrack()
    {
        $this->connection->exec('TRUNCATE running_tracks');
    }

    /**
     * @return array
     */
    public function getInformationAboutTrack($trackId)
    {
        $sql = 'SELECT `running_tracks`.`trackDistance`,`running_tracks`.`trackName`, '
        .'`running_tracks_level`.`levelName`,`running_tracks_level`.`levelId`  '
            .'FROM `running_tracks` '
            .'LEFT JOIN `running_tracks_level` ON `running_tracks_level`.`levelId`=`running_tracks`.`trackLevelId` '
            .'WHERE `running_tracks`.`trackId`='.$trackId.' '
            .'LIMIT 1';
        return $this->connection->fetchAll($sql);
    }
}
