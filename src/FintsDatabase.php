<?php

namespace moay\FintsDatabase;

use moay\FintsDatabase\Bank\Bank;
use moay\FintsDatabase\Database\Database;

/**
 * Class FintsDatabase
 * @package moay\FintsDatabase
 */
class FintsDatabase
{
    /**
     * Searches all banks where one of the identifying fields contains the query string
     *
     * @param string $query
     * @return Bank[]
     * @throws DatabaseFileNotFoundException
     */
    public static function search(string $query): array
    {
        $database = new Database();
        return $database->search($query);
    }

    /**
     * Searches for
     *
     * @param int $id
     * @return Bank|null
     * @throws DatabaseFileNotFoundException
     */
    public static function getBankById(int $id)
    {
        $database = new Database();
        return $database->getBankById($id);
    }
}