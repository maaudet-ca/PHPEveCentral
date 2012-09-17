<?php



/**
 *
 * Copyright (c) 2012 Marc André "Manhim" Audet <root@manhim.net>. All rights reserved.
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



class QuickLook extends \PHPEveCentral\Result
{
	// Public:
	
	public function __construct($bindings)
	{
		$this->_bindings = $bindings;
		
		$quicklook = &$bindings->evec_api->_content;
		
		$this->_attributes = new \stdClass;
		$this->_attributes->item = (double) $quicklook->item;
		$this->_attributes->itemname = (string) $quicklook->itemname;
		$this->_attributes->regions = $quicklook->regions;
		$this->_attributes->hours = (int) $quicklook->hours;
		$this->_attributes->minqty = (double) $quicklook->minqty;

		foreach ($quicklook->sell_orders->_content as $o)
		{
			$order = new \stdClass;
			
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

			$this->_sell_orders[$o->_attr_id] = $order;
		}
		
		foreach ($quicklook->buy_orders->_content as $o)
		{
			$order = new \stdClass;
			
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

			$this->_buy_orders[$o->_attr_id] = $order;
		}
	}
	
	public function GetAttributes()
	{
		return $this->_attributes;
	}
		
	public function GetBindings()
	{
		return $this->_bindings;
	}
	
	
	
	// Private:
	
	private $_attributes;
	private $_sell_orders = array();
	private $_buy_orders = array();
	private $_bindings;
}