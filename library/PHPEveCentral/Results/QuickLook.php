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



namespace PHPEveCentral\Results;



use PHPEveCentral\Result;



/**
 * Class QuickLook
 * @package PHPEveCentral\Requests
 */
class QuickLook implements Result
{
    protected $evec_method;
    protected $evec_version;

    protected $attributes;
    protected $sell_orders = [];
    protected $buy_orders = [];

    public function __construct($input)
    {
        $sxe = new \SimpleXMLElement($input);

        $this->evec_method = (string) $sxe->attributes()->method;
        $this->evec_version = (string) $sxe->attributes()->version;

        $this->attributes = new \stdClass;
        $this->attributes->item = (double) $sxe->quicklook->item;
        $this->attributes->itemname = (string) $sxe->quicklook->itemname;
        $this->attributes->hours = (int) $sxe->quicklook->hours;
        $this->attributes->minqty = (double) $sxe->quicklook->minqty;

        $this->attributes->regions = [];

        foreach ($sxe->quicklook->regions->region as $region)
        {
            $this->attributes->regions[] = trim((string) $region);
        }

        foreach ($sxe->quicklook->sell_orders->order as $o)
        {
            $order = new \stdclass;

            $order->region = (double) $o->region;
            $order->station = (double) $o->station;
            $order->station_name = (string) $o->station_name;
            $order->security = (double) $o->security;
            $order->range = (int) $o->range;
            $order->price = (double) $o->price;
            $order->vol_remain = (double) $o->vol_remain;
            $order->min_volume = (double) $o->min_volume;
            $order->expires = strtotime($o->expires . ' UTC');
            $order->reported_time = strtotime(date('Y') . '-' . $o->reported_time . ' UTC');

            $this->sell_orders[(string) $o->attributes()->id] = $order;
        }

        foreach ($sxe->quicklook->buy_orders->order as $o)
        {
            $order = new \stdclass;

            $order->region = (double) $o->region;
            $order->station = (double) $o->station;
            $order->station_name = (string) $o->station_name;
            $order->security = (double) $o->security;
            $order->range = (int) $o->range;
            $order->price = (double) $o->price;
            $order->vol_remain = (double) $o->vol_remain;
            $order->min_volume = (double) $o->min_volume;
            $order->expires = strtotime($o->expires . ' UTC');
            $order->reported_time = strtotime(date('Y') . '-' . $o->reported_time . ' UTC');

            $this->buy_orders[(string) $o->attributes()->id] = $order;
        }
    }

    public function getEveCentralMethod()
    {
        return $this->evec_method;
    }

    public function getEveCentralVersion()
    {
        return $this->evec_version;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getSellOrder($id)
    {
        return $this->sell_orders[$id];
    }

    public function getAllSellOrders()
    {
        return $this->sell_orders;
    }

    public function getBuyOrder($id)
    {
        return $this->buy_orders[$id];
    }

    public function getAllBuyOrders()
    {
        return $this->buy_orders;
    }
}
