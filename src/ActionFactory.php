<?php

declare(strict_types=1);
namespace App;

use App\Modules\PlusAction;
use App\Modules\MinusAction;
use App\Modules\MultiplyAction;
use App\Modules\DivisionAction;

class ActionFactory
{
    public static function create(string $action, string $file): AbstractBaseAction
    {
        switch ($action) {
            case 'plus':
                return new PlusAction($file);
            case 'minus':
                return new MinusAction($file);
            case 'multiply':
                return new MultiplyAction($file);
            case 'division':
                return new DivisionAction($file);
            default:
                throw new \InvalidArgumentException("Invalid action: $action , please use plus, minus, multiply or division");
        }
    }



}