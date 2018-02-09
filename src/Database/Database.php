<?php

namespace moay\FintsDatabase\Database;

use moay\FintsDatabase\Bank\Bank;
use moay\FintsDatabase\Bank\BankFactory;
use moay\FintsDatabase\Exception\DatabaseFileInvalidException;
use moay\FintsDatabase\Exception\DatabaseFileNotFoundException;

/**
 * Class Database
 * @package moay\FintsDatabase\Database
 */
class Database
{
    const DATABASE_FILE = 'fints-db' . DIRECTORY_SEPARATOR . 'fints-institutes.json';

    /** @var array */
    private $instituteData;

    /**
     * Database constructor.
     * @param string $databaseFile
     * @throws DatabaseFileNotFoundException
     */
    public function __construct(string $databaseFile = '')
    {
        $this->loadDatabase($databaseFile);
    }

    /**
     * Searches for banks
     *
     * @param $string
     * @param bool $searchBlz
     * @param bool $searchName
     * @param bool $searchLocation
     * @param bool $searchOrganisation
     * @return Bank[]
     */
    public function search(
        $string,
        $searchBlz = true,
        $searchName = true,
        $searchLocation = true,
        $searchOrganisation = true
    ) {
        $matches = [];
        foreach ($this->instituteData as $institute) {
            $cleanedString = preg_replace('/[ \-\_]/', '', $string);
            if ($searchBlz && isset($institute->blz) && strpos($institute->blz, $cleanedString) !== false) {
                $matches[] = $institute;
                continue;
            }
            if ($searchName && isset($institute->name) && stripos($institute->name, $string) !== false) {
                $matches[] = $institute;
                continue;
            }
            if ($searchLocation && isset($institute->location) && stripos($institute->location, $string) !== false) {
                $matches[] = $institute;
                continue;
            }
            if ($searchOrganisation && isset($institute->organisation) && stripos($institute->organisation, $string) !== false) {
                $matches[] = $institute;
                continue;
            }
        }

        $banks = [];
        foreach ($matches as $matchedInstitute) {
            $banks[] = BankFactory::create($matchedInstitute);
        }
        return $banks;
    }

    /**
     * Gets a bank by it's id
     *
     * @param int $id
     * @return Bank|null
     */
    public function getBankById(int $id)
    {
        foreach ($this->instituteData as $institute) {
            if ($institute->number == $id) {
                return BankFactory::create($institute);
            }
        }
        return null;
    }

    /**
     * Loads the institutions data
     *
     * @param string $databaseFile
     * @throws DatabaseFileNotFoundException
     * @throws DatabaseFileInvalidException
     */
    private function loadDatabase(string $databaseFile)
    {
        if ($databaseFile != '') {
           $path = $databaseFile;
        } else {
            $path = $this->determineDatabaseLocation();
        }
        if (!($this->instituteData = json_decode(file_get_contents($path)))) {
           throw new DatabaseFileInvalidException('Database file contains invalid json.');
        }
    }

    /**
     * Searches for the database file and returns it's location
     *
     * @return string
     * @throws DatabaseFileNotFoundException
     */
    private function determineDatabaseLocation()
    {
        // If both the library and the database file are located in the vendors folder
        $path1 = join(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', '..', self::DATABASE_FILE]);

        // If working with the library itself
        $path2 = join(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', 'vendor', 'moay', self::DATABASE_FILE]);

        if (file_exists($path1)) {
            return $path1;
        }
        if (file_exists($path2)) {
            return $path2;
        }
        throw new DatabaseFileNotFoundException('FinTS database file could not be found');
    }
}