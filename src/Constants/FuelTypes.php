<?php

namespace App\Constants;

class FuelTypes
{
    public const FUEL_TYPES = array(
        'Diesel' => FuelTypes::DIESEL,
        'Gasoline' => FuelTypes::GASOLINE,
        'Electric' => FuelTypes::ELECTRIC,
        'Hybrid' => FuelTypes::HYBRID
    );

    public const DIESEL = "Diesel";
    public const GASOLINE = "Gasoline";
    public const ELECTRIC = "Electric";
    public const HYBRID = "Hybrid";
}