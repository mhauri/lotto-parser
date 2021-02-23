<?php

namespace LottoParser\Model\Swisslos;

class WinningNumbers
{
    /**
     * @var array
     */
    private $numbers = [];

    public function addNumber(int $number)
    {
        $this->numbers[] = $number;
    }

    public function getNumbers(): array
    {
        return $this->numbers;
    }
}
