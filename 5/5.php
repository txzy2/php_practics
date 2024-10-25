<?php

include 'Vehicle.php';

class Car extends Vehicle
{
    public function __construct(float $fuelLevel, int $maxFuelCapacity)
    {
        parent::__construct($fuelLevel, $maxFuelCapacity);
        $this->type = 'car';
    }
}

class Truck extends Vehicle
{
    public function __construct(float $fuelLevel, int $maxFuelCapacity)
    {
        parent::__construct($fuelLevel, $maxFuelCapacity);
        $this->type = 'truck';
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

    public function getFuelPrice(): array
    {
        return self::FUEL_PRICES;
    }

    public function getFeePercentage(): float
    {
        return self::FEE;
    }
}

$gaz_station = new GazStation(6);

$car1 = new Car(40, 50);
$car2 = new Car(20, 45);
$car3 = new Car(20, 80);

$truck = new Truck(5, 250);
$truck2 = new Truck(60, 200);

$gaz_station->addVehicle($car1);
$gaz_station->addVehicle($car2);
$gaz_station->addVehicle($car3);

$gaz_station->addVehicle($truck);
$gaz_station->addVehicle($truck2);

echo "<-- Prices -->\n";
$index = 1;
foreach ($gaz_station->getFuelPrice() as $fuelType => $price) {
    echo $index . ") " . $fuelType . ": " . $price . " rub\n";
    $index++;
}
echo "\nFee info: " . $gaz_station->getFeePercentage() . "%\n\n";

$gaz_station->refuelVehicleById(3, 300, 'diesel', 1);
$gaz_station->refuelVehicleById(0, 14, '95', 2);
$gaz_station->refuelVehicleById(2, 22, '92', 3);
$gaz_station->refuelVehicleById(1, 15, '100', 4);
$gaz_station->refuelVehicleById(4, 120, 'diesel', 5);
