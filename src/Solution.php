<?php

namespace trizz\AdventOfCode;

use JetBrains\PhpStorm\ArrayShape;

abstract class Solution
{
    public static null|int|string $part1ExampleResult = null;

    public static null|int|string $part1Result = null;

    public static null|int|string $part2ExampleResult = null;

    public static null|int|string $part2Result = null;

    /**
     * @var bool When false, do not apply the `array_filter` function when the data is loaded.
     */
    public bool $filterDataOnLoad = true;

    /**
     * @var string[] The data to use.
     *
     * @psalm-suppress PropertyNotSetInConstructor
     */
    public ?array $data = null;

    /**
     * @var array<array<int, string>|null> The example data to use.
     */
    #[ArrayShape(['part1' => 'array|null', 'part2' => 'array|null', 'global' => 'array|null'])]
    public array $exampleData = [
        'global' => null,
        'part1' => null,
        'part2' => null,
    ];

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
        $dataExampleFiles = [
            'global' => sprintf('%s/../data/Y%d/day%d/example.txt', __DIR__, $this->year(), $this->day()),
            'part1' => sprintf('%s/../data/Y%d/day%d/example-part1.txt', __DIR__, $this->year(), $this->day()),
            'part2' => sprintf('%s/../data/Y%d/day%d/example-part2.txt', __DIR__, $this->year(), $this->day()),
        ];

        if (file_exists($dataFile)) {
            $data = file_get_contents($dataFile);
            if ($data !== false) {
                $this->data = $this->filterDataOnLoad ? array_filter(explode(PHP_EOL, $data)) : explode(PHP_EOL, $data);
            }
        }

        foreach ($dataExampleFiles as $type => $filePath) {
            if (file_exists($filePath)) {
                $data = file_get_contents($filePath);
                if ($data !== false) {
                    $this->exampleData[$type] = $this->filterDataOnLoad ? array_filter(explode(PHP_EOL, $data)) : explode(PHP_EOL, $data);
                }
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
        return $this->data !== null && $this->data !== [];
    }

    public function hasExampleData(): bool
    {
        return $this->exampleData['global'] !== [];
    }

    /**
     * @return array{part1: int|string, part2: int|string}
     */
    #[ArrayShape(['part1' => 'int|string', 'part2' => 'int|string'])]
    public function results(bool $useExampleData = true, int $part = 0): array
    {
        return [
            'part1' => ($part === 1 || $part === 0) ? $this->part1Data($useExampleData) : 'n/a',
            'part2' => ($part === 2 || $part === 0) ? $this->part2Data($useExampleData) : 'n/a',
        ];
    }

    public function part1Data(bool $useExampleData = true): int|string
    {
        $data = $useExampleData ? ($this->exampleData['part1'] ?? $this->exampleData['global']) : $this->data;

        return $this->part1($data ?? []);
    }

    public function part2Data(bool $useExampleData = true): int|string
    {
        $data = $useExampleData ? ($this->exampleData['part2'] ?? $this->exampleData['global']) : $this->data;

        return $this->part2($data ?? []);
    }
}
