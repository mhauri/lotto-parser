<?php

namespace LottoParser\Model;

use Carbon\Carbon;
use DiDom\Document;
use GuzzleHttp\Client;
use LottoParser\Exceptions\InvalidGameException;
use Psr\Http\Message\ResponseInterface;

class Swisslos
{
    /**
     * [%s] will be replaced by the game (swisslotto|euromillions).
     *
     * @var string
     */
    const BASE_URL = 'https://www.swisslos.ch';

    const BASE_PATH = '/en/%s/information/winning-numbers/winning-numbers.html';

    const GAME_SWISSLOTTO = 'swisslotto';
    const GAME_EUROMILLIONS = 'euromillions';

    const VALID_GAMES = [
        self::GAME_SWISSLOTTO,
        self::GAME_EUROMILLIONS,
    ];

    /**
     * @var string
     */
    private $game;

    public function __construct(string $game)
    {
        if (!in_array($game, self::VALID_GAMES)) {
            throw new InvalidGameException();
        }

        $this->game = $game;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCurrent(): Document
    {
        $client = $this->getHttpClient();
        $response = $client->get(sprintf(self::BASE_PATH, $this->game));

        return $this->getDocument($response);
    }

    /**
     * @param Carbon $date
     *
     * @return Document
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getByDate(Carbon $date): Document
    {
        $filterDate = $date->copy()->addDays(3);
        $client = $this->getHttpClient();
        $response = $client->post(
            sprintf(self::BASE_PATH, $this->game),
            [
                'form_params' => [
                    'formattedFilterDate' => $filterDate->format('d.m.Y'),
                    'currentDate' => $filterDate->format('d.m.Y'),
                    'showPrevDraw' => true,
                ],
            ]
        );

        return $this->getDocument($response);
    }

    private function getHttpClient(): Client
    {
        return HttpClient::create(self::BASE_URL);
    }

    private function getDocument(ResponseInterface $response): Document
    {
        return Document::create($response->getBody()->getContents());
    }
}
