<?php

declare(strict_types=1);

namespace matiasdamian\LangManager\libs\_634094b2b8492696\matiasdamian\GeoIp2;

interface ProviderInterface
{
    /**
     * @param string $ipAddress an IPv4 or IPv6 address to lookup
     *
     * @return Model\Country a Country model for the requested IP address
     */
    public function country(string $ipAddress): Model\Country;

    /**
     * @param string $ipAddress an IPv4 or IPv6 address to lookup
     *
     * @return Model\City a City model for the requested IP address
     */
    public function city(string $ipAddress): Model\City;
}