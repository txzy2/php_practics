<?php

interface VehicleInterface
{
    public function start(): void;

    public function stop(): void;

    public function refuel(float $amount, string $fuelType, int $terminal, array $fuelPrice, int $fee): void;
}

abstract class Vehicle implements VehicleInterface
{
    protected string $name;
    protected float $fuelLevel;
    protected int $maxFuelCapacity;
    protected bool $isRunning = true;
    protected string $type;

    public function __construct(float $fuelLevel, int $maxFuelCapacity, string $name)
    {
        if ($fuelLevel <= 0 or $maxFuelCapacity <= 0) {
            throw new InvalidArgumentException("Params must be positive");
        }

        $this->name = $name;
        $this->fuelLevel = $fuelLevel;
        $this->maxFuelCapacity = $maxFuelCapacity;
    }

    public function refuel(float $amount, string $fuelType, int $terminal, array $fuelPrice, int $fee): void
    {
        if (!array_key_exists($fuelType, $fuelPrice)) {
            echo "❌ Invalid fuel type.\n";
        }

        echo $this->stop() . "\nTERMINAL $terminal" . " -> Vehicle type: $this->type -> Fuel level: $this->fuelLevel\n";

        $neededFuel = min($amount, $this->maxFuelCapacity - $this->fuelLevel);
        $this->fuelLevel += $neededFuel;
        $tank_level = round($this->fuelLevel / $this->maxFuelCapacity * 100);

        $fee_proc = $neededFuel * $fuelPrice[$fuelType] * ($fee / 100);
        $cheque = (object)[
            'terminal' => $terminal,
            'carType' => $this->type,
            'totalLiters' => $neededFuel,
            'fuelType' => $fuelType,
            'byLiter' => $fuelPrice[$fuelType],
            'cost' => round($neededFuel * $fuelPrice[$fuelType] + $fee_proc, 1),
            'fee' => round($fee_proc, 2),
            'tank_level' => $this->fuelLevel == $this->maxFuelCapacity ? 'full' : "$tank_level%"
        ];
        $res = json_encode($cheque);

        echo "⛽ Cheque: $res\n";
        echo $this->start() . " from terminal $terminal\nIncome: $cheque->cost rub\nFuel consumed: $cheque->totalLiters \n\n";
    }

    public function stop(): void
    {
        if ($this->isRunning) {
            $this->isRunning = false;
            echo "🚗 Vehicle $this->name started to refuel";
        } else {
            echo "⚠️ Vehicle is already stopped\n";
        }
    }

    public function start(): void
    {
        if ($this->fuelLevel > 0.5) {
            $this->isRunning = true;
            echo "✔️ Vehicle $this->name leave";
        } else {
            echo "❌ Cannot start vehicle. Fuel is too low.\n";
        }
    }
}
