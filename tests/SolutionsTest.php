<?php

namespace Tests;

use trizz\AdventOfCode\ExecuteDay;
use PHPUnit\Framework\TestCase;
use trizz\AdventOfCode\Solution;

class SolutionsTest extends TestCase
{
    /**
     * @dataProvider loadSolutions
     */
    public function testSolutionPart1Example(Solution $class): void
    {
        $this->runPart($class, part: 1, testExample: true);
    }

    /**
     * @dataProvider loadSolutions
     * @depends testSolutionPart1Example
     */
    public function testSolutionPart1(Solution $class): void
    {
        $this->runPart($class, part: 1, testExample: false);
    }

    /**
     * @dataProvider loadSolutions
     * @depends testSolutionPart1
     */
    public function testSolutionPart2Example(Solution $class): void
    {
        $this->runPart($class, part: 2, testExample: true);
    }

    /**
     * @dataProvider loadSolutions
     * @depends testSolutionPart2Example
     */
    public function testSolutionPart2(Solution $class): void
    {
        $this->runPart($class, part: 2, testExample: false);
    }

    private function runPart(Solution $class, int $part, bool $testExample): void
    {
        if (
            ($testExample && $class->hasExampleData())
            || (!$testExample && $class->hasData())
        ) {
            $expectedResult = $class::${'part'.$part.($testExample ? 'Example' : null).'Result'};
            if ($expectedResult) {
                $result = $class->{'part'.$part.'Data'}(useExampleData: $testExample);
                self::assertSame($expectedResult, $result);
            } else {
                $this->markTestSkipped('No '.($testExample ? 'example' : 'expected').' data for part '.$part.'.');
            }
        } else {
            $this->markTestSkipped('No example and expected data for part '.$part.'.');
        }
    }

    public function loadSolutions(): array
    {
        $classes = [];
        for ($year = 15; $year <= date('y'); $year++) {
            if (is_dir(__DIR__.'/../src/Y'.$year)) {
                for ($day = 1; $day < 26; $day++) {
                    $className = sprintf("trizz\\AdventOfCode\\Y%d\\Day%d", $year, $day);
                    if (class_exists($className)) {
                        $class = new $className();
                        $class->loadData();
                        $classes['Year \''.$year.' / Day '.$day] = [$class];
                    }
                }
            }
        }

        return $classes;
    }
}
