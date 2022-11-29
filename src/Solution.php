<?php

namespace trizz\AdventOfCode;

use JetBrains\PhpStorm\ArrayShape;

abstract class Solution
{
    public static int|string|null $part1ExampleResult = null;

    public static int|string|null $part1Result = null;

    public static int|string|null $part2ExampleResult = null;

    public static int|string|null $part2Result = null;

    /**
     * @var string[] The data to use.
     *
     * @psalm-suppress PropertyNotSetInConstructor
     */
    public ?array $data = null;

    /**
     * @var string[] The example data.
     *
     * @psalm-suppress PropertyNotSetInConstructor
     */
    public ?array $exampleData = null;

    /**
     * Solve the given data for part one of the puzzle.
     *
     * @param string[] $data The data to process.
     *
     * @return int|string The result or null if not (yet?) implemented.
     */
    public function part1(array $data): int|string
    {
        return 'n/a';
    }

    /**
     * Solve the given data for part one of the puzzle.
     *
     * @param string[] $data The data to process.
     *
     * @return int|string The result or null if not (yet?) implemented.
     */
    public function part2(array $data): int|string
    {
        return 'n/a';
    }

    public function loadData(): void
    {
        $dataFile = sprintf('%s/../data/Y%d/day%d/data.txt', __DIR__, $this->year(), $this->day());
        $dataExampleFile = sprintf('%s/../data/Y%d/day%d/example.txt', __DIR__, $this->year(), $this->day());

        if (file_exists($dataFile)) {
            $data = file_get_contents($dataFile);
            if ($data !== false) {
                $this->data = array_filter(explode(PHP_EOL, $data));
            }
        }

        if (file_exists($dataExampleFile)) {
            $data = file_get_contents($dataExampleFile);
            if ($data !== false) {
                $this->exampleData = array_filter(explode(PHP_EOL, $data));
            }
        }
    }

    public function year(): int
    {
        return (int) substr(explode('\\', static::class)[2], 1);
    }

    public function day(): int
    {
        return (int) substr(explode('\\', static::class)[3], 3);
    }

    public function hasData(): bool
    {
        return !empty($this->data);
    }

    public function hasExampleData(): bool
    {
        return !empty($this->exampleData);
    }

    /**
     * @return array{part1: int|string, part2: int|string}
     */
    #[ArrayShape(['part1' => 'int|string', 'part2' => 'int|string'])]
    public function results(bool $useExampleData = true): array
    {
        $data = $useExampleData ? $this->exampleData : $this->data;

        return [
            'part1' => $this->part1($data ?? []),
            'part2' => $this->part2($data ?? []),
        ];
    }

    public function part1Data(bool $useExampleData = true): int|string
    {
        $data = $useExampleData ? $this->exampleData : $this->data;

        return $this->part1($data ?? []);
    }

    public function part2Data(bool $useExampleData = true): int|string
    {
        $data = $useExampleData ? $this->exampleData : $this->data;

        return $this->part2($data ?? []);
    }
}
