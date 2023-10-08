<?php

use App\FootballScoreBoard;
use PHPUnit\Framework\TestCase;

class FootballScoreBoardTest extends TestCase
{
    public function testStartGame()
    {
        $scoreBoard = new FootballScoreBoard();
        $this->assertTrue($scoreBoard->startGame("Mexico", "Canada"));
    }
}