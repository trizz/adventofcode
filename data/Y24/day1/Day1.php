<?php

namespace trizz\AdventOfCode\Y24;

use trizz\AdventOfCode\Solution;

final class Day1 extends Solution
{
    public static null|int|string $part1ExampleResult = 11;

    public static null|int|string $part1Result = 1882714;

    public static null|int|string $part2ExampleResult = 31;

    public static null|int|string $part2Result = 19437052;

    #[\Override]
    public function part1(array $data): int
    {
        [$listLeft, $listRight] = $this->getList($data);
        $score = 0;
        foreach ($listLeft as $index => $left) {
            $right = $listRight[$index];
            $score += abs($left - $right);
        }

        return $score;
    }

    #[\Override]
    public function part2(array $data): int
    {
        $score = 0;
        [$listLeft, $listRight] = $this->getList($data);

        foreach ($listLeft as $index => $left) {
            $right = count(array_filter($listRight, fn ($x): bool => $x === $left));
            if ($right > 0) {
                $score += $left * $right;
            }
        }

        return $score;
    }

    /**
     * @param array<int,string> $data
     *
     * @return array<int,int[]>
     */
    private function getList(array $data): array
    {
        $listLeft = [];
        $listRight = [];
        foreach ($data as $x) {
            [$a1, $_, $_, $b1] = explode(' ', $x);
            $listLeft[] = (int) $a1;
            $listRight[] = (int) $b1;
        }

        sort($listLeft);
        sort($listRight);

        return [$listLeft, $listRight];
    }
}
