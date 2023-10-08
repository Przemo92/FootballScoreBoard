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

    public function finishGame($homeTeamName, $awayTeamName): bool
    {
        foreach ($this->games as $key => $game) {
            $homeTeam = $game->getHomeTeam()->getName();
            $awayTeam = $game->getAwayTeam()->getName();

            if ($homeTeam === $homeTeamName && $awayTeam === $awayTeamName) {
                unset($this->games[$key]);
                $this->games = array_values($this->games);
                return true;
            }
        }
        return false;
    }
}