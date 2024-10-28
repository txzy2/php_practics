<?php

include 'Vehicle.php';

class Car extends Vehicle
{
    public function __construct(float $fuelLevel, int $maxFuelCapacity)
    {
        parent::__construct($fuelLevel, $maxFuelCapacity, new CarCommission());
        $this->type = 'car';

        Log::getInstance()->info("Vehicle add car, Fuel level: $fuelLevel, Max fuel level: $maxFuelCapacity");
    }
}

class Truck extends Vehicle
{
    public function __construct(float $fuelLevel, int $maxFuelCapacity)
    {
        parent::__construct($fuelLevel, $maxFuelCapacity, new TruckCommission());
        $this->type = 'truck';
        Log::getInstance()->info("Vehicle add truck, Fuel level: $fuelLevel, Max fuel level: $maxFuelCapacity");
    }
}

class Motorcycle extends Vehicle
{
    public function __construct(float $fuelLevel, int $maxFuelCapacity)
    {
        parent::__construct($fuelLevel, $maxFuelCapacity, new MotoCommission());
        $this->type = 'moto';
        Log::getInstance()->info("Vehicle add moto, Fuel level: $fuelLevel, Max fuel level: $maxFuelCapacity");
    }
}

class GazStation
{
    protected const FUEL_PRICES = [
        '92' => 53.67,
        '95' => 58.95,
        '100' => 79.51,
        'diesel' => 66.87,
    ];
    protected array $vehicles = [];
    protected array $terminals = [];
    protected $final=0;

    public function __construct(int $totalTerminals)
    {
        $this->terminals = array_fill(1, $totalTerminals, true);
    }

    /**
     * Добавление нового транспортного средства
     * @param Vehicle $vehicle
     * @return void
     */
    public function addVehicle(Vehicle $vehicle): void
    {
        $this->vehicles[] = $vehicle;
    }

    /**
     * Заправка транспортного средства
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
            $this->vehicles[$vehicleId]->refuel($amount, $fuelType, $requestedTerminal, self::FUEL_PRICES);

            $this->final += $this->vehicles[$vehicleId]->getRefuelService()->get_final_income();

        } finally {
            $this->terminals[$requestedTerminal] = true;
        }
    }

    /**
     * Получение финального дохода
     * @return float|int
     */
    public function getFinalIncome() {
        return $this->final;
    }
}