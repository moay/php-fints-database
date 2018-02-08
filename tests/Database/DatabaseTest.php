<?php

namespace moay\FintsDatabase\Test\Database;

use moay\FintsDatabase\Database\Database;
use moay\FintsDatabase\Exception\DatabaseFileNotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * Class DatabaseTest
 * @package moay\FintsDatabase\Test\Database
 */
class DatabaseTest extends TestCase
{
    private $testFile = __DIR__ . '/../../vendor/moay/fints-db/fints-institutes.json';

    public function tearDown()
    {
        if (file_exists($this->testFile . 'tmp')) {
            if (file_exists($this->testFile)) {
                unlink($this->testFile);
            }
            rename($this->testFile . 'tmp', $this->testFile);
        }
    }

    public function testThrowsExceptionIfDatabaseDoesNotExist()
    {
        if (file_exists($this->testFile)) {
            rename($this->testFile, $this->testFile . 'tmp');
        }
        $this->expectException(DatabaseFileNotFoundException::class);
        $database = new Database();
    }

    public function testLoadsDatabaseFileProperly()
    {
        if (file_exists($this->testFile)) {
            rename($this->testFile, $this->testFile . 'tmp');
        }

        $testFileContents = '[{"name":"test"}]';

        file_put_contents($this->testFile, $testFileContents);
        $database = new Database();
        $this->assertTrue(count($database->search('test')) == 1);
        $this->assertTrue(count($database->search('test2')) == 0);
        unlink($this->testFile);
    }
}