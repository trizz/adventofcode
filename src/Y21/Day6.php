<?php

namespace trizz\AdventOfCode\Y21;

use trizz\AdventOfCode\Solution;
use JetBrains\PhpStorm\Immutable;

class Day6 extends Solution
{
    public static int|string|null $part1ExampleResult = 5934;
    public static int|string|null $part1Result = 350917;

    public static int|string|null $part2ExampleResult = 26984457539;
    public static int|string|null $part2Result = 1592918715629;

    /**
     * @var int[]
     * @psalm-param array{int: int}
     */
    #[Immutable]
    protected array $startState = [
        8 => 0,
        7 => 0,
        6 => 0,
        5 => 0,
        4 => 0,
        3 => 0,
        2 => 0,
        1 => 0,
        0 => 0,
    ];

    /**
     * {@inheritdoc}
     */
    public function part1(array $data): int
    {
        return $this->processPuzzle(80, $data[0]);
    }

    /**
     * {@inheritdoc}
     */
    public function part2(array $data): int
    {
        return $this->processPuzzle(256, $data[0]);
    }

    /**
     * @param int[] $state
     * @psalm-param array{int: int} $state
     *
     * @return array
     */
    protected function processDay(array $state): array
    {
        $newState = $state;

        /**
         * @var int $key
         * @var int $stateValue
         */
        foreach ($state as $key => $stateValue) {
            $newKey = $key - 1;

            if ($newKey < 0) {
                $newState[8] = $stateValue;
                $newKey = 6;
            }

            $newState[$key] -= $stateValue;
            $newState[$newKey] += $stateValue;
        }

        return $newState;
    }

    protected function processPuzzle(int $numberOfDays, string $data): int
    {
        $state = $this->startState;

        array_map(static function (string $stateValue) use (&$state) {
            ++$state[(int) $stateValue];
        }, explode(',', $data));

        for ($day = 0; $day < $numberOfDays; ++$day) {
            $state = $this->processDay($state);
        }

        return (int) array_sum($state);
    }
}
