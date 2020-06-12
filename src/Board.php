<?php

namespace App;

class Board
{
    private array $takenSquares;

    private WinningConditions $winConditions;

    public function __construct(array $takenSquares = [])
    {
        $this->takenSquares = $takenSquares;
        $this->winConditions = new WinningConditions($this->takenSquares);
    }

    public function isAlreadyUsed(string $square): bool
    {
        return in_array($square, $this->takenSquares, true);
    }

    public function use(string $square): Board
    {
        return new Board($this->newSquares($square));
    }

    public function isFull(): bool
    {
        return count($this->takenSquares) === 9;
    }

    public function winningCondition(): bool
    {
        return $this->winConditions->has();
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
