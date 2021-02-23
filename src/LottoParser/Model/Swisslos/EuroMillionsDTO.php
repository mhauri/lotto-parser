<?php

namespace LottoParser\Model\Swisslos;

use Carbon\Carbon;

class EuroMillionsDTO
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
     * @var SuperStars
     */
    private $superStars;
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

    public function getSuperStars(): array
    {
        return $this->superStars->getNumbers();
    }

    public function setSuperStars(SuperStars $superStars)
    {
        $this->superStars = $superStars;
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
