<?php

namespace trizz\AdventOfCode\Y22;

use trizz\AdventOfCode\Solution;

final class Day3 extends Solution
{
    public static null|int|string $part1ExampleResult = 157;

    public static null|int|string $part1Result = 8053;

    public static null|int|string $part2ExampleResult = 70;

    public static null|int|string $part2Result = 2425;

    /**
     * @param array<int, string> $data
     */
    #[\Override]
    public function part1(array $data): int
    {
        $result = 0;
        foreach ($data as $rucksack) {
            /** @var int<1, max> $length */
            $length = max(1, strlen($rucksack) / 2);
            [$left, $right] = str_split($rucksack, $length);
            $result += $this->calculateScore([str_split($left), str_split($right)]);
        }

        return $result;
    }

    /**
     * @param array<int, string> $data
     */
    #[\Override]
    public function part2(array $data): int
    {
        $result = 0;
        $groups = array_chunk($data, 3);
        foreach ($groups as $group) {
            $data = array_map(static fn ($items): array => str_split((string) $items), $group);
            $result += $this->calculateScore($data);
        }

        return $result;
    }

    /**
     * @param array<array<int, string>> $data
     */
    private function calculateScore(array $data = []): int
    {
        $items = array_unique(array_intersect(...$data));

        $result = 0;

        foreach ($items as $item) {
            $position = ord(strtoupper($item)) - ord('A') + 1;
            $result += $position + (ctype_upper($item) ? 26 : 0);
        }

        return $result;
    }
}
