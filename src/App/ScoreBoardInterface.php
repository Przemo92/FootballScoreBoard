<?php

namespace App;

interface ScoreBoardInterface
{
    public function getGames();
    public function startGame(string $homeTeam, string $awayTeam);
    public function finishGame(string $homeTeamName, string $awayTeamName);
    public function updateScore(string $homeTeamName, string $awayTeamName, int $homeScore, int $awayScore);
}