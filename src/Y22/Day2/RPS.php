<?php

namespace trizz\AdventOfCode\Y22\Day2;

enum RPS
{
    case ROCK;

    case PAPER;

    case SCISSORS;

    public function score(): int
    {
        return match ($this) {
            self::ROCK => 1,
            self::PAPER => 2,
            self::SCISSORS => 3,
        };
    }

    public function winningOpposite(): RPS
    {
        return match ($this) {
            self::ROCK => self::PAPER,
            self::PAPER => self::SCISSORS,
            self::SCISSORS => self::ROCK,
        };
    }

    public function losingOpposite(): RPS
    {
        return match ($this) {
            self::ROCK => self::SCISSORS,
            self::PAPER => self::ROCK,
            self::SCISSORS => self::PAPER,
        };
    }

    public static function fromPuzzleInput(string $value): RPS
    {
        return match ($value) {
            'A', 'X' => self::ROCK,
            'B', 'Y' => self::PAPER,
            'C', 'Z' => self::SCISSORS,
            default => throw new \LogicException('Invalid value.'),
        };
    }
}
