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
        $this->board->isFull() ? $this->status = Status::DRAW : $this->status = $status;
        $this->lastPlayer = $lastPlayer;
    }

    public function state(): GameState
    {
        if ($this->status === Status::DRAW) {
            return new GameState($this->status);
        }

        return new GameState($this->status, $this->nextPlayer());
    }

    public function play(string $square): Game
    {
        if ($this->board->isAlreadyUsed($square)) {
            return new Game($this->board, Status::POSITION_ALREADY_TAKEN, $this->lastPlayer);
        }

        return new Game($this->board->use($square), Status::GAME_ON, $this->nextPlayer());
    }

    private function nextPlayer(): ?string
    {
        if ($this->lastPlayer === null) {
            return Player::X;
        }

        return $this->lastPlayer === Player::X ? Player::O : Player::X;
    }
}
