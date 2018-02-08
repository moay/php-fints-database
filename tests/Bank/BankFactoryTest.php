<?php

namespace moay\FintsDatabase\Test\Bank;

use moay\FintsDatabase\Bank\BankFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class BankFactoryTest
 * @package moay\FintsDatabase\Test\Bank
 */
class BankFactoryTest extends TestCase
{
    /**  */
    public function testReturnsBank()
    {
        $institute = new \StdClass();
        $institute->name = 'test';
        $bank = BankFactory::create($institute);
        $this->assertEquals('test', $bank->getName());
        $this->assertEquals(null, $bank->getId());
    }

    public function testPassesAllNeededBaseValues()
    {
        $fieldmap = [
            'number' => 'getId',
            'blz' => 'getBlz',
            'name' => 'getName',
            'location' => 'getLocation',
            "organisation" => 'getOrganization',
            'pinTanUrl' => 'getPinTanUrl',
            'protocol' => 'getFintsVersion',
            "hbciDomain" => 'getHbciUrl',
            "hbciAddress" => 'getHbciIp',
            "hbciVersion" => 'getHbciVersion'
        ];

        $institute = new \StdClass();
        $institute->number = '1';
        $institute->blz = '123';
        $institute->name = '2';
        $institute->location = '3';
        $institute->organisation = '4';
        $institute->hbciDomain = '5';
        $institute->hbciAddress = '6';
        $institute->hbciVersion = '7';
        $institute->pinTanUrl = '8';
        $institute->protocol = '9';

        $bank = BankFactory::create($institute);

        foreach ($fieldmap as $field => $getter) {
            $this->assertEquals($institute->{$field}, $bank->{$getter}());
        }
    }
}