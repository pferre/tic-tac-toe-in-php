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

    /**
     * @test
     */
    public function ends_in_draw(): void
    {
        $game = new Game(new Board(), Status::GAME_ON, null);

        $game = $game->play(Square::TOP_LEFT);
        $game = $game->play(Square::TOP_MIDDLE);
        $game = $game->play(Square::TOP_RIGHT);
        $game = $game->play(Square::CENTER_LEFT);
        $game = $game->play(Square::CENTER_MIDDLE);
        $game = $game->play(Square::BOTTOM_LEFT);
        $game = $game->play(Square::CENTER_RIGHT);
        $game = $game->play(Square::BOTTOM_RIGHT);
        $game = $game->play(Square::BOTTOM_MIDDLE);

        $this->assertEquals($game->state(), new GameState(Status::DRAW));
    }

    /**
     * @dataProvider gameSequenceDataProvider
     * @test
     * @param array $gameSequence
     */
    public function X_WINS(string ...$gameSequence): void
    {
        $game = new Game(new Board(), Status::GAME_ON, null);

        foreach ($gameSequence as $square) {
            $game = $game->play($square);
        }

        $this->assertEquals($game->state(), new GameState(Status::X_WINS));
    }

    /**
     * @test
     */
    public function o_wins(): void
    {
        $game = new Game(new Board(), Status::GAME_ON, null);

        $game = $game->play(Square::TOP_RIGHT);
        $game = $game->play(Square::TOP_LEFT);
        $game = $game->play(Square::TOP_MIDDLE);
        $game = $game->play(Square::CENTER_LEFT);
        $game = $game->play(Square::CENTER_MIDDLE);
        $game = $game->play(Square::BOTTOM_LEFT);

        $this->assertEquals($game->state(), new GameState(Status::O_WINS));
    }

    public function gameSequenceDataProvider(): array
    {
        return [
            //Vertical left
            [
                Square::TOP_LEFT,
                Square::TOP_MIDDLE,
                Square::CENTER_LEFT,
                Square::CENTER_MIDDLE,
                Square::BOTTOM_LEFT
            ],
            //Vertical middle
            [
                Square::TOP_MIDDLE,
                Square::TOP_LEFT,
                Square::CENTER_MIDDLE,
                Square::CENTER_LEFT,
                Square::BOTTOM_MIDDLE
            ],
            //Vertical right
            [
                Square::TOP_RIGHT,
                Square::TOP_LEFT,
                Square::CENTER_RIGHT,
                Square::CENTER_LEFT,
                Square::BOTTOM_RIGHT
            ],
            //Horizontal top
            [
                Square::TOP_RIGHT,
                Square::BOTTOM_LEFT,
                Square::TOP_MIDDLE,
                Square::CENTER_LEFT,
                Square::TOP_LEFT
            ],
            //Horizontal middle
            [
                Square::CENTER_LEFT,
                Square::TOP_RIGHT,
                Square::CENTER_RIGHT,
                Square::BOTTOM_RIGHT,
                Square::CENTER_MIDDLE
            ],
            //Horizontal bottom
            [
                Square::BOTTOM_RIGHT,
                Square::CENTER_MIDDLE,
                Square::BOTTOM_LEFT,
                Square::CENTER_LEFT,
                Square::BOTTOM_MIDDLE
            ],
            //Diagonal left to right
            [
                Square::TOP_LEFT,
                Square::BOTTOM_LEFT,
                Square::CENTER_MIDDLE,
                Square::CENTER_LEFT,
                Square::BOTTOM_RIGHT
            ],
            //Diagonal right to left
            [
                Square::TOP_RIGHT,
                Square::BOTTOM_RIGHT,
                Square::CENTER_MIDDLE,
                Square::BOTTOM_MIDDLE,
                Square::BOTTOM_LEFT
            ]
        ];
    }
}
