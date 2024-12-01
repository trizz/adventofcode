<?php

namespace trizz\AdventOfCode\Y21;

use trizz\AdventOfCode\Solution;

final class Day2 extends Solution
{
    public static null|int|string $part1ExampleResult = 150;

    public static null|int|string $part1Result = 1_654_760;

    public static null|int|string $part2ExampleResult = 900;

    public static null|int|string $part2Result = 1_956_047_400;

    #[\Override]
    public function part1(array $data): int
    {
        $depth = 0;
        $horizontal = 0;

        foreach ($data as $current) {
            [$direction, $distance] = explode(' ', $current);
            $direction = (string) $direction;
            $distance = (int) $distance;

            match ($direction) {
                'forward' => $horizontal += $distance,
                'down' => $depth += $distance,
                'up' => $depth -= $distance,
                default => null,
            };
        }

        return $depth * $horizontal;
    }

    #[\Override]
    public function part2(array $data): int
    {
        $aim = 0;
        $depth = 0;
        $horizontal = 0;

        foreach ($data as $current) {
            [$direction, $distance] = explode(' ', $current);
            $direction = (string) $direction;
            $distance = (int) $distance;

            // Can't use 'match' here because of the multiple expressions for 'forward'.
            switch ($direction) {
                case 'forward':
                    $horizontal += $distance;
                    $depth += $distance * $aim;

                    break;

                case 'down':
                    $aim += $distance;

                    break;

                case 'up':
                    $aim -= $distance;

                    break;
            }
        }

        return $horizontal * $depth;
    }
}
