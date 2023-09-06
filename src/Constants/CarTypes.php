<?php
namespace App\Constants;

class CarTypes
{
    public const CARTYPES = array(
        'Car' => CarTypes::CAR,
        'Pickup Truck' => CarTypes::PICKUP,
        'Truck' => CarTypes::TRUCK,
        'Semi Truck' => CarTypes::SEMI,
        'SUV' => CarTypes::SUV,
        'Van' => CarTypes::VAN
    );

    public const CAR = "Car";
    public const PICKUP = "Pickup Truck";
    public const TRUCK = "Truck";
    public const SEMI = "Semi-Truck";
    public const SUV = "SUV";
    public const VAN = "Van";
}