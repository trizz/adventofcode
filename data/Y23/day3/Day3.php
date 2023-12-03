<?php

namespace trizz\AdventOfCode\Y23;

use trizz\AdventOfCode\Solution;

final class Day3 extends Solution
{
    public static null|int|string $part1ExampleResult = 4361;

    public static null|int|string $part1Result = 539637;

    public static null|int|string $part2ExampleResult = 467835;

    public static null|int|string $part2Result = 82_818_007;

    /**
     * @var string[][]
     */
    private array $matrix = [];

    #[\Override]
    public function part1(array $data): int
    {
        $this->createMatrix($data);
        $score = 0;

        foreach ($this->matrix as $row => $line) {
            foreach (array_keys($line) as $col) {
                $numbers = $this->checkLocation($row, $col);
                $top = (int) $this->processNumbers($numbers['top'], sum: true);
                $bottom = (int) $this->processNumbers($numbers['bottom'], sum: true);

                $score += $top + $bottom + max($numbers['left']) + max($numbers['right']);
            }
        }

        return $score;
    }

    #[\Override]
    public function part2(array $data): int
    {
        $this->createMatrix($data);
        $score = 0;

        foreach ($this->matrix as $row => $line) {
            foreach (array_keys($line) as $col) {
                if ($this->matrix[$row][$col] !== '*') {
                    continue;
                }

                $numbers = $this->checkLocation($row, $col);

                $top = (array) $this->processNumbers($numbers['top']);
                $bottom = (array) $this->processNumbers($numbers['bottom']);
                $left = max($numbers['left']);
                $right = max($numbers['right']);

                $filteredResults = array_filter(array_values(array_merge_recursive($top, $bottom, [$left, $right])));

                if (count($filteredResults) !== 2) {
                    continue;
                }

                $score += array_product($filteredResults);
            }
        }

        return (int) $score;
    }

    /**
     * @param int[] $numbers
     *
     * @return int|int[]
     */
    private function processNumbers(array $numbers, bool $sum = false): array|int
    {
        $result = [];
        if ($numbers[0] !== 0 && $numbers[1] === 0 && $numbers[2] !== 0) {
            $result[] = $numbers[0];
            $result[] = $numbers[2];
        } else {
            $result[] = max($numbers);
        }

        if ($sum) {
            return array_sum($result);
        }

        return $result;
    }

    /**
     * @param string[] $data
     */
    private function createMatrix(array $data): void
    {
        $this->matrix = array_map(static fn ($line): array => str_split((string) $line), $data);
    }

    /**
     * @return array<string, array<int,int>>
     */
    private function checkLocation(int $row, int $col): array
    {
        $current = $this->matrix[$row][$col] ?? '.';
        if ($current === '.' || ctype_digit($current)) {
            return ['top' => [0, 0, 0], 'left' => [0], 'right' => [0], 'bottom' => [0, 0, 0]];
        }

        $numbers = array_fill_keys(['top', 'left', 'right', 'bottom'], []);
        $positions = [
            'top' => [[$row - 1, $col - 1], [$row - 1, $col], [$row - 1, $col + 1]],
            'left' => [[$row, $col - 1]],
            'right' => [[$row, $col + 1]],
            'bottom' => [[$row + 1, $col - 1], [$row + 1, $col], [$row + 1, $col + 1]],
        ];

        foreach ($positions as $direction => $coords) {
            foreach ($coords as $coord) {
                $numbers[$direction][] = (int) $this->getNumber(...$coord);
            }
        }

        return $numbers;
    }

    private function getNumber(int $row, int $col, string $direction = null): ?string
    {
        $number = $this->matrix[$row][$col] ?? null;

        if ($number === null || $number === '.' || !ctype_digit($number)) {
            return null;
        }

        $toLeft = null;
        $toRight = null;

        if ($direction === null || $direction === 'left') {
            $toLeft = $this->getNumber($row, $col - 1, 'left');
        }

        if ($direction === null || $direction === 'right') {
            $toRight = $this->getNumber($row, $col + 1, 'right');
        }

        if ($toLeft !== null) {
            $number = $toLeft.$number;
        }

        if ($toRight !== null) {
            return $number.$toRight;
        }

        return $number;
    }
}
