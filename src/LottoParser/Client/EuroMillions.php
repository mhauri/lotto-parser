<?php

namespace LottoParser\Client;

use Carbon\Carbon;
use DiDom\Document;
use LottoParser\ClientInterface;
use LottoParser\Exceptions\InvalidWeekdayException;
use LottoParser\Model\Swisslos;
use LottoParser\Model\Swisslos\EuroMillionsDTO;
use LottoParser\Model\Swisslos\GameTable;
use LottoParser\Model\Swisslos\SuperStars;
use LottoParser\Model\Swisslos\WinningNumbers;

class EuroMillions implements ClientInterface
{
    /**
     * @var Swisslos
     */
    private $swisslos;
    /**
     * @var Document
     */
    private $document;
    /**
     * @var EuroMillionsDTO
     */
    private $result;

    public function __construct()
    {
        $this->swisslos = new Swisslos(Swisslos::GAME_EUROMILLIONS);
    }

    public function byDate(Carbon $date)
    {
        if ($date->isTuesday() || $date->isFriday()) {
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

    public function get()
    {
        return $this->result;
    }

    public function toArray(): array
    {
        return [
            'drawDate' => $this->result->getDrawDate(),
            'winningNumbers' => $this->result->getWinningNumbers(),
            'superStars' => $this->result->getSuperStars(),
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
        $result = new EuroMillionsDTO();

        $result->setDrawDate(Carbon::createFromFormat('d.m.Y', $this->getDrawDate()));
        $result->setWinningNumbers($this->getWinningNumbers());
        $result->setSuperStars($this->getSuperStars());
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
        $items = $this->element()->find('li.actual-numbers__number___normal');
        foreach ($items as $item) {
            $winningNumbers->addNumber((int) trim($item->text()));
        }

        return $winningNumbers;
    }

    private function getSuperStars(): SuperStars
    {
        $superStars = new SuperStars();
        $items = $this->element()->find('li.actual-numbers__number___superstar span.transform__center');
        foreach ($items as $item) {
            $superStars->addNumber((int) trim($item->text()));
        }

        return $superStars;
    }

    private function getJackpotNextDraw(): string
    {
        return $this->document->find('.quotes__game-jackpot .quotes__game-jackpot-value')[0]->text();
    }

    private function getGameTable(): GameTable
    {
        $gameTable = new GameTable();
        $table = $this->document->find('.quotes__game-table')[0]->find('tbody tr');
        foreach ($table as $key => $item) {
            $count = count($item->find('td')[0]->find('.euromillions-quotes__game-table___superstar'));
            $gameTable->addRow(
                trim($item->find('td')[0]->text().str_repeat('*', $count)),
                trim($item->find('td')[1]->text()),
                trim($item->find('td')[2]->text())
            );
        }

        return $gameTable;
    }

    private function element()
    {
        return $this->document->find('.filter-results .actual-numbers___body')[0];
    }
}
