<?php

namespace App;

class Game
{
    private Board $board;
    private string $status;
    private ?string $lastPlayer;

    public function __construct(Board $board, string $status = Status::GAME_ON, ?string $lastPlayer = null)
    {
        $this->board = $board;

        $this->lastPlayer = $lastPlayer;

        if ($this->board->isFull()) {
            $this->status = Status::DRAW;
        } elseif($this->board->winningCondition()) {
            $this->status = $lastPlayer === Player::X ? Status::X_WINS : Status::O_WINS;
        } else {
            $this->status = $status;
        }
    }

    public function state(): GameState
    {
        if ($this->gameOver()) {
            return new GameState($this->status);
        }

        return new GameState($this->status, $this->nextPlayer());
    }

    public function play(string $square): Game
    {
        if ($this->gameOver()) {
            return $this;
        }

        if ($this->board->isAlreadyUsed($square)) {
            return new Game($this->board, Status::POSITION_ALREADY_TAKEN, $this->lastPlayer);
        }

        return new Game($this->board->use($square), Status::GAME_ON, $this->nextPlayer());
    }

    private function nextPlayer(): string
    {
        if ($this->lastPlayer === null) {
            return Player::X;
        }

        return $this->lastPlayer === Player::X ? Player::O : Player::X;
    }

    private function gameOver(): bool
    {
        return $this->status === Status::DRAW || $this->status === Status::X_WINS || $this->status === Status::O_WINS;
    }
}
