# Advent of Code 2021

In this repository, you'll find my solutions.

[![CI](https://github.com/trizz/adventofcode21/actions/workflows/ci.yaml/badge.svg)](https://github.com/trizz/adventofcode21/actions/workflows/ci.yaml)

## 🛠 Setup and running
- Run `composer install` to install the dependencies.
- Run `./aoc21 {day}` to run the solution for a specific day (for example `./aoc21 1` to run the code for day 1)
- Run `./aoc21 puzzle {day}` to get the description of the puzzle for the specific day.
- Run `composer test` to automatically validate the solutions.

## 🧩 Add a new puzzle/solution
- Create a directory in `./data` with the correct name.
  - Create `example.txt` with the example values from the puzzle.
  - Create `data.txt` with your personal input.
  - Create `puzzle.md` with the puzzle. You can use [this plugin](https://github.com/kfarnung/aoc-to-markdown) to easily convert the puzzle to markdown.
- Create a new class in the `src` directory and make sure it has the  structure defined below.
- Add this class to the `./aoc21` file, and you can run it.
- Add a new test in `./tests` with structure defined below.
- Run `composer test` to run all the tests.

<details>
  <summary>Solution command structure</summary>

```php
<?php

namespace AdventOfCode21;

// Make sure the classname is correct.
class Day1 extends AbstractCommand
{
  // Update this to the day number.
  protected static int $day = 1;

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

<details>
  <summary>Solution test structure</summary>

```php
<?php

namespace Tests;

// Make sure the classname is correct.
class Day1Test extends AbstractTestCase
{
    // Provide the expected results for part 1.
    public static int $part1ExampleResult = 7;
    public static int $part1Result = 1688;

    // Provide the expected results for part 2.
    public static int $part2ExampleResult = 5;
    public static int $part2Result = 1728;

    // Make a new instance of the command with the 'ReturnTestableResults' trait.
    public function setupDay(): Day1
    {
        return new class() extends Day1 {
            use ReturnTestableResults;
        };
    }
}

```
</details>

