<?php

namespace trizzssdddAdventOfCode\Y22;

use trizz\AdventOfCode\Solution;

final class Day1 extends Solution
{
    public static null|int|string $part1ExampleResult = 24000;

    public static null|int|string $part1Result = 72240;

    public static null|int|string $part2ExampleResult = 45000;

    public static null|int|string $part2Result = 210957;

    public bool $filterDataOnLoad = false;

    #[\Override]
    public function part1(array $data): int
    {
        return $this->calculateCalories($data)[0];
    }

    #[\Override]
    public function part2(array $data): int
    {
        $results = $this->calculateCalories($data);

        return $results[0] + $results[1] + $results[2];
    }

    /**
     * @param string[] $data
     *
     * @return int[]
     */
    private function calculateCalories(array $data): array
    {
        $results = [];
        $tmpResult = 0;
        foreach ($data as $value) {
            if ($value !== '') {
                $tmpResult += (int) $value;

                continue;
            }

            $results[] = $tmpResult;
            $tmpResult = 0;
        }

        rsort($results);

        return $results;
    }
}
