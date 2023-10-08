<?php

use App\Entity\Game;
use App\FootballScoreBoard;
use PHPUnit\Framework\TestCase;

class FootballScoreBoardTest extends TestCase
{
    private FootballScoreBoard $scoreBoard;

    protected function setUp(): void
    {
        // Create a new FootballScoreBoard instance before each test
        $this->scoreBoard = new FootballScoreBoard();
    }
    public function testStartGame(): void
    {
        $isStarted1 = $this->scoreBoard->startGame("Mexico", "Canada");
        $isStarted2 = $this->scoreBoard->startGame("Mexico", "Mexico");

        $games = $this->scoreBoard->getGames();
        $game = $games[0];

        $this->assertTrue($isStarted1);
        $this->assertFalse($isStarted2);
        $this->assertCount(1, $games);
        $this->assertSame("Mexico", $game->getHomeTeam()->getName());
        $this->assertSame("Canada", $game->getAwayTeam()->getName());
        $this->assertSame(Game::START_GAME_SCORE, $game->getHomeScore());
        $this->assertSame(Game::START_GAME_SCORE, $game->getAwayScore());

    }
}