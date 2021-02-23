<?php

namespace LottoParser\Client;

use Carbon\Carbon;
use DiDom\Document;
use LottoParser\ClientInterface;
use LottoParser\Exceptions\InvalidWeekdayException;
use LottoParser\Model\Swisslos;
use LottoParser\Model\Swisslos\GameTable;
use LottoParser\Model\Swisslos\SwissLottoDTO;
use LottoParser\Model\Swisslos\WinningNumbers;

class SwissLotto implements ClientInterface
{
    const MIN_DATE = '04.01.2006';

    /**
     * @var Swisslos
     */
    private $swisslos;
    /**
     * @var Document
     */
    private $document;
    /**
     * @var SwissLottoDTO
     */
    private $result;

    public function __construct()
    {
        $this->swisslos = new Swisslos(Swisslos::GAME_SWISSLOTTO);
    }

    public function byDate(Carbon $date)
    {
        if ($date->isWednesday() || $date->isSaturday()) {
            $this->document = $this->swisslos->getByDate($date);
            $this->parse();

            return $this;
        }
        throw new InvalidWeekdayException();
    }

    public function current()
    {
        $this->document = $this->swisslos->getCurrent();
        $this->parse();

        return $this;
    }

    public function get(): SwissLottoDTO
    {
        return $this->result;
    }

    public function toArray(): array
    {
        return [
            'drawDate' => $this->result->getDrawDate(),
            'winningNumbers' => $this->result->getWinningNumbers(),
            'luckyNumber' => $this->result->getLuckyNumber(),
            'replayNumber' => $this->result->getReplayNumber(),
            'jackpotNextDraw' => $this->result->getJackpotNextDraw(),
            'gameTable' => $this->result->getGameTable(),
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    private function parse()
    {
        $result = new SwissLottoDTO();

        $result->setDrawDate(Carbon::createFromFormat('d.m.Y', $this->getDrawDate()));
        $result->setWinningNumbers($this->getWinningNumbers());
        $result->setLuckyNumber($this->getLuckyNumber());
        $result->setReplayNumber($this->getReplayNumber());
        $result->setJackpotNextDraw($this->getJackpotNextDraw());
        $result->setGameTable($this->getGameTable());
        $this->result = $result;
    }

    private function getDrawDate()
    {
        return $this->document->find('#formattedFilterDate')[0]->attr('value');
    }

    private function getWinningNumbers(): WinningNumbers
    {
        $winningNumbers = new WinningNumbers();
        $result = $this->document->find('.filter-results li.actual-numbers__number___normal');
        foreach ($result as $item) {
            $winningNumbers->addNumber((int) trim($item->text()));
        }

        return $winningNumbers;
    }

    private function getLuckyNumber(): int
    {
        return $this->document->find('.filter-results li.actual-numbers__number___lucky')[0]->text();
    }

    private function getReplayNumber(): int
    {
        return $this->document->find('.filter-results li.actual-numbers__number___replay')[0]->text();
    }

    private function getJackpotNextDraw(): string
    {
        return $this->document->find('.quotes__game-jackpot .quotes__game-jackpot-value')[0]->text();
    }

    private function getGameTable(): GameTable
    {
        $gameTable = new GameTable();
        $table = $this->document->find('.filter-results .quotes__game-table tbody tr');
        foreach ($table as $key => $item) {
            $gameTable->addRow(
                trim($item->find('td')[0]->text()),
                trim($item->find('td')[1]->text()),
                trim($item->find('td')[2]->text())
            );
        }

        return $gameTable;
    }
}
