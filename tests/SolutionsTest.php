<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use trizz\AdventOfCode\Solution;

/**
 * @internal
 */
final class SolutionsTest extends TestCase
{
    /**
     * @dataProvider loadSolutions
     */
    public function testSolutionPart1Example(Solution $solution): void
    {
        $this->runPart($solution, part: 1, testExample: true);
    }

    /**
     * @dataProvider loadSolutions
     *
     * @depends testSolutionPart1Example
     */
    public function testSolutionPart1(Solution $solution): void
    {
        $this->runPart($solution, part: 1, testExample: false);
    }

    /**
     * @dataProvider loadSolutions
     *
     * @depends testSolutionPart1
     */
    public function testSolutionPart2Example(Solution $solution): void
    {
        $this->runPart($solution, part: 2, testExample: true);
    }

    /**
     * @dataProvider loadSolutions
     *
     * @depends testSolutionPart2Example
     */
    public function testSolutionPart2(Solution $solution): void
    {
        $this->runPart($solution, part: 2, testExample: false);
    }

    /**
     * @return array<string, array<int, Solution>>
     */
    public static function loadSolutions(): array
    {
        $classes = [];
        for ($year = 15; $year <= date('y'); ++$year) {
            if (is_dir(__DIR__.'/../src/Y'.$year)) {
                for ($day = 1; $day < 26; ++$day) {
                    $className = sprintf('trizz\\AdventOfCode\\Y%d\\Day%d', $year, $day);
                    if (class_exists($className)) {
                        /** @var Solution $class */
                        $class = new $className();
                        $class->loadData();
                        $classes["Year '".$year.' / Day '.$day] = [$class];
                    }
                }
            }
        }

        return $classes;
    }

    private function runPart(Solution $solution, int $part, bool $testExample): void
    {
        if (
            ($testExample && $solution->hasExampleData())
            || (!$testExample && $solution->hasData())
        ) {
            $expectedResult = $solution::${'part'.$part.($testExample ? 'Example' : null).'Result'};
            if ($expectedResult) {
                $result = $solution->{'part'.$part.'Data'}(useExampleData: $testExample);
                self::assertSame($expectedResult, $result);
            } else {
                $this->markTestSkipped('No '.($testExample ? 'example' : 'expected').' data for part '.$part.'.');
            }
        } else {
            $this->markTestSkipped('No example and expected data for part '.$part.'.');
        }
    }
}
