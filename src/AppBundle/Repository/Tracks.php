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
    public function getTracksByFilter($distance=NULL,$difficulty=NULL)
    {
        $sql='SELECT `running_tracks`.`trackId` FROM `running_tracks` WHERE TRUE';
        if($distance)
            $sql.=' AND `running_tracks`.`trackDistance` BETWEEN 0 AND '.$distance ;
        if($difficulty)
            $sql.=' AND `running_tracks`.`trackLevelId` = '.$difficulty;
        return $this->connection->fetchAll($sql);
    }
    /**
     * @return array
     */
    public function getTrackById($trackId)
    {
        $sql='SELECT `running_tracks`.`trackPoints`,`running_tracks`.`trackDistance`FROM `running_tracks` ';
        if($trackId)
            $sql.= 'WHERE `running_tracks`.`trackId`='.(integer)$trackId;
        $sql.=' LIMIT 1';
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

}
