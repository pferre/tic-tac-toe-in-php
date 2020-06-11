<?php

namespace App;

class Game
{
    private string $status;
    private ?string $lastPlayer;

    public function __construct(string $status = Status::GAME_ON, ?string $lastPlayer = null)
    {
        $this->status = $status;
        $this->lastPlayer = $lastPlayer;
    }

    public function state(): GameState
    {
        return new GameState($this->status, $this->nextPlayer());
    }

    public function play(): Game
    {
        return new Game(Status::GAME_ON, $this->nextPlayer());
    }

    private function nextPlayer(): string
    {
        if ($this->lastPlayer === null) {
            return Player::X;
        }

        return $this->lastPlayer === Player::X ? Player::O : Player::X;
    }
}
