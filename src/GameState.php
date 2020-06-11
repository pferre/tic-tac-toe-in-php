<?php

namespace App;

class GameState
{
    private string $status;
    private string $nextPlayer;

    public function __construct(string $status, string $nextPlayer)
    {
        $this->status = $status;
        $this->nextPlayer = $nextPlayer;
    }

    public function __toString(): string
    {
        return "Status : " .$this->status. ", Next player: " .$this->nextPlayer;
    }
}
