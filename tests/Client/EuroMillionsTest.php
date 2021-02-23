<?php

namespace LottoParser\Client;

use Carbon\Carbon;
use LottoParser\Exceptions\InvalidWeekdayException;
use PHPUnit\Framework\TestCase;

final class EuroMillionsTest extends TestCase
{
    /**
     * @var EuroMillions
     */
    private $euromillions;

    protected function setUp(): void
    {
        $this->euromillions = new EuroMillions();
    }

    public function testCurrent()
    {
        $data = $this->euromillions->current()->get();
        $this->assertCount(5, $data->getWinningNumbers());
        $this->assertCount(2, $data->getSuperStars());
        $this->assertCount(13, $data->getGameTable());
    }

    public function testCurrentToArray()
    {
        $data = $this->euromillions->current()->toArray();
        $this->assertIsArray($data);
    }

    public function testCurrentToJson()
    {
        $data = $this->euromillions->current()->toJson();
        $this->assertIsString($data);
    }

    public function testByDateValid()
    {
        $date = Carbon::create(2021, 02, 05);
        $data = $this->euromillions->byDate($date)->get();
        $this->assertSame('05.02.2021', (string) $data->getDrawDate());
        $this->assertCount(5, $data->getWinningNumbers());
        $this->assertCount(2, $data->getSuperStars());
        $this->assertCount(13, $data->getGameTable());
    }

    public function testByDateInvalidWeekdayException()
    {
        $this->expectException(InvalidWeekdayException::class);
        $date = Carbon::create(2021, 02, 04);
        $this->euromillions->byDate($date)->get();
    }
}
