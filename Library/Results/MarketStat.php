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



class MarketStat extends \PHPEveCentral\Result
{
	// Public:

	public function __construct($bindings)
	{
		$this->_bindings = $bindings;
	
		foreach ($bindings->evec_api->_content->_content as $type)
		{
			$this->_types[$type->_attr_id] = new \stdClass;
			
			$this->_types[$type->_attr_id]->buy = new \stdClass;
			$this->_types[$type->_attr_id]->buy->volume = (double) $type->buy->volume;
			$this->_types[$type->_attr_id]->buy->avg = (double) $type->buy->avg;
			$this->_types[$type->_attr_id]->buy->min = (double) $type->buy->min;
			$this->_types[$type->_attr_id]->buy->max = (double) $type->buy->max;
			$this->_types[$type->_attr_id]->buy->stddev = (double) $type->buy->stddev;
			$this->_types[$type->_attr_id]->buy->median = (double) $type->buy->median;
			$this->_types[$type->_attr_id]->buy->percentile = (double) $type->buy->percentile;
			
			$this->_types[$type->_attr_id]->sell = new \stdClass;
			$this->_types[$type->_attr_id]->sell->volume = (double) $type->sell->volume;
			$this->_types[$type->_attr_id]->sell->avg = (double) $type->sell->avg;
			$this->_types[$type->_attr_id]->sell->min = (double) $type->sell->min;
			$this->_types[$type->_attr_id]->sell->max = (double) $type->sell->max;
			$this->_types[$type->_attr_id]->sell->stddev = (double) $type->sell->stddev;
			$this->_types[$type->_attr_id]->sell->median = (double) $type->sell->median;
			$this->_types[$type->_attr_id]->sell->percentile = (double) $type->sell->percentile;
			
			$this->_types[$type->_attr_id]->all = new \stdClass;
			$this->_types[$type->_attr_id]->all->volume = (double) $type->all->volume;
			$this->_types[$type->_attr_id]->all->avg = (double) $type->all->avg;
			$this->_types[$type->_attr_id]->all->min = (double) $type->all->min;
			$this->_types[$type->_attr_id]->all->max = (double) $type->all->max;
			$this->_types[$type->_attr_id]->all->stddev = (double) $type->all->stddev;
			$this->_types[$type->_attr_id]->all->median = (double) $type->all->median;
			$this->_types[$type->_attr_id]->all->percentile = (double) $type->all->percentile;
		}
	}
	
	public function GetType($type_id)
	{
		if ($this->_types[$type_id])
		{
			return $this->_types[$type_id];
		}
		else
		{
			return false;
		}
	}
	
	public function GetAllTypes()
	{
		return $this->_types;
	}
	
	public function GetBindings()
	{
		return $this->_bindings;
	}
	
	
	
	// Private:
	
	private $_types;
	private $_bindings;
}