<?php

declare(strict_types=1);

namespace App;

interface ActionInterface
{
    /**
     * execute action
     */
    public function execute(): void;

    /**
     * count result
     * @param int $value1
     * @param int $value2
     * @return int|float
     */
    public function countResult(int $value1, int $value2): int|float;

}