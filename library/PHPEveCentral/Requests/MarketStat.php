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
 * Class MarketStat
 * @package PHPEveCentral
 */
class MarketStat implements Request
{
    private $url;
    private $hours = null;
    private $typeid = [];
    private $minimum_quantity = null;
    private $region_limit = [];
    private $use_system = null;

    public function __construct(array $typeid = [])
    {
        $this->typeid = $typeid;

        $phpevecentral = PHPEveCentral::getInstance();
        $this->setURL($phpevecentral->getBaseURL() . 'marketstat');
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
     * Statistics from the last X specified hours. Defaults to 24.
     *
     * @param integer|null $hours
     *
     * @return $this
     */
    public function &setHours($hours)
    {
        $this->hours = $hours;
        return $this;
    }

    /**
     * The type ID of the item you are requesting. I.e., 34 for Tritanium. Can have more then 1.
     * If you input an integer, it will append this value to the list.
     * If you input an array, it will merge with the current list.
     *
     * @param array|integer $typeid
     *
     * @return $this
     */
    public function &addTypeId($typeid)
    {
        if (is_array($typeid))
        {
            $this->typeid = array_merge($this->typeid, $typeid);
        }
        else
        {
            $this->typeid[] = $typeid;
        }

        return $this;
    }

    /**
     * Remove the type ID(s) from the list.
     * If you input an integer, it will be removed from the list.
     * If you input an array, all it's values will be removed from the list.
     *
     * @param array|integer $typeid
     *
     * @return $this
     */
    public function &removeTypeId($typeid)
    {
        if (is_array($typeid))
        {
            $this->typeid = Utils::removeArrayValues($this->typeid, $typeid);
        }
        else
        {
            $this->typeid = Utils::removeArrayValue($this->typeid, $typeid);
        }

        return $this;
    }

    /**
     * Clear the type ID list.
     *
     * @return $this
     */
    public function &clearTypeId()
    {
        $this->typeid = [];
        return $this;
    }

    /**
     * The minimum quantity in an order to consider it for the statistics
     *
     * @param integer $minimum_quantity
     *
     * @return $this
     */
    public function &setMinimumQuantity($minimum_quantity)
    {
        $this->minimum_quantity = $minimum_quantity;
        return $this;
    }

    /**
     * Restrict statistics to a region. Can have more then 1.
     * If you input an integer, it will append this value to the list.
     * If you input an array, it will merge with the current list.
     *
     * @param array|integer $region_limit
     *
     * @return $this
     */
    public function &addRegionLimit($region_limit)
    {
        if (is_array($region_limit))
        {
            $this->region_limit = array_merge($region_limit, $this->region_limit);
        }
        else
        {
            $this->region_limit[] = $region_limit;
        }

        return $this;
    }

    /**
     * Remove the region limit(s) from the list.
     * If you input an integer, it will be removed from the list.
     * If you input an array, all it's values will be removed from the list.
     *
     * @param array|integer $region_limit
     *
     * @return $this
     */
    public function &removeRegionLimit($region_limit)
    {
        if (is_array($region_limit))
        {
            $this->region_limit = Utils::removeArrayValues($this->region_limit, $region_limit);
        }
        else
        {
            $this->region_limit = Utils::removeArrayValue($this->region_limit, $region_limit);
        }

        return $this;
    }

    /**
     * Clear the region limit list.
     *
     * @return $this
     */
    public function &clearRegionLimit()
    {
        $this->region_limit = [];
        return $this;
    }

    /**
     * Restrict statistics to a system.
     *
     * @param integer $use_system
     *
     * @return $this
     */
    public function &setUseSystem($use_system)
    {
        $this->use_system = $use_system;
        return $this;
    }

    public function send()
    {
        $content = Utils::sendCurlRequest($this->url, $this->buildParams(), true);

        return new \PHPEveCentral\Results\MarketStat($content);
    }

    private function buildParams()
    {
        $params = [];

        if ($this->hours !== null)
        {
            $params['hours'] = $this->hours;
        }

        $this->typeid = array_unique($this->typeid, SORT_NUMERIC);

        if (count($this->typeid) > 0)
        {
            $params['typeid'] = $this->typeid;
        }
        else
        {
            throw new Exceptions\MarketStatRequestException('The typeid parameter is required.');
        }

        if ($this->minimum_quantity !== null)
        {
            $params['minQ'] = $this->minimum_quantity;
        }

        $this->region_limit = array_unique($this->region_limit, SORT_NUMERIC);

        if (count($this->region_limit) > 0)
        {
            $params['regionlimit'] = $this->region_limit;
        }

        if ($this->use_system !== null)
        {
            $params['usesystem'] = $this->use_system;
        }

        return $params;
    }
}
