<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;

enum StatusEnum: string implements HasColor
{
    case Published = 'published';
    case Rejected = 'rejected';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Published => 'Active',
            self::Rejected => 'Inactive',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Published => 'success',
            self::Rejected => 'danger',
        };
    }
}
