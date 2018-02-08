<?php

namespace moay\FintsDatabase\Bank;

/**
 * Class BankFactory
 * @package moay\FintsDatabase\Bank
 */
class BankFactory
{
    /**
     * Takes a raw institute from the json database and converts it into a Bank object
     *
     * @param $institute
     * @return Bank
     */
    public static function create($institute)
    {
        $bank = new Bank();

        $fieldmap = [
            'number' => 'setId',
            'blz' => 'setBlz',
            'name' => 'setName',
            'location' => 'setLocation',
            "organisation" => 'setOrganization',
            'pinTanUrl' => 'setPinTanUrl',
            'protocol' => 'setFintsVersion',
            "hbciDomain" => 'setHbciUrl',
            "hbciAddress" => 'setHbciIp',
            "hbciVersion" => 'setHbciVersion'
        ];

        foreach ($fieldmap as $field => $setter) {
            if (isset($institute->{$field}) && $institute->{$field} !== null) {
                $bank->{$setter}($institute->{$field});
            }
        }

        $supportedTechnologies = [];
        foreach (["ddv","rdh1","rdh2","rdh3","rdh4","rdh5","rdh6","rdh7","rdh8","rdh9","rdh10","rah7","rah9","rah10"] as $tech) {
            if (isset($institute->{$tech}) && $institute->{$tech } === true) {
                $supportedTechnologies[] = $tech;
            }
            if (isset($institute->pinTanUrl) && $institute->pinTanUrl !== null) {
                $supportedTechnologies[] = 'pinTan';
            }
        }
        $bank->setSupportedTechnologies($supportedTechnologies);
        return $bank;
    }
}