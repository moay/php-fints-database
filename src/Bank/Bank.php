<?php

namespace moay\FintsDatabase\Bank;

/**
 * Class Bank
 * @package moay\FintsDatabase\Bank
 */
class Bank
{
    /** @var int */
    private $id;

    /** @var string */
    private $blz;

    /** @var string */
    private $name;

    /** @var string */
    private $organization;

    /** @var string */
    private $location;

    /** @var string */
    private $hbciUrl;

    /** @var string */
    private $hbciIp;

    /** @var string */
    private $hbciVersion;

    /** @var string */
    private $pinTanUrl;

    /** @var string */
    private $fintsVersion;

    /** @var array */
    private $supportedTechnologies = [];

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getBlz()
    {
        return $this->blz;
    }

    /**
     * @param string $blz
     */
    public function setBlz(string $blz)
    {
        $this->blz = $blz;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @param string $organization
     */
    public function setOrganization(string $organization)
    {
        $this->organization = $organization;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getHbciUrl()
    {
        return $this->hbciUrl;
    }

    /**
     * @param string $hbciUrl
     */
    public function setHbciUrl(string $hbciUrl)
    {
        $this->hbciUrl = $hbciUrl;
    }

    /**
     * @return string
     */
    public function getHbciIp()
    {
        return $this->hbciIp;
    }

    /**
     * @param string $hbciIp
     */
    public function setHbciIp(string $hbciIp)
    {
        $this->hbciIp = $hbciIp;
    }

    /**
     * Gets the HBCI URL or IP
     *
     * @return string
     */
    public function getHbciUrlOrIp()
    {
        return $this->hbciUrl !== null ? $this->hbciUrl : $this->hbciIp;
    }

    /**
     * @return string
     */
    public function getHbciVersion()
    {
        return $this->hbciVersion;
    }

    /**
     * @param string $hbciVersion
     */
    public function setHbciVersion(string $hbciVersion)
    {
        $this->hbciVersion = $hbciVersion;
    }

    /**
     * @return string
     */
    public function getPinTanUrl()
    {
        return $this->pinTanUrl;
    }

    /**
     * @param string $pinTanUrl
     */
    public function setPinTanUrl(string $pinTanUrl)
    {
        $this->pinTanUrl = $pinTanUrl;
    }

    /**
     * @return string
     */
    public function getFintsVersion()
    {
        return $this->fintsVersion;
    }

    /**
     * @param string $fintsVersion
     */
    public function setFintsVersion(string $fintsVersion)
    {
        $this->fintsVersion = $fintsVersion;
    }

    /**
     * Returns true if the bank supports the provided tech
     * Possible techs: ddv, pinTan, rdh1, rdh2, rdh3, rdh4, rdh5, rdh6, rdh7, rdh8, rdh9, rdh10, rah7, rah9, rah10
     *
     * @param string $tech
     * @return bool
     */
    public function supports(string $tech): bool
    {
        return in_array($tech, $this->supportedTechnologies);
    }

    /**
     * @return array
     */
    public function getSupportedTechnologies(): array
    {
        return $this->supportedTechnologies;
    }

    /**
     * @param array $supportedTechnologies
     */
    public function setSupportedTechnologies(array $supportedTechnologies)
    {
        $this->supportedTechnologies = $supportedTechnologies;
    }
}