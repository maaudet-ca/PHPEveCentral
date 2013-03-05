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



namespace PHPEveCentral;



abstract class Request
{
	// Public:
	
	public function __construct($url)
	{
		$this->_url = $url;
	}
	
	public function Send()
	{
		$url = $this->_url;
		$params = $this->BuildParams();
		
		$query_string = array();
		
		foreach ($params as $k => $p)
		{
			if (!is_array($p))
			{
				$query_string[] = $k . '=' . $p;
			}
			else
			{
				$first = true;
				foreach ($p as $v)
				{
					if($first)
					{
						$query_string[] = $k . '=' . $v;
						$first = false;
					}
					else
					{
						$last = array_pop($query_string);
						$query_string[] = $last.','.$v;
					}
				}
			}
		}
		
		$query = '?' . implode('&', $query_string);
		
		$options = array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER         => false,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_USERAGENT      => 'PHPEveCentral/' . \PHPEveCentral\VERSION,
			CURLOPT_AUTOREFERER    => true,
			CURLOPT_CONNECTTIMEOUT => 120,
			CURLOPT_TIMEOUT        => 120,
			CURLOPT_MAXREDIRS      => 10,
		);
		
		$ch = curl_init($url . $query);
		curl_setopt_array($ch, $options);
		$content = curl_exec($ch);
		
		if (curl_errno($ch) != 0)
		{
			return false;
		}
		
		$header = curl_getinfo($ch);
		
		curl_close($ch);
		
		if ($header['http_code'] != 200)
		{
			return false;
		}

		return $this->Parse($content);
	}
	
	
	
	// Protected:
	
	abstract protected function BuildParams();
	abstract protected function Parse($content);
	

	
	// Private:
	
	private $_url;
}
