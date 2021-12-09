<?php

namespace trizz\AdventOfCode\Y21;

use trizz\AdventOfCode\Solution;

class Day2 extends Solution
{
    public static int|string|null $part1ExampleResult = 150;
    public static int|string|null $part1Result = 1654760;

    public static int|string|null $part2ExampleResult = 900;
    public static int|string|null $part2Result = 1956047400;

    /**
     * {@inheritdoc}
     */
    public function part1(array $data): int
    {
        $depth = 0;
        $horizontal = 0;

        foreach ($data as $current) {
            /**
             * @var string $direction
             * @var int    $distance
             */
            [$direction, $distance] = explode(' ', $current);

            match ($direction) {
                'forward' => $horizontal += $distance,
                'down' => $depth += $distance,
                'up' => $depth -= $distance,
                default => null,
            };
        }

        return $depth * $horizontal;
    }

    /**
     * {@inheritdoc}
     */
    public function part2(array $data): int
    {
        $aim = 0;
        $depth = 0;
        $horizontal = 0;

        foreach ($data as $current) {
            /**
             * @var string $direction
             * @var int    $distance
             */
            [$direction, $distance] = explode(' ', $current);

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
