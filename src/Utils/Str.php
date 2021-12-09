<?php

namespace trizz\AdventOfCode\Utils;

class Str
{
    /**
     * Check if the entirety of string two matches string one.
     *
     * @see https://github.com/MueR/adventofcode/blob/master/src/Util/StringUtil.php
     */
    public static function matchesAll(string $one, string $two): bool
    {
        for ($index = 0, $length = strlen($two); $index < $length; $index++) {
            if (!str_contains($one, $two[$index])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Alphabetically sort characters in a string.
     *
     * @see https://github.com/MueR/adventofcode/blob/master/src/Util/StringUtil.php
     */
    public static function sort(string $string): string
    {
        $letters = array_unique(str_split($string));
        sort($letters, SORT_STRING);

        return implode('', $letters);
    }
}
