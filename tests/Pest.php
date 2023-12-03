<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

// uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

use trizz\AdventOfCode\Solution;

expect()->extend('toBeOne', fn() => $this->toBe(1));

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * @return array<string, class-string>
 */
function loadSolutions(int $year): array
{
    $classes = [];
    if (is_dir(__DIR__.'/../src/Y'.$year)) {
        for ($day = 1; $day < 26; ++$day) {
            $className = sprintf('trizz\\AdventOfCode\\Y%d\\Day%d', $year, $day);
            if (class_exists($className)) {
                $classes["Year '".$year.' / Day '.$day] = $className;
            }
        }
    }

    return $classes;
}

function runTestForDay($class, string $name, $testDataMethod, $expectedResult, $isExampleData): void
{
    $fullName = $name.' / '.($isExampleData ? 'Example' : 'Input');
    test($fullName, function () use ($isExampleData, $class, $testDataMethod, $expectedResult) : void {
        expect($class->{$testDataMethod}($isExampleData))->toBe($class::${$expectedResult});
    })->skip(!$class->hasExampleData() || $class::${$expectedResult} === null);
}

function testYear(int $year): void
{
    $solutions = loadSolutions($year);
    foreach ($solutions as $name => $className) {
        describe('Y'.$year, static function () use ($name, $className) : void {
            /** @var Solution $class */
            $class = new $className();
            $class->loadData();
            runTestForDay($class, $name.' / Part 1', 'part1Data', 'part1ExampleResult', true);
            runTestForDay($class, $name.' / Part 2', 'part2Data', 'part2ExampleResult', true);
            runTestForDay($class, $name.' / Part 1', 'part1Data', 'part1Result', false);
            runTestForDay($class, $name.' / Part 2', 'part2Data', 'part2Result', false);
        })->group('Y'.$year);
    }
}
