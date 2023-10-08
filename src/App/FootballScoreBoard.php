<?php

namespace App;

use App\Entity\FootballTeam;
use App\Entity\Game;

class FootballScoreBoard
{
    private array $games = [];

    public function getGames(): array
    {
        return $this->games;
    }
    public function startGame($homeTeam, $awayTeam): bool
    {
        if ($homeTeam === $awayTeam) {
            return false;
        }
        $homeTeam = new FootballTeam($homeTeam);
        $awayTeam = new FootballTeam($awayTeam);
        $newGame = new Game($homeTeam, $awayTeam, Game::START_GAME_SCORE, Game::START_GAME_SCORE);

        $this->games[] = $newGame;
        return true;
    }
}