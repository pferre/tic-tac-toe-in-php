<?php

namespace App;

class Board
{
    private array $takenSquares;

    public function __construct(array $takenSquares = [])
    {
        $this->takenSquares = $takenSquares;
    }

    public function isAlreadyUsed(string $square): bool
    {
        return in_array($square, $this->takenSquares, false);
    }

    public function use(string $square): Board
    {
        return new Board($this->newSquares($square));
    }

    private function newSquares($square): array
    {
        $newSquares = [];
        array_walk_recursive($this->takenSquares, static function ($a) use (&$newSquares) {
            $newSquares[] = $a;
        });

        return $this->addSquareTo($square, $newSquares);
    }

    private function addSquareTo(string $square, array $newSquares): array
    {
        $newSquares[] = $square;
        return $newSquares;
    }
}
