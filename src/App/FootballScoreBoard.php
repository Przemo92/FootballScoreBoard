<?php

namespace App;

use App\Entity\FootballTeam;
use App\Entity\Game;

class FootballScoreBoard implements ScoreBoardInterface
{
    private array $games = [];

    public function getGames(): array
    {
        return $this->games;
    }

    public function startGame(string $homeTeam, string $awayTeam): bool
    {
        if ($homeTeam === $awayTeam) {
            return false;
        }
        $game = $this->checkGameOnLive($homeTeam, $awayTeam);
        if ($game !== null) {
            return false;
        }

        $homeTeam = new FootballTeam($homeTeam);
        $awayTeam = new FootballTeam($awayTeam);
        $newGame = new Game($homeTeam, $awayTeam, Game::START_GAME_SCORE, Game::START_GAME_SCORE);

        $this->games[] = $newGame;
        return true;
    }

    public function finishGame(string $homeTeamName, string $awayTeamName): bool
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

    public function updateScore(string $homeTeamName, string $awayTeamName, int $homeScore, int $awayScore): bool
    {
        $game = $this->checkGameOnLive($homeTeamName, $awayTeamName);
        if ($game) {
            $game->setHomeScore($homeScore);
            $game->setAwayScore($awayScore);
            return true;
        }
        return false;
    }

    private function checkGameOnLive(string $homeTeam, string $awayTeam)
    {
        foreach ($this->games as $game) {
            $gameHomeTeam = $game->getHomeTeam()->getName();
            $gameAwayTeam = $game->getAwayTeam()->getName();
            if ($homeTeam === $gameHomeTeam && $awayTeam === $gameAwayTeam) {
                return $game;
            }
        }
        return null;
    }
}