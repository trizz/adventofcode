<?php

namespace trizz\AdventOfCode\Y23;

final class Day5 extends \trizz\AdventOfCode\Solution
{
    public static null|int|string $part1ExampleResult = 35;

    public static null|int|string $part1Result = 525_792_406;

    public static null|int|string $part2ExampleResult = null;

    public static null|int|string $part2Result = null;

    /**
     * @var int[]
     */
    private array $seeds = [];

    /**
     * @var array<array<array<string, int>>>
     */
    private array $maps = [
        'seed-to-soil' => [],
        'soil-to-fertilizer' => [],
        'fertilizer-to-water' => [],
        'water-to-light' => [],
        'light-to-temperature' => [],
        'temperature-to-humidity' => [],
        'humidity-to-location' => [],
    ];

    #[\Override]
    public function part1(array $data): int
    {
        $this->parseInput($data);
        $locations = [];
        foreach ($this->seeds as $seed) {
            $soil = $this->valueInMap($seed, 'seed-to-soil');
            $fertilizer = $this->valueInMap($soil, 'soil-to-fertilizer');
            $water = $this->valueInMap($fertilizer, 'fertilizer-to-water');
            $light = $this->valueInMap($water, 'water-to-light');
            $temperature = $this->valueInMap($light, 'light-to-temperature');
            $humidity = $this->valueInMap($temperature, 'temperature-to-humidity');
            $location = $this->valueInMap($humidity, 'humidity-to-location');

            $locations[$seed] = $location;
        }

        return min($locations);
    }

    #[\Override]
    public function part2(array $data): int
    {
        return -1;
    }

    private function valueInMap(int $value, string $map): int
    {
        foreach ($this->maps[$map] as $mapValue) {
            $sourceRangeStart = $mapValue['sourceRangeStart'];
            $sourceRangeEnd = $sourceRangeStart + $mapValue['rangeLength'];
            if ($value < $sourceRangeStart) {
                continue;
            }

            if ($value >= (int) $sourceRangeEnd) {
                continue;
            }

            return $mapValue['destinationRange'] + $value - $sourceRangeStart;
        }

        return $value;
    }

    /**
     * @param string[] $data
     */
    private function parseInput(array $data): void
    {
        $currentMap = null;
        foreach ($data as $line) {
            if (str_contains($line, ':')) {
                $a = explode(':', $line);
                if (str_ends_with($a[0], ' map')) {
                    $a[0] = substr($a[0], 0, -4);
                    $currentMap = $a[0];
                }

                if ($a[0] === 'seeds') {
                    $this->seeds = array_map('intval', array_filter(explode(' ', $a[1])));

                    continue;
                }
            }

            if (!empty($line) && !str_contains($line, ':')) {
                [$destinationRange, $sourceRangeStart, $rangeLength] = array_values(array_map('intval', explode(' ', $line)));
                $this->maps[$currentMap][] = [
                    'destinationRange' => $destinationRange,
                    'sourceRangeStart' => $sourceRangeStart,
                    'rangeLength' => $rangeLength,
                ];
            }
        }
    }
}
