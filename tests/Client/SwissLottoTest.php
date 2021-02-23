<?php

namespace LottoParser\Client;

use Carbon\Carbon;
use LottoParser\Exceptions\InvalidWeekdayException;
use PHPUnit\Framework\TestCase;

final class SwissLottoTest extends TestCase
{
    /**
     * @var SwissLotto
     */
    private $swisslotto;

    protected function setUp(): void
    {
        $this->swisslotto = new SwissLotto();
    }

    public function testCurrent()
    {
        $data = $this->swisslotto->current()->get();
        $this->assertCount(6, $data->getWinningNumbers());
        $this->assertCount(8, $data->getGameTable());
    }

    public function testCurrentToArray()
    {
        $data = $this->swisslotto->current()->toArray();
        $this->assertIsArray($data);
    }

    public function testCurrentToJson()
    {
        $data = $this->swisslotto->current()->toJson();
        $this->assertIsString($data);
    }

    public function testByDateValid()
    {
        $date = Carbon::create(2021, 02, 13);
        $data = $this->swisslotto->byDate($date)->get();
        $this->assertSame('13.02.2021', (string) $data->getDrawDate());
        $this->assertCount(6, $data->getWinningNumbers());
        $this->assertCount(8, $data->getGameTable());
    }

    public function testByDateInvalidWeekdayException()
    {
        $this->expectException(InvalidWeekdayException::class);
        $date = Carbon::create(2021, 02, 14);
        $this->swisslotto->byDate($date)->get();
    }
}
