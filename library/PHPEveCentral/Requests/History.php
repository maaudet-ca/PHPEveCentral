<?php

/**
 *
 * Copyright (c) 2013 Marc André "Manhim" Audet <root@manhim.net>. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification, are
 * permitted provided that the following conditions are met:
 *
 *   1. Redistributions of source code must retain the above copyright notice, this list of
 *       conditions and the following disclaimer.
 *
 *   2. Redistributions in binary form must reproduce the above copyright notice, this list
 *       of conditions and the following disclaimer in the documentation and/or other materials
 *       provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL MARC ANDRÉ "MANHIM" AUDET BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */



namespace PHPEveCentral\Requests;



use PHPEveCentral\PHPEveCentral;
use PHPEveCentral\Request;
use PHPEveCentral\Utils;



/**
 * Class History
 * @package PHPEveCentral
 */
class History implements Request
{
    private $url;
    private $type = null;
    private $locale = 'system';
    private $name = null;
    private $bid = 0;

    public function __construct($type, $locale, $name, $bid)
    {
        $this->setType($type);
        $this->setLocale($locale);
        $this->setName($name);
        $this->setBid($bid);

        $phpevecentral = PHPEveCentral::getInstance();
        $this->setURL($phpevecentral->getBaseURL() . 'history/for/type');
    }

    /**
     * Set the request URL.
     *
     * @param string $url
     *
     * @return $this
     */
    public function &setURL($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * The type ID to be queried
     *
     * @param $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Can only be "system" or "region".
     *
     * @param $locale
     *
     * @return $this
     * @throws \PHPEveCentral\Exception\HistoryRequestException
     */
    public function setLocale($locale)
    {
        $locale = strtolower($locale);

        if ($locale !== 'system' && $locale !== 'region')
        {
            throw new \PHPEveCentral\Exception\HistoryRequestException('Locale only support "system" or "region" as input.');
        }

        $this->locale = $locale;
        return $this;
    }

    /**
     * The name of the system or the region.
     *
     * @param $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * 0 for Sell Orders, 1 for Buy Orders
     *
     * @param $bid
     *
     * @return $this
     * @throws \PHPEveCentral\Exception\HistoryRequestException
     */
    public function setBid($bid)
    {
        if ($bid !== 0 && $bid !== 1)
        {
            throw new \PHPEveCentral\Exception\HistoryRequestException('BID only support 0 or 1 as input.');
        }

        $this->bid = $bid;
        return $this;
    }

    public function send()
    {
        $url = $this->url . '/' . $this->type . '/' . $this->locale . '/' . urlencode($this->name) . '/bid/' . $this->bid;

        $content = Utils::sendCurlRequest($url, array(), false);

        return new \PHPEveCentral\Results\History($content);
    }
}
