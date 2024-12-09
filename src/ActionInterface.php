<?php

declare(strict_types=1);

namespace App;

interface ActionInterface
{
    public function execute(): void;

    public function countResult(int $value1, int $value2): int|float;

}