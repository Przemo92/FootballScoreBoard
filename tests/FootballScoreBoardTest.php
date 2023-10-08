<?php

use App\Entity\Game;
use App\FootballScoreBoard;
use PHPUnit\Framework\TestCase;

class FootballScoreBoardTest extends TestCase
{
    private FootballScoreBoard $scoreBoard;

    protected function setUp(): void
    {
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

    public function testFinishGame(): void
    {
        $this->scoreBoard->startGame("Mexico", "Canada");
        $this->scoreBoard->startGame("Spain", "Brazil");

        $this->assertTrue($this->scoreBoard->finishGame("Mexico", "Canada"));

        $games = $this->scoreBoard->getGames();
        $this->assertCount(1, $games);
    }

    public function testUpdateScore(): void
    {
        $this->scoreBoard->startGame("Mexico", "Canada");
        $isUpdated = $this->scoreBoard->updateScore("Mexico", "Canada", 2, 1);
        $isNotUpdated = $this->scoreBoard->updateScore("Mexico", "Brazil", 2, 1);

        $games = $this->scoreBoard->getGames();
        $game = $games[0];

        $this->assertTrue($isUpdated);
        $this->assertFalse($isNotUpdated);
        $this->assertSame(2, $game->getHomeScore());
        $this->assertSame(1, $game->getAwayScore());
    }

    /**
     * @throws ReflectionException
     */
    public function testCheckGameOnLive(): void
    {
        $method = new ReflectionMethod(FootballScoreBoard::class, 'checkGameOnLive');
        $method->setAccessible(true);

        $homeTeam = "Mexico";
        $awayTeam = "Canada";
        $this->scoreBoard->startGame($homeTeam, $awayTeam);
        $result = $method->invoke($this->scoreBoard, $homeTeam, $awayTeam);

        $this->assertSame($homeTeam, $result->getHomeTeam()->getName());
        $this->assertSame($awayTeam, $result->getAwayTeam()->getName());
    }
}