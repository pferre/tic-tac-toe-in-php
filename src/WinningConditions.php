<?php

namespace App;

class WinningConditions
{
    private array $takenSquares;

    public function __construct(array $takenSquares)
    {
        $this->takenSquares = $takenSquares;
    }

    public function has(): bool
    {
        $hasWinCondition = false;

        $winConditions = [
            [Square::TOP_LEFT, Square::CENTER_LEFT, Square::BOTTOM_LEFT],
            [Square::TOP_MIDDLE, Square::CENTER_MIDDLE, Square::BOTTOM_MIDDLE],
            [Square::TOP_RIGHT, Square::CENTER_RIGHT, Square::BOTTOM_RIGHT],
            [Square::TOP_LEFT, Square::TOP_MIDDLE, Square::TOP_RIGHT],
            [Square::CENTER_LEFT, Square::CENTER_MIDDLE, Square::CENTER_RIGHT],
            [Square::BOTTOM_RIGHT, Square::BOTTOM_LEFT, Square::BOTTOM_MIDDLE],
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
}
