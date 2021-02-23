<?php

namespace LottoParser\Client;

use LottoParser\Exceptions\InvalidGameException;
use LottoParser\Model\Swisslos;
use PHPUnit\Framework\TestCase;

final class SwisslosTest extends TestCase
{
    public function testInvalidGameException()
    {
        $this->expectException(InvalidGameException::class);
        new Swisslos('test');
    }
}
