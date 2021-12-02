<?php

namespace AdventOfCode21;

class Day2 extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected static int $day = 2;

    /**
     * {@inheritdoc}
     */
    protected function part1(array $data): int
    {
        $depth = 0;
        $horizontal = 0;

        /** @var string $current */
        foreach ($data as $current) {
            /**
             * @var string $direction
             * @var int    $distance
             */
            [$direction, $distance] = explode(' ', $current);

            switch ($direction) {
                case 'forward':
                    $horizontal += $distance;

                    break;

                case 'down':
                    $depth += $distance;

                    break;

                case 'up':
                    $depth -= $distance;

                    break;
            }
        }

        return $depth * $horizontal;
    }

    /**
     * {@inheritdoc}
     */
    protected function part2(array $data): int
    {
        $aim = 0;
        $depth = 0;
        $horizontal = 0;

        /** @var string $current */
        foreach ($data as $current) {
            /**
             * @var string $direction
             * @var int    $distance
             */
            [$direction, $distance] = explode(' ', $current);

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
