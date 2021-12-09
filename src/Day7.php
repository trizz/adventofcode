<?php

namespace AdventOfCode21;

class Day7 extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected static int $day = 7;

    /**
     * {@inheritdoc}
     */
    protected function part1(array $data): int
    {
        return $this->calculateFuel($data[0], forPart2: false);
    }

    /**
     * {@inheritdoc}
     */
    protected function part2(array $data): int
    {
        return $this->calculateFuel($data[0], forPart2: true);
    }

    /**
     * @param string $data
     * @param bool   $forPart2
     *
     * @return int
     */
    protected function calculateFuel(string $data, bool $forPart2 = false): int
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
