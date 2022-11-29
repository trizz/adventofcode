<?php

namespace trizz\AdventOfCode\Y21;

use trizz\AdventOfCode\Solution;

final class Day7 extends Solution
{
    public static int|string|null $part1ExampleResult = 37;

    public static int|string|null $part1Result = 344297;

    public static int|string|null $part2ExampleResult = 168;

    public static int|string|null $part2Result = 97_164_301;

    /**
     * {@inheritdoc}
     */
    public function part1(array $data): int
    {
        return $this->calculateFuel($data[0], forPart2: false);
    }

    /**
     * {@inheritdoc}
     */
    public function part2(array $data): int
    {
        return $this->calculateFuel($data[0], forPart2: true);
    }

    private function calculateFuel(string $data, bool $forPart2 = false): int
    {
        $crabs = array_map(static fn (string $crab) => (int) $crab, explode(',', $data));

        /** @psalm-param array{int: int} $fuelPerPosition */
        $fuelPerPosition = [];

        for ($position = min($crabs); $position <= max($crabs); ++$position) {
            foreach ($crabs as $crab) {
                if (!isset($fuelPerPosition[$position])) {
                    $fuelPerPosition[$position] = 0;
                }

                $consumption = abs($position - $crab);

                if ($forPart2) {
                    $newConsumption = 0;
                    // I'm sure there's another way than brute-forcing, but hey, this also works!
                    for ($steps = 1; $steps <= $consumption; ++$steps) {
                        $newConsumption += $steps;
                    }

                    $consumption = $newConsumption;
                }

                $fuelPerPosition[$position] += $consumption;
            }
        }

        /** @psalm-suppress ArgumentTypeCoercion */
        return min($fuelPerPosition);
    }
}
