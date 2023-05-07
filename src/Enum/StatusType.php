<?php

declare(strict_types=1);

namespace App\Enum;

enum StatusType: string
{
    case in_progress = "in_progress";
    case done = "done";
    case blocked = "blocked";

    /**
     * @return array<string,string>
     */
    public static function getAsArray(): array
    {
        return array_reduce(
            self::cases(),
            static fn (array $choices, StatusType $type) => $choices + [$type->name => $type->value],
            [],
        );
    }
}