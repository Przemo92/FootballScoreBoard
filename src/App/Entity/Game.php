<?php

namespace App\Entity;

class Game
{
    const START_GAME_SCORE = 0;
    public  TeamInterface $homeTeam;
    public TeamInterface $awayTeam;
    public  int $homeScore;
    public int $awayScore;

    public function __construct($homeTeam, $awayTeam, $homeScore, $awayScore)
    {
        $this->homeTeam = $homeTeam;
        $this->awayTeam = $awayTeam;
        $this->homeScore = $homeScore;
        $this->awayScore = $awayScore;
    }

    public function getHomeTeam(): TeamInterface
    {
        return $this->homeTeam;
    }

    public function setHomeTeam(TeamInterface $homeTeam): void
    {
        $this->homeTeam = $homeTeam;
    }

    public function getAwayTeam(): TeamInterface
    {
        return $this->awayTeam;
    }

    public function setAwayTeam(TeamInterface $awayTeam): void
    {
        $this->awayTeam = $awayTeam;
    }

    public function getHomeScore(): int
    {
        return $this->homeScore;
    }

    public function setHomeScore(int $homeScore): void
    {
        $this->homeScore = $homeScore;
    }

    public function getAwayScore(): int
    {
        return $this->awayScore;
    }

    public function setAwayScore(int $awayScore): void
    {
        $this->awayScore = $awayScore;
    }

}