<?php

namespace moay\FintsDatabase\Test;

use moay\FintsDatabase\Bank\Bank;
use moay\FintsDatabase\FintsDatabase;
use PHPUnit\Framework\TestCase;

/**
 * Class FintsDatabaseTest
 * @package moay\FintsDatabase\Test
 */
class FintsDatabaseTest extends TestCase
{
    /**  */
    public function testDatabaseSearchesProperly()
    {
        $banks = FintsDatabase::search('DKB');
        $this->assertTrue(count($banks) > 0);
        foreach ($banks as $bank) {
            $this->assertInstanceOf(Bank::class, $bank);
        }
    }

    /**  */
    public function testDatabaseGetsProperlyByIp()
    {
        $banks = FintsDatabase::search('12030000');
        $this->assertTrue(count($banks) > 0);
        $bank = FintsDatabase::getBankById($banks[0]->getId());
        $this->assertInstanceOf(Bank::class, $bank);
        $this->assertEquals($bank->getName(), $banks[0]->getName());
        $this->assertNotNull($bank->getName());
    }
}