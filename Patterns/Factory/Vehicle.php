<?php

interface VehicleInterface
{
    public function start(int $terminal): string;

    public function stop(): string;

    public function refuel(float $amount, string $fuelType, int $terminal, array $fuelPrice): void;
}

abstract class Vehicle implements VehicleInterface
{
    protected float $fuelLevel;
    protected int $maxFuelCapacity;
    protected bool $isRunning = true; 
    protected string $type;

    protected RefuelService $refuelService;

    public function __construct(float $fuelLevel, int $maxFuelCapacity, CommissionStrategy $commissionStrategy)
    {
        if ($fuelLevel < 0 || $maxFuelCapacity <= 0) {
            throw new InvalidArgumentException("Parameters must be positive");
        }

        $this->fuelLevel = $fuelLevel;
        $this->maxFuelCapacity = $maxFuelCapacity;
        $this->refuelService = new RefuelService($commissionStrategy);
    }

    /**
     * Симуляция заправки
     * @param float $amount
     * @param string $fuelType
     * @param int $terminal
     * @param array $fuelPrice
     * @return void
     */
    public function refuel(float $amount, string $fuelType, int $terminal, array $fuelPrice): void
    {
        if (!array_key_exists($fuelType, $fuelPrice)) {
            echo "❌ Invalid fuel type.\n";
            return; 
        }

        $stopped = $this->stop();
        Log::getInstance()->info("$stopped \nTERMINAL $terminal" . " -> Vehicle type: $this->type -> Fuel level: $this->fuelLevel");

        // Подсчет заправки
        $neededFuel = min($amount, $this->maxFuelCapacity - $this->fuelLevel);
        $this->fuelLevel += $neededFuel;
        $tankLevel = round($this->fuelLevel / $this->maxFuelCapacity * 100);

        // Стоимость заправки
        $cost = $this->refuelService->cost_fee_calculate($neededFuel * $fuelPrice[$fuelType]);
        $this->refuelService->calculate_final_income($cost);

        // Чек
        $cheque = (object)[
            'terminal' => $terminal,
            'carType' => $this->type,
            'totalLiters' => $neededFuel,
            'fuelType' => $fuelType,
            'byLiter' => $fuelPrice[$fuelType],
            'cost' => round($cost, 2),
            'tank_level' => $this->fuelLevel == $this->maxFuelCapacity ? 'full' : "$tankLevel%"
        ];

        // Вывод чека
        $res = json_encode($cheque, JSON_PRETTY_PRINT);
        Log::getInstance()->info("\n⛽ Cheque: $res");

        // Запуск заправки
        $started = $this->start($terminal);
        Log::getInstance()->info(
            "\n/ =======================================\n"
            . "$started from terminal $terminal\nIncome: $cheque->cost rub\nFuel consumed: $cheque->totalLiters\n"
            . "/ =======================================\n"
        );
    }

    /**
     * Симуляция остановки двигателя 
     * @return string
     */
    public function stop(): string
    {
        if ($this->isRunning) {
            $this->isRunning = false;
            return "🚗 Vehicle stopped";
        } else {
            return "⚠️ Vehicle is already stopped";
        }
    }

    /**
     * Симуляция заправки и запуска двигателя
     * @param int $terminal
     * @return string
     */
    public function start(int $terminal): string
    {
        $this->isRunning = true;
        echo "Starting refuel -> $this->type on TERMINAL $terminal...";
        usleep(1500000);
        echo "✔️ DONE<br />";
        
        return "✔️ Vehicle leave";
    }

    /**
     * Get the value of refuelService
     * @return RefuelService
     */
    public function getRefuelService(): RefuelService
    {
        return $this->refuelService;
    }
}
