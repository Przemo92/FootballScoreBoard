<?php

namespace App\Entity;

class FootballTeam implements TeamInterface
{
    public string $name;

    public function __construct($name)
    {
        $this->name = $name;
    }
    public function getName(): string
    {
        return $this->name;
    }
}