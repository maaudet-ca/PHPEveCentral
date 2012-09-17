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



namespace PHPEveCentral\XMLParsers;



class QuickLook extends \PHPEveCentral\XMLParser
{
	// Public:
	
	public function __construct($content)
	{
		parent::__construct($content);
		
		$this->_Bind();
	}
	
	public $evec_api;
	
	
	
	// Private:
	
	private function _Bind()
	{
		$this->evec_api = new \PHPEveCentral\XMLBindings\evec_api();
		
		$this->evec_api->_attr_method = (string) $this->_sxe->attributes()->method;
		$this->evec_api->_attr_version = (string) $this->_sxe->attributes()->version;
		
		$quicklook = new \PHPEveCentral\XMLBindings\evec_api\quicklook();
		
		$quicklook->item = (string) $this->_sxe->quicklook->item;
		$quicklook->itemname = (string) $this->_sxe->quicklook->itemname;
		$quicklook->regions = array();
		
		foreach ($this->_sxe->quicklook->regions->region as $region)
		{
			$quicklook->regions[] = (string) $region;
		}
		
		$quicklook->hours = (string) $this->_sxe->quicklook->hours;
		$quicklook->minqty = (string) $this->_sxe->quicklook->minqty;
		
		// Sell Orders
		$quicklook->sell_orders = new \PHPEveCentral\XMLBindings\evec_api\quicklook\sell_orders();
		
		$orders = array();
		foreach ($this->_sxe->quicklook->sell_orders->order as $o)
		{
			$order = new \PHPEveCentral\XMLBindings\evec_api\quicklook\order();
			
			$order->_attr_id = (string) $o->attributes()->id;
			
			$order->region = (string) $o->region;
			$order->station = (string) $o->station;
			$order->station_name = (string) $o->station_name;
			$order->security = (string) $o->security;
			$order->range = (string) $o->range;
			$order->price = (string) $o->price;
			$order->vol_remain = (string) $o->vol_remain;
			$order->min_volume = (string) $o->min_volume;
			$order->expires = (string) $o->expires;
			$order->reported_time = (string) $o->reported_time;
			
			$orders[] = $order;
		}
		
		$quicklook->sell_orders->_content = $orders;
		
		// Buy orders
		$quicklook->buy_orders = new \PHPEveCentral\XMLBindings\evec_api\quicklook\buy_orders();
		
		$orders = array();
		foreach ($this->_sxe->quicklook->buy_orders->order as $o)
		{
			$order = new \PHPEveCentral\XMLBindings\evec_api\quicklook\order();
			
			$order->_attr_id = (string) $o->attributes()->id;
			
			$order->region = (string) $o->region;
			$order->station = (string) $o->station;
			$order->station_name = (string) $o->station_name;
			$order->security = (string) $o->security;
			$order->range = (string) $o->range;
			$order->price = (string) $o->price;
			$order->vol_remain = (string) $o->vol_remain;
			$order->min_volume = (string) $o->min_volume;
			$order->expires = (string) $o->expires;
			$order->reported_time = (string) $o->reported_time;
			
			$orders[] = $order;
		}
		
		$quicklook->buy_orders->_content = $orders;
		
		$this->evec_api->_content = $quicklook;
	}
	
}
