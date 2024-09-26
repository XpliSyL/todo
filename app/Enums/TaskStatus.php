<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum TaskStatus: string implements HasLabel, HasColor, HasIcon
{
    case Draft = 'draft';
    case Todo = 'todo';
    case Waiting = 'waiting';
    case Done = 'done';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft => 'Brouillon',
            self::Todo => 'À faire',
            self::Waiting => 'En attente',
            self::Done => 'Terminé',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Todo => 'warning',
            self::Waiting => 'warning',
            self::Done => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Draft => 'heroicon-m-pencil',
            self::Todo => 'heroicon-m-eye',
            self::Waiting => 'heroicon-m-eye',
            self::Done => 'heroicon-m-check',
        };
    }
}
