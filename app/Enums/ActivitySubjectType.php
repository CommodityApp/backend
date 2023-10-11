<?php

namespace App\Enums;

use App\Models;
use Filament\Support\Contracts\HasLabel;

enum ActivitySubjectType: string implements HasLabel
{
    // case AnimalLevel = Models\AnimalLevel::class;
    case AnimalType = Models\AnimalType::class;
    case Bunker = Models\Bunker::class;
    case Client = Models\Client::class;
    case Country = Models\Country::class;
    case Order = Models\Order::class;
    // case OrderCalculatedRaw = Models\OrderCalculatedRaw::class;
    case Price = Models\Price::class;
    case Producer = Models\Producer::class;
    case Ration = Models\Ration::class;
    // case RationRaw = Models\RationRaw::class;
    case Raw = Models\Raw::class;
    // case RawPrice = Models\RawPrice::class;
    // case RawPricePivoot = Models\RawPricePivot::class;
    case RawType = Models\RawType::class;
    case Receipt = Models\Receipt::class;
    // case ReceiptRaw = Models\ReceiptRaw::class;
    case User = Models\User::class;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::AnimalType,
            self::Bunker,
            self::Client,
            self::Country,
            self::Order,
            self::Price,
            self::Producer,
            self::Ration,
            self::Raw,
            self::RawType,
            self::Receipt,
            self::User => with(new $this->value)->getTable(),
            default => null,
        };
    }
}
