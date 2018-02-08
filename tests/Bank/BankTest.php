<?php

namespace moay\FintsDatabase\Test\Bank;

use moay\FintsDatabase\Bank\Bank;
use PHPUnit\Framework\TestCase;

/**
 * Class BankTest
 * @package moay\FintsDatabase\Test\Bank
 */
class BankTest extends TestCase
{
    public function testReturnsHbciUrlIfPassed()
    {
        $bank = new Bank();
        $bank->setHbciUrl('test');
        $this->assertEquals($bank->getHbciUrlOrIp(), 'test');
    }

    public function testReturnsHbciIpAsFallbackForUrl()
    {
        $bank = new Bank();
        $bank->setHbciIp('test');
        $this->assertEquals($bank->getHbciUrlOrIp(), 'test');
    }

    public function testReturnsSupportedTechsProperly()
    {
        $techs = ['test', 'test2'];
        $bank = new Bank();
        $bank->setSupportedTechnologies($techs);
        $this->assertEquals(true, $bank->supports('test'));
        $this->assertEquals(false, $bank->supports('test3'));
    }
}