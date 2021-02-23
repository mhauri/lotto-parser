<?php

namespace LottoParser\Model\Swisslos;

class GameTable
{
    /**
     * @var array
     */
    private $rows = [];

    public function addRow(string $numberOfCorrectNumbers, string $numberOfWinners, string $prizeInCHF)
    {
        $data = [
            'numberOfCorrectNumbers' => $numberOfCorrectNumbers,
            'numberOfWinners' => $numberOfWinners,
            'prizeInCHF' => $prizeInCHF,
        ];
        $this->rows[] = $data;
    }

    public function getRows(): array
    {
        return $this->rows;
    }
}
