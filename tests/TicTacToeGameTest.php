<?php

namespace App\Tests;

use App\Board;
use App\Game;
use App\GameState;
use App\Player;
use App\Square;
use App\Status;
use PHPUnit\Framework\TestCase;

class TicTacToeGameTest extends TestCase
{
    /**
     * @test
     */
    public function player_X_always_goes_first(): void
    {
        $game = new Game(new Board());
        $this->assertEquals($game->state(), new GameState(Status::GAME_ON, Player::X));
    }

    /**
     * @test
     */
    public function player_O_goes_next(): void
    {
        $game = new Game(new Board(), Status::GAME_ON, null);
        $game = $game->play(Square::TOP_LEFT);

        $this->assertEquals($game->state(), new GameState(Status::GAME_ON, Player::O));
    }

    /**
     * @test
     */
    public function players_alternate_positions(): void
    {
        $game = new Game(new Board(), Status::GAME_ON, null);
        $game = $game->play(Square::TOP_LEFT);
        $game = $game->play(Square::TOP_MIDDLE);

        $this->assertEquals($game->state(), new GameState(Status::GAME_ON, Player::X));
    }

    /**
     * @test
     */
    public function do_not_allow_players_to_play_on_played_positions(): void
    {
        $game = new Game(new Board(), Status::GAME_ON, null);
        $game = $game->play(Square::TOP_LEFT);
        $game = $game->play(Square::TOP_MIDDLE);
        $game = $game->play(Square::TOP_LEFT);

        $this->assertEquals($game->state(), new GameState(Status::POSITION_ALREADY_TAKEN, Player::X));
    }
}
