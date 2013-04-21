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



class Utils
{
    static public function removeArrayValue(array $array, $value)
    {
        foreach ($array as $k => $v)
		{
            if ($v === $value)
            {
                unset($array[$k]);
                $array = array_values($array);
                break;
            }
        }

        return $array;
    }

    static public function removeArrayValues(array $array, array $values)
    {
        return array_values(array_diff($array, $values));
    }

    static public function sendCurlRequest($url, $params, $is_post = false)
    {
        $query_string = [];

        foreach ($params as $k => $p)
        {
            if (!is_array($p))
            {
                $query_string[] = $k . '=' . $p;
            }
            else
            {
                $query_string[] = $k . '=' . implode(',', $p);
            }
        }

        $options = array(
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_HEADER          => false,
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_ENCODING        => "",
            CURLOPT_USERAGENT       => 'PHPEveCentral/' . PHPEveCentral::VERSION,
            CURLOPT_AUTOREFERER     => true,
            CURLOPT_CONNECTTIMEOUT  => 120,
            CURLOPT_TIMEOUT         => 120,
            CURLOPT_MAXREDIRS       => 10,
        );

        if ($is_post)
        {
            $post_options = [
                CURLOPT_POST        => true,
                CURLOPT_POSTFIELDS  => implode('&', $query_string)
            ];

            $options = $options + $post_options;

            $ch = curl_init($url);
        }
        else
        {
            $ch = curl_init($url . '?' . implode('&', $query_string));
        }

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

        return $content;
    }
}
