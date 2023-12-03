<?php

namespace trizz\AdventOfCode\Y21;

use trizz\AdventOfCode\Solution;

final class Day7 extends Solution
{
    public static null|int|string $part1ExampleResult = 37;

    public static null|int|string $part1Result = 344297;

    public static null|int|string $part2ExampleResult = 168;

    public static null|int|string $part2Result = 97_164_301;

    #[\Override]
    public function part1(array $data): int
    {
        return $this->calculateFuel($data[0], forPart2: false);
    }

    #[\Override]
    public function part2(array $data): int
    {
        return $this->calculateFuel($data[0], forPart2: true);
    }

    private function calculateFuel(string $data, bool $forPart2 = false): int
    {
        $crabs = array_map(static fn (string $crab): int => (int) $crab, explode(',', $data));

        /** @var array<int, int> $fuelPerPosition */
        $fuelPerPosition = [];

        $minCrab = min($crabs);
        $maxCrab = max($crabs);

        for ($position = $minCrab; $position <= $maxCrab; ++$position) {
            foreach ($crabs as $crab) {
                if (!isset($fuelPerPosition[$position])) {
                    $fuelPerPosition[$position] = 0;
                }

                $consumption = abs($position - $crab);

                if ($forPart2) {
                    $consumption = $consumption * ($consumption + 1) / 2;
                }

                $fuelPerPosition[$position] += $consumption;
            }
        }

        return (int) min($fuelPerPosition);
    }
}
