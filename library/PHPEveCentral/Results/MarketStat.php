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
 * Class MarketStat
 * @package PHPEveCentral\Requests
 */
class MarketStat implements Result
{
    protected $evec_method;
    protected $evec_version;

    protected $types = [];

    public function __construct($input)
    {
        $sxe = new \SimpleXMLElement($input);

        $this->evec_method = (string) $sxe->attributes()->method;
        $this->evec_version = (string) $sxe->attributes()->version;

        foreach ($sxe->marketstat->type as $t)
        {
            $id = (int) $t->attributes()->id;

            $this->types[$id] = new \stdClass;

            $this->types[$id]->buy = new \stdClass;
            $this->types[$id]->buy->volume = (double) $t->buy->volume;
            $this->types[$id]->buy->avg = (double) $t->buy->avg;
            $this->types[$id]->buy->max = (double) $t->buy->max;
            $this->types[$id]->buy->min = (double) $t->buy->min;
            $this->types[$id]->buy->stddev = (double) $t->buy->stddev;
            $this->types[$id]->buy->median = (double) $t->buy->median;
            $this->types[$id]->buy->percentile = (double) $t->buy->percentile;

            $this->types[$id]->sell = new \stdClass;
            $this->types[$id]->sell->volume = (double) $t->sell->volume;
            $this->types[$id]->sell->avg = (double) $t->sell->avg;
            $this->types[$id]->sell->max = (double) $t->sell->max;
            $this->types[$id]->sell->min = (double) $t->sell->min;
            $this->types[$id]->sell->stddev = (double) $t->sell->stddev;
            $this->types[$id]->sell->median = (double) $t->sell->median;
            $this->types[$id]->sell->percentile = (double) $t->sell->percentile;

            $this->types[$id]->all = new \stdClass;
            $this->types[$id]->all->volume = (double) $t->all->volume;
            $this->types[$id]->all->avg = (double) $t->all->avg;
            $this->types[$id]->all->max = (double) $t->all->max;
            $this->types[$id]->all->min = (double) $t->all->min;
            $this->types[$id]->all->stddev = (double) $t->all->stddev;
            $this->types[$id]->all->median = (double) $t->all->median;
            $this->types[$id]->all->percentile = (double) $t->all->percentile;
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

    public function getType($typeid)
    {
        if ($this->types[$typeid])
        {
            return $this->types[$typeid];
        }
        else
        {
            return false;
        }
    }

    public function getAllTypes()
    {
        return $this->types;
    }
}
