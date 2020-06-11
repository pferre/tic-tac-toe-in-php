<?php

namespace App\Tests;

use App\Game;
use App\GameState;
use App\Player;
use App\Status;
use PHPUnit\Framework\TestCase;

class TicTacToeGameTest extends TestCase
{
    /**
     * @test
     */
    public function player_X_always_goes_first(): void
    {
        $game = new Game();
        $this->assertEquals($game->state(), new GameState(Status::GAME_ON, Player::X));
    }

    /**
     * @test
     */
    public function player_O_goes_next(): void
    {
        $game = new Game(Status::GAME_ON, Player::X);
        $game = $game->play();

        $this->assertEquals($game->state(), new GameState(Status::GAME_ON, Player::O));
    }
}
