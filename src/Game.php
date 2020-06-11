<?php

namespace App;

class Game
{
    private string $status;
    private string $nextPlayer;

    public function __construct(string $status, string $nextPlayer)
    {
        $this->status = $status;
        $this->nextPlayer = $nextPlayer;
    }

    public function state(): GameState
    {
        return new GameState($this->status, $this->nextPlayer);
    }

    public function play(): Game
    {
        return new Game(Status::GAME_ON, Player::O);
    }
}
