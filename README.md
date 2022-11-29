# Advent of Code

[![Build Status](https://drone.trizz.io/api/badges/trizz/adventofcode/status.svg)](https://drone.trizz.io/trizz/adventofcode)

In this repository, you'll find my Advent of Code framework and solutions. If you want to
use this framework for your own solution, just remove all data in the `./data` folder and all
folders for each year in the `./src` folder (for example `./src/Y21`, `./src/Y22`, etc.)

## 🛠 Setup and running
- Run `composer install` to install the dependencies.
- Run `./aoc day {day} {year?}` to run the solution for a specific day. If year is not given, use the current year (for example `./aoc day 1` to run the code for day 1 2022)
- Run `./aoc puzzle {day} {year?}` to get the description of the puzzle for the specific day.
- Run `composer test` to automatically validate the solutions.

## 🧩 Add a new puzzle/solution
- Create a directory in `./data/Y??/day?` with the correct name.
  - Create `example.txt` with the example values from the puzzle.
  - Create `data.txt` with your personal input.
  - Create `puzzle.md` with the puzzle description. You can use [this plugin](https://github.com/kfarnung/aoc-to-markdown) to easily convert the puzzle to markdown.
- Create a new class in the `src/Y??/Day??.php` directory and make sure it has the structure defined below.
- Run `composer test` to run all the tests.

<details>
  <summary>Solution structure</summary>

```php
<?php

namespace trizz\AdventOfCode\Y21;

// Make sure the classname is correct.
class Day1 extends Solution
{
  // Provide the expected results for part 1.
  public static int $part1ExampleResult = null;
  public static int $part1Result = null;

  // Provide the expected results for part 2.
  public static int $part2ExampleResult = null;
  public static int $part2Result = null;
    
  protected function part1(array $data): int
  {
      // Solution for part 1.
  }

  protected function part2(array $data): int
  {
    // Solution for part 2.
  }
}
```
</details>

