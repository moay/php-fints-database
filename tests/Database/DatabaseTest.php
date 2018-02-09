<?php

namespace moay\FintsDatabase\Test\Database;

use moay\FintsDatabase\Bank\Bank;
use moay\FintsDatabase\Database\Database;
use moay\FintsDatabase\Exception\DatabaseFileInvalidException;
use moay\FintsDatabase\Exception\DatabaseFileNotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * Class DatabaseTest
 * @package moay\FintsDatabase\Test\Database
 */
class DatabaseTest extends TestCase
{
    private $testFile = __DIR__ . '/../../vendor/moay/fints-db/fints-institutes.json';
    private $customTestFile = __DIR__ . '/../../tests/customfile.tmp';

    public function tearDown()
    {
        if (file_exists($this->testFile . 'tmp')) {
            if (file_exists($this->testFile)) {
                unlink($this->testFile);
            }
            rename($this->testFile . 'tmp', $this->testFile);
        }
        if (file_exists($this->customTestFile)) {
            unlink($this->customTestFile);
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

    public function testThrowsExceptionIfDatabaseIsInvalid()
    {
        $customConfig = '[{}}]';
        file_put_contents($this->customTestFile, $customConfig);

        $this->expectException(DatabaseFileInvalidException::class);
        $database = new Database($this->customTestFile);
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

    public function testDatabaseReturnsBankObjects()
    {
        $customConfig = '[{"number":"1", "blz": "1"}]';
        file_put_contents($this->customTestFile, $customConfig);

        $database = new Database($this->customTestFile);
        $banks = $database->search('1');
        $this->assertInstanceOf(Bank::class, $banks[0]);
        $bank = $database->getBankById('1');
        $this->assertInstanceOf(Bank::class, $bank);
    }

    public function testDatabaseLoadsCustomDatabaseFileProperlyIfProvided(){
        $customConfig = '[
        {"blz": "1"},
        {"name": "2"},
        {"organisation": "3"},
        {"location": "4"}
        ]';
        file_put_contents($this->customTestFile, $customConfig);

        $database = new Database($this->customTestFile);
        $this->assertCount(1, $database->search('4'));
        $banks = $database->search('2');
        $this->assertEquals(null, $banks[0]->getId());
        $this->assertEquals('2', $banks[0]->getName());
    }

    public function testDatabaseSearchWorksAsExpected(){
        $customConfig = '[
        {"blz": "1"},
        {"name": "2"},
        {"location": "3"},
        {"organisation": "4"},
        {"blz": "5", "location": "5"},
        {"blz": "6", "location": "7"},
        {"blz": "8", "location": "6"}
        ]';
        file_put_contents($this->customTestFile, $customConfig);

        $database = new Database($this->customTestFile);
        $this->assertCount(1, $database->search('1'));
        $this->assertCount(1, $database->search('2'));
        $this->assertCount(1, $database->search('3'));
        $this->assertCount(1, $database->search('4'));
        $this->assertCount(1, $database->search('5'));
        $this->assertCount(2, $database->search('6'));

        $banks = $database->search('7');
        $this->assertCount(1, $banks);
        $this->assertEquals("6", $banks[0]->getBlz());

        $this->assertCount(0, $database->search('1',0));
        $this->assertCount(1, $database->search('2',0));
        $this->assertCount(0, $database->search('2',1, 0));
        $this->assertCount(0, $database->search('3',1,1,0));
        $this->assertCount(0, $database->search('4',1,1,1,0));
    }
}