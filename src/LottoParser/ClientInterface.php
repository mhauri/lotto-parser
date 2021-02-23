<?php

namespace LottoParser;

use Carbon\Carbon;

interface ClientInterface
{
    public function byDate(Carbon $date);

    public function current();

    public function get();

    public function toArray(): array;

    public function toJson(): string;
}
