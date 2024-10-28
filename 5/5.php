<?php

include 'Vehicle.php';

class Car extends Vehicle
{
    /**
     * Summary of __construct
     * @param float $fuelLevel
     * @param int $maxFuelCapacity
     * @param string $name
     */
    public function __construct(float $fuelLevel, int $maxFuelCapacity, string $name)
    {
        parent::__construct($fuelLevel, $maxFuelCapacity, $name);
        $this->type = 'car';
    }
}

class Truck extends Vehicle
{
    /**
     * Summary of __construct
     * @param float $fuelLevel
     * @param int $maxFuelCapacity
     * @param mixed $name
     */
    public function __construct(float $fuelLevel, int $maxFuelCapacity, $name)
    {
        parent::__construct($fuelLevel, $maxFuelCapacity, $name);
        $this->type = 'truck';
    }
}

class GazStation
{
    protected array $fuelPrices;
    protected float $fee;
    protected array $vehicles = [];
    protected array $terminals = [];

    /**
     * Summary of __construct
     * @param int $totalTerminals
     * @param array $fuelPrices
     * @param float $fee
     */
    public function __construct(int $totalTerminals,array $fuelPrices, float $fee )
    {
        $this->terminals = array_fill(1, $totalTerminals, true);
        $this->fuelPrices = $fuelPrices;
        $this->fee = $fee;
    }
    /**
     * Summary of addVehicle
     * @param Vehicle $vehicle
     * @return void
     */
    public function addVehicle(Vehicle $vehicle): void
    {
        $this->vehicles[] = $vehicle;
    }

    /**
     * Summary of refuelVehicleById
     * @param int $vehicleId
     * @param float $amount
     * @param string $fuelType
     * @param int $requestedTerminal
     * @return void
     */
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
            $this->vehicles[$vehicleId]->refuel($amount, $fuelType, $requestedTerminal, $this->fuelPrices, $this->fee);
        } finally {
            $this->terminals[$requestedTerminal] = true;
        }
    }
}

const FUEL_PRICES = [
    '92' => 53.67,
    '95' => 58.95,
    '100' => 79.51,
    'diesel' => 66.87,
];
const FEE = 3;
$gaz_station = new GazStation(6, FUEL_PRICES, FEE);

$car1 = new Car(40, 50, 'Lada');
$car2 = new Car(20, 45, 'Nissan');
$car3 = new Car(20, 80, 'Volvo');

$truck = new Truck(5, 250, 'Man');
$truck2 = new Truck(60, 200, 'Kamaz');

$gaz_station->addVehicle($car1);
$gaz_station->addVehicle($car2);
$gaz_station->addVehicle($car3);

$gaz_station->addVehicle($truck);
$gaz_station->addVehicle($truck2);

echo "<-- Fuel Prices -->\n";
$index = 1;
foreach (FUEL_PRICES as $fuelType => $price) {
    echo $index . ") " . $fuelType . ": " . $price . " rub\n";
    $index++;
}
echo "\nFee info: " . FEE . "%\n\n";

$gaz_station->refuelVehicleById(3, 300, 'diesel', 1);
$gaz_station->refuelVehicleById(0, 14, '95', 2);
$gaz_station->refuelVehicleById(2, 22, '92', 3);
$gaz_station->refuelVehicleById(1, 15, '100', 4);
$gaz_station->refuelVehicleById(4, 120, 'diesel', 5);
