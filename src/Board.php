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
        $hasWinCondition = false;

        $winConditions = [
            [Square::TOP_LEFT, Square::TOP_MIDDLE, Square::TOP_RIGHT],
            [Square::CENTER_LEFT, Square::CENTER_MIDDLE, Square::CENTER_RIGHT],
            [Square::BOTTOM_LEFT, Square::BOTTOM_MIDDLE, Square::BOTTOM_RIGHT],
            [Square::TOP_LEFT, Square::CENTER_LEFT, Square::BOTTOM_LEFT],
            [Square::TOP_MIDDLE, Square::CENTER_MIDDLE, Square::BOTTOM_MIDDLE],
            [Square::TOP_RIGHT, Square::CENTER_RIGHT, Square::BOTTOM_RIGHT],
            [Square::TOP_LEFT, Square::CENTER_MIDDLE, Square::BOTTOM_RIGHT],
            [Square::TOP_RIGHT, Square::CENTER_MIDDLE, Square::BOTTOM_LEFT]
        ];

        foreach ($winConditions as $winCondition) {
            $found = [];
            $found[] = array_intersect($winCondition, $this->takenSquares);

            if ($found[0] === $winCondition) {
                $hasWinCondition = true;
            }
        }

        return $hasWinCondition;
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
