<?php

namespace trizz\AdventOfCode\Commands;

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Printer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use trizz\AdventOfCode\Solution;

use function Laravel\Prompts\text;

final class AddDay extends Command
{
    #[\Override]
    protected function configure(): void
    {
        $this
            ->setName('add:day')
            ->setDescription('Add a new day.')
            ->addArgument('day', InputArgument::OPTIONAL, 'The day number.')
            ->addArgument('year', InputArgument::OPTIONAL, 'The year', date('y'));
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day = $input->getArgument('day');
        $year = $input->getArgument('year');

        if ($day === null) {
            $day = text(
                label: 'For which day?',
                placeholder: '3',
                default: date('j'),
                required: true,
                validate: fn ($value) => is_numeric($value) && $value > 0 && $value < 26 ? null : 'Please enter a valid day number.'
            );
        }

        $example1Result = text(
            label: 'Please enter the result for example 1.',
            required: true,
            validate: fn ($value) => is_numeric($value) ? null : 'Please enter a valid number.'
        );

        // Create short year.
        $year = strlen($year) === 4 ? substr($year, 2) : $year;

        $output->writeln("Adding files for day {$day} of year '{$year}.");

        $this
            ->createDirs($year, $day)
            ->createClass($day, $year, $example1Result)
            ->addExampleDirs($year, $day);

        return Command::SUCCESS;
    }

    protected function createDirs(int $year, int $day): self
    {
        if (!is_dir($dir = "src/Y{$year}") && !mkdir($dir) && !is_dir($dir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
        }

        if (!is_dir($dir = "data/Y{$year}/day{$day}") && !mkdir($dir) && !is_dir($dir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
        }

        return $this;
    }

    protected function createClass(string $day, string $year, string $example1Result): self
    {
        $namespace = new PhpNamespace('trizz\AdventOfCode\Y'.$year);
        $class = new ClassType('Day'.$day);

        $class->setFinal()
            ->setExtends(Solution::class);

        $this->createClassProperties($class, $example1Result);
        $this->createClassMethods($class);

        $namespace->add($class);
        $this->printClassToFile($class, $year, $day, $namespace);

        return $this;
    }

    private function createClassProperties(ClassType $class, string $example1Result): void
    {
        $properties = [
            'part1ExampleResult' => $example1Result,
            'part1Result' => null,
            'part2ExampleResult' => null,
            'part2Result' => null,
        ];

        foreach ($properties as $name => $value) {
            $class
                ->addProperty($name, $value)
                ->setPublic()
                ->setStatic()
                ->setType('null|int|string');
        }
    }

    private function createClassMethods(ClassType $class): void
    {
        $methods = ['part1', 'part2'];

        foreach ($methods as $methodName) {
            $class
                ->addMethod($methodName)
                ->setReturnType('int')
                ->setBody('return -1;')
                ->addParameter('data')->setType('array');
        }
    }

    private function printClassToFile(ClassType $class, string $year, string $day, PhpNamespace $namespace): void
    {
        $printer = new Printer();
        $printer->indentation = '    ';

        $filename = __DIR__.'/../Y'.$year.'/Day'.$day.'.php';
        if (file_exists($filename)) {
            throw new \RuntimeException("File {$filename} already exists.");
        }

        file_put_contents($filename, '<?php'.PHP_EOL.$printer->printNamespace($namespace));
    }

    protected function addExampleDirs(mixed $year, mixed $day): self
    {
        $dataDir = __DIR__.'/../../data/Y'.$year.'/day'.$day;

        if (!is_dir($dataDir) && !mkdir($dataDir) && !is_dir($dataDir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $dataDir));
        }

        touch($dataDir.'/example.txt');
        touch($dataDir.'/data.txt');

        return $this;
    }
}
