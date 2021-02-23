<?php

namespace LottoParser\Model\Swisslos;

use Carbon\Carbon;

class SwissLottoDTO
{
    /**
     * @var Carbon
     */
    private $drawDate;
    /**
     * @var WinningNumbers
     */
    private $winningNumbers;
    /**
     * @var int
     */
    private $luckyNumber = 0;
    /**
     * @var int
     */
    private $replayNumber = 0;
    /**
     * @var string
     */
    private $jackpotNextDraw = '';
    /**
     * @var GameTable
     */
    private $gameTable;

    public function getDrawDate(): string
    {
        return $this->drawDate->format('d.m.Y');
    }

    public function setDrawDate(Carbon $drawDate)
    {
        $this->drawDate = $drawDate;
    }

    public function getWinningNumbers(): array
    {
        return $this->winningNumbers->getNumbers();
    }

    public function setWinningNumbers(WinningNumbers $winningNumbers)
    {
        $this->winningNumbers = $winningNumbers;
    }

    public function getLuckyNumber(): int
    {
        return $this->luckyNumber;
    }

    public function setLuckyNumber(int $luckyNumber)
    {
        $this->luckyNumber = $luckyNumber;
    }

    public function getReplayNumber(): int
    {
        return $this->replayNumber;
    }

    public function setReplayNumber(int $replayNumber)
    {
        $this->replayNumber = $replayNumber;
    }

    public function getJackpotNextDraw(): string
    {
        return $this->jackpotNextDraw;
    }

    public function setJackpotNextDraw(string $jackpotNextDraw)
    {
        $this->jackpotNextDraw = $jackpotNextDraw;
    }

    public function getGameTable(): array
    {
        return $this->gameTable->getRows();
    }

    public function setGameTable(GameTable $gameTable)
    {
        $this->gameTable = $gameTable;
    }
}
