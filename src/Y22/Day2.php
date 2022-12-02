<?php

namespace trizz\AdventOfCode\Y22;

use trizz\AdventOfCode\Solution;
use trizz\AdventOfCode\Y22\Day2\RPS;

final class Day2 extends Solution
{
    public static int|string|null $part1ExampleResult = 15;

    public static int|string|null $part1Result = 10994;

    public static int|string|null $part2ExampleResult = 12;

    public static int|string|null $part2Result = 12526;

    public function part1(array $data): int
    {
        $score = 0;
        foreach ($data as $round) {
            [$opponentDraw, $ownDraw] = explode(' ', $round);
            $ownDraw = RPS::fromPuzzleInput($ownDraw);
            $opponentDraw = RPS::fromPuzzleInput($opponentDraw);
            $score += $this->calculateScore($ownDraw, $opponentDraw);
        }

        return $score;
    }

    public function part2(array $data): int
    {
        $score = 0;
        foreach ($data as $round) {
            [$opponentDraw, $expectedResult] = explode(' ', $round);
            $opponentDraw = RPS::fromPuzzleInput($opponentDraw);

            $score += match ($expectedResult) {
                'X' => $this->calculateScore($opponentDraw->losingOpposite(), $opponentDraw),
                'Y' => $this->calculateScore($opponentDraw, $opponentDraw),
                'Z' => $this->calculateScore($opponentDraw->winningOpposite(), $opponentDraw),
                default => 0,
            };
        }

        return $score;
    }

    private function calculateScore(RPS $ownDraw, RPS $opponentDraw): int
    {
        // Win
        if ($ownDraw->losingOpposite() === $opponentDraw) {
            return $ownDraw->score() + 6;
        }

        // Lost
        if ($ownDraw->winningOpposite() === $opponentDraw) {
            return $ownDraw->score();
        }

        // Draw.
        return $ownDraw->score() + 3;
    }
}
