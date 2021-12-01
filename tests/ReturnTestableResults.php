<?php

namespace Tests;

use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

trait ReturnTestableResults
{
    public function part1ExampleResult(): int|string|null
    {
        $this->initialize(new StringInput(''), new NullOutput());

        return $this->part1($this->exampleData);
    }

    public function part1Result(): int|string|null
    {
        $this->initialize(new StringInput(''), new NullOutput());

        return $this->part1($this->data);
    }

    public function part2ExampleResult(): int|string|null
    {
        $this->initialize(new StringInput(''), new NullOutput());

        return $this->part2($this->exampleData);
    }

    public function part2Result(): int|string|null
    {
        $this->initialize(new StringInput(''), new NullOutput());

        return $this->part2($this->data);
    }
}
