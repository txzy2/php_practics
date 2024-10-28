<?php

include 'Vehicle.php';

class Car extends Vehicle
{
    public function __construct(float $fuelLevel, int $maxFuelCapacity)
    {
        parent::__construct($fuelLevel, $maxFuelCapacity);
        $this->type = 'car';

        Log::getInstance()->setLog("Vehicle add car, Fuel level: $fuelLevel, Max fuel level: $maxFuelCapacity");
    }
}

class Truck extends Vehicle
{
    public function __construct(float $fuelLevel, int $maxFuelCapacity)
    {
        parent::__construct($fuelLevel, $maxFuelCapacity);
        $this->type = 'truck';
        Log::getInstance()->setLog("Vehicle add truck, Fuel level: $fuelLevel, Max fuel level: $maxFuelCapacity");
    }
}

class Motorcycle extends Vehicle
{
    public function __construct(float $fuelLevel, int $maxFuelCapacity)
    {
        parent::__construct($fuelLevel, $maxFuelCapacity);
        $this->type = 'moto';
        Log::getInstance()->setLog("Vehicle add moto, Fuel level: $fuelLevel, Max fuel level: $maxFuelCapacity");
    }
}

class GazStation
{
    protected const array FUEL_PRICES = [
        '92' => 53.67,
        '95' => 58.95,
        '100' => 79.51,
        'diesel' => 66.87,
    ];
    protected const float FEE = 3;
    protected array $vehicles = [];
    protected array $terminals = [];

    public function __construct(int $totalTerminals)
    {
        $this->terminals = array_fill(1, $totalTerminals, true);
    }

    public function addVehicle(Vehicle $vehicle): void
    {
        $this->vehicles[] = $vehicle;
    }

    public function refuelVehicleById(int $vehicleId, float $amount, string $fuelType, int $requestedTerminal): void
    {
        if (!isset($this->vehicles[$vehicleId])) {
            echo "❌ Vehicle with ID $vehicleId not found.\n";
            return;
        }

        if (!$this->terminals[$requestedTerminal]) {
            echo "❌ Terminal $requestedTerminal is currently occupied.\n";
            return;
        }

        try {
            $this->terminals[$requestedTerminal] = false;
            $this->vehicles[$vehicleId]->refuel($amount, $fuelType, $requestedTerminal, self::FUEL_PRICES, self::FEE);
        } finally {
            $this->terminals[$requestedTerminal] = true;
        }
    }
}