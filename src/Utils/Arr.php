<?php

namespace trizz\AdventOfCode\Utils;

final class Arr
{
    /**
     * Flatten a multi-dimensional array into a single level.
     *
     * Based on:
     *
     * @see https://github.com/laravel/framework/blob/c16367a1af68d8f3a1addc1a819f9864334e2c66/src/Illuminate/Collections/Arr.php#L221-L249
     *
     * @param array<mixed> $array
     *
     * @return array<mixed>
     */
    public static function flatten(iterable $array, float|int $depth = INF): array
    {
        $result = [];

        foreach ($array as $item) {
            if (!is_array($item)) {
                $result[] = $item;
            } else {
                $values = $depth === 1
                    ? array_values($item)
                    : static::flatten($item, $depth - 1);

                foreach ($values as $value) {
                    $result[] = $value;
                }
            }
        }

        return $result;
    }
}
