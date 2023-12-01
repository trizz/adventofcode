<?php

namespace trizz\AdventOfCode\Y21;

use JetBrains\PhpStorm\Immutable;
use trizz\AdventOfCode\Solution;

final class Day6 extends Solution
{
    public static null|int|string $part1ExampleResult = 5934;

    public static null|int|string $part1Result = 350917;

    public static null|int|string $part2ExampleResult = 26_984_457_539;

    public static null|int|string $part2Result = 1_592_918_715_629;

    /**
     * @var int[]
     *
     * @psalm-param array{int: int}
     */
    #[Immutable] private array $startState = [
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

    #[\Override]
    public function part1(array $data): int
    {
        return $this->processPuzzle(80, $data[0]);
    }

    #[\Override]
    public function part2(array $data): int
    {
        return $this->processPuzzle(256, $data[0]);
    }

    /**
     * @param int[] $state
     *
     * @psalm-param array{int: int} $state
     */
    private function processDay(array $state): array
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

    private function processPuzzle(int $numberOfDays, string $data): int
    {
        $state = $this->startState;

        array_map(static function (string $stateValue) use (&$state): void {
            ++$state[(int) $stateValue];
        }, explode(',', $data));

        for ($day = 0; $day < $numberOfDays; ++$day) {
            $state = $this->processDay($state);
        }

        return (int) array_sum($state);
    }
}
