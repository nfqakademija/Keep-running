<?php
/**
 * Created by PhpStorm.
 * User: vaidotas
 * Date: 16.4.23
 * Time: 19.48
 */

namespace AppBundle\Repository;

use Doctrine\DBAL\Connection;

class TracksLevels
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @return array
     */
    public function getLevels()
    {
        $sql = 'SELECT * FROM `running_tracks_level` '
            . 'ORDER BY  `running_tracks_level`.`levelId`';
        return $this->connection->fetchAll($sql);
    }

    /**
     * @param Connection $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }
}
