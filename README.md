# Advent of Code

[![Build Status](https://drone.trizz.io/api/badges/trizz/adventofcode/status.svg)](https://drone.trizz.io/trizz/adventofcode)

In this repository, you'll find my Advent of Code framework and solutions. If you want to
use this framework for your own solution, just remove all data in the `./data` folder and all
folders for each year in the `./src` folder (for example `./src/Y21`, `./src/Y23`, etc.)

## 🛠 Setup and running
- Run `composer install` to install the dependencies.
- Run `./aoc day {day} {year?}` to run the solution for a specific day. If year is not given, use the current year (for example `./aoc day 1` to run the code for day 1 2023)
- Run `./aoc test {day} {year?}` to run the solution against the specified results.
- Run `./aoc puzzle {day} {year?}` to get the description of the puzzle for the specific day.

> **Tips:**
> - You can add `--one` or `--two` (or `-1` and `-2`) to the day to run the solution for part 1 or part 2.
> - You can add `--skip-example` (or `-s`) to skip the example data.

## 🧪 Testing and quality control
- Run `./vendor/bin/pest` to automatically validate the solutions.
- Run `./vendor/bin/phpstan analyse` to run static analysis on the code.
- Run `./vendor/bin/php-cs-fixer fix` to run (and fix) code style checks.

## 🧩 Add a new puzzle/solution
- Create a directory in `./data/Y??/day?` with the correct name.
  - Create `example.txt` with the example values from the puzzle.
    - If there are different examples for part 1 and part 2, create `example-part1.txt` and `example-part2.txt`.
  - Create `data.txt` with your personal input.
  - (optional) Create `puzzle.md` with the puzzle description. You can use [this plugin](https://github.com/kfarnung/aoc-to-markdown) to easily convert the puzzle to markdown.
- Create a new class in the `src/Y??/Day??.php` directory and make sure it has the structure defined below.

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

