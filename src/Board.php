<?php

namespace App;

class Board
{
    private ?string $takenSquare;

    public function __construct(string $takenSquare = null)
    {
        $this->takenSquare = $takenSquare;
    }

    public function isAlreadyUsed(string $square): bool
    {
        return $this->takenSquare === $square;
    }

    public function use(string $square): Board
    {
        return new Board($square);
    }
}
