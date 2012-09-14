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



class MarketStat extends \PHPEveCentral\XMLParser
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
		
		$marketstat = new \PHPEveCentral\XMLBindings\evec_api\marketstat();
		
		$types = array();
		
		foreach ($this->_sxe->marketstat->type as $t)
		{
			$type = new \PHPEveCentral\XMLBindings\evec_api\marketstat\type();
			
			$type->_attr_id = (string) $t->attributes()->id;
			
			$buy = new \PHPEveCentral\XMLBindings\evec_api\marketstat\type\buy();
			
			$buy->volume = (string) $t->buy->volume;
			$buy->avg = (string) $t->buy->avg;
			$buy->max = (string) $t->buy->max;
			$buy->min = (string) $t->buy->min;
			$buy->stddev = (string) $t->buy->stddev;
			$buy->median = (string) $t->buy->median;
			$buy->percentile = (string) $t->buy->percentile;
			
			$type->buy = $buy;
			
			$sell = new \PHPEveCentral\XMLBindings\evec_api\marketstat\type\sell();
			
			$sell->volume = (string) $t->sell->volume;
			$sell->avg = (string) $t->sell->avg;
			$sell->max = (string) $t->sell->max;
			$sell->min = (string) $t->sell->min;
			$sell->stddev = (string) $t->sell->stddev;
			$sell->median = (string) $t->sell->median;
			$sell->percentile = (string) $t->sell->percentile;
			
			$type->sell = $sell;
			
			$all = new \PHPEveCentral\XMLBindings\evec_api\marketstat\type\all();
			
			$all->volume = (string) $t->all->volume;
			$all->avg = (string) $t->all->avg;
			$all->max = (string) $t->all->max;
			$all->min = (string) $t->all->min;
			$all->stddev = (string) $t->all->stddev;
			$all->median = (string) $t->all->median;
			$all->percentile = (string) $t->all->percentile;
			
			$type->all = $all;
			
			$types[] = $type;
		}
		
		$marketstat->_content = $types;
		
		$this->evec_api->_content = $marketstat;
	}
}
