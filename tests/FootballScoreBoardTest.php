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

    public function testGetSummary(): void
    {
        $this->scoreBoard->startGame("Mexico", "Canada");
        $this->scoreBoard->startGame("Spain", "Brazil");
        $this->scoreBoard->startGame("Germany", "France");
        $this->scoreBoard->startGame("Uruguay", "Italy");
        $this->scoreBoard->startGame("Argentina", "Australia");

        $this->scoreBoard->updateScore("Mexico", "Canada", 0, 5);
        $this->scoreBoard->updateScore("Spain", "Brazil", 10, 2);
        $this->scoreBoard->updateScore("Germany", "France", 2, 2);
        $this->scoreBoard->updateScore("Uruguay", "Italy", 6, 6);
        $this->scoreBoard->updateScore("Argentina", "Australia", 3, 1);

        $summary = $this->scoreBoard->getSummary();

        $this->assertSame("Uruguay 6 - 6 Italy", $summary[0]);
        $this->assertSame("Spain 10 - 2 Brazil", $summary[1]);
        $this->assertSame("Mexico 0 - 5 Canada", $summary[2]);
        $this->assertSame("Argentina 3 - 1 Australia", $summary[3]);
        $this->assertSame("Germany 2 - 2 France", $summary[4]);
    }

    /**
     * @throws ReflectionException
     */
    public function testCheckGameOnLive(): void
    {
        $homeTeam = "Mexico";
        $awayTeam = "Canada";

        $method = new ReflectionMethod(FootballScoreBoard::class, 'checkGameOnLive');
        $this->scoreBoard->startGame($homeTeam, $awayTeam);
        $result = $method->invoke($this->scoreBoard, $homeTeam, $awayTeam);

        $this->assertNotNull($result);
    }

    /**
     * @throws ReflectionException
     */
    public function testSortGamesBySumOfScores()
    {
        $this->scoreBoard->startGame("Mexico", "Canada");
        $this->scoreBoard->startGame("Spain", "Brazil");
        $this->scoreBoard->updateScore("Mexico", "Canada", 0, 5);
        $this->scoreBoard->updateScore("Spain", "Brazil", 10, 2);

        $method = new ReflectionMethod(FootballScoreBoard::class, 'sortGamesBySumOfScores');
        $method->invoke($this->scoreBoard);
        $games = $this->scoreBoard->getGames();

        $this->assertSame("Spain", $games[0]->getHomeTeam()->getName());
        $this->assertSame("Brazil", $games[0]->getAwayTeam()->getName());
    }
}