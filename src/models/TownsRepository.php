<?php


namespace app\models;


use app\DB;
use PDO;


/**
 * Class TownsRepository
 * @package app\model
 */
class TownsRepository
{

    /**
     * @return TownsList
     */
    public function getAll(): TownsList
    {
        $db = DB::getInstance();
        DB::setCharsetEncoding();

        $sql = 'SELECT * FROM towns ORDER BY town';
        $stm = $db->prepare($sql);

        $stm->execute();

        return TownsList::fromPDO($stm->fetchAll(PDO::FETCH_CLASS));
    }

    /**
     * @param string $id
     * @return Town
     */
    public function getById(string $id): Town
    {
        $db = DB::getInstance();
        DB::setCharsetEncoding();

        $sql = 'SELECT * FROM towns WHERE id = :id';

        $stm = $db->prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);

        /// $stm->setFetchMode(PDO::FETCH_ASSOC, 'Town', ['id', 'town']);
        $stm->execute();
        $row = $stm->fetch(PDO::FETCH_ASSOC);

        return new Town($row['id'], $row['town']);
    }
}