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



namespace PHPEveCentral\Requests;



// TODO: Add properties and aliases docs



class MarketStat extends \PHPEveCentral\Request
{
	// Public:
	
	public function __construct()
	{
		parent::__construct(\PHPEveCentral\BASEURL . 'marketstat');
	}
	
	public function __get($name)
	{
		switch ($name)
		{
			case 'Hours': case 'hours':
				return $this->_hours;
			case 'TypeId': case 'typeid':
				return $this->_typeid;
			case 'MinimumQuantity': case 'minimum_quantity': case 'minQ':
				return $this->_minimum_quantity;
			case 'RegionLimit': case 'region_limit': case 'regionlimit':
				return $this->_region_limit;
			case 'UseSystem': case 'use_system': case 'usesystem':
				return $this->_use_system;
		}
	}
	
	public function &SetHours($hours)
	{
		$this->_hours = $hours;
		
		return $this;
	}
	
	public function &AddTypeId($typeid)
	{
		$this->_typeid[] = $typeid;
		
		return $this;
	}
	
	public function &RemoveTypeId($typeid)
	{
		\PHPEveCentral\Utils::RemoveArrayValue($this->_typeid, $typeid);
		
		return $this;
	}
	
	public function &SetMinimumQuantity($mininum_quantity)
	{
		$this->_minimum_quantity = $minimum_quantity;
		
		return $this;
	}
	
	public function &AddRegionLimit($region_limit)
	{
		$this->_region_limit[] = $region_limit;
		
		return $this;
	}
	
	public function &RemoveRegionLimit($region_limit)
	{
		\PHPEveCentral\Utils::RemoveArrayValue($this->_region_limit, $region_limit);
		
		return $this;
	}
	
	public function &SetUseSystem($use_system)
	{
		$this->_use_system = $use_system;
		
		return $this;
	}
	
	
	
	// Protected:
	
	protected function BuildParams()
	{
		$params = array();
		
		if ($this->_hours !== null)
		{
			$params['hours'] = $this->_hours;
		}
		
		if (count($this->_typeid) > 0)
		{
			$params['typeid'] = $this->_typeid;
		}
		else
		{
			throw new \Exception('The typeid parameter is required.');
		}
		
		if ($this->_minimum_quantity !== null)
		{
			$params['minQ'] = $this->_minimum_quantity;
		}
		
		if (count($this->_region_limit) > 0)
		{
			$params['regionlimit'] = $this->_region_limit;
		}
		
		if ($this->_use_system !== null)
		{
			$params['usesystem'] = $this->_use_system;
		}
		
		return $params;
	}
	
	protected function Parse($content)
	{
		return new \PHPEveCentral\Results\MarketStat(
				new \PHPEveCentral\XMLParsers\MarketStat($content)
			);
	}
	
	
	
	// Private:
	
	private $_hours = null; // hours
	private $_typeid = array(); // typeid
	private $_minimum_quantity = null; // minQ
	private $_region_limit = array(); // regionlimit
	private $_use_system = null; // usesystem
	
}
