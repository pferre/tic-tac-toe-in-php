<?php

namespace App;

class Game
{
    public function state(): GameState
    {
        return new GameState(Status::GAME_ON, Player::X);
    }
}
