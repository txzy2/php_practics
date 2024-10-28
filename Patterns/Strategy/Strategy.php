<?php

interface CommissionStrategy {
    public function calculate(float $amount): float;
}

class CarCommission implements CommissionStrategy {
    public function calculate(float $amount): float {
        Log::getInstance()->info("fee for cars: 0.03");
        return $amount * 0.03;
    }
}

class TruckCommission implements CommissionStrategy {
    public function calculate(float $amount): float {
        Log::getInstance()->info("fee for trucks: 0.04");
        return $amount * 0.04;
    }
}

class MotoCommission implements CommissionStrategy {
    public function calculate(float $amount): float {
        Log::getInstance()->info("fee for moto: 0.05");
        return $amount * 0.05;
    }
}


class RefuelService {
    private CommissionStrategy $commissionStrategy;
    private float $finalIncome  = 0;

    public function __construct(CommissionStrategy $commissionStrategy) {
        $this->commissionStrategy = $commissionStrategy;
    }

    public function cost_fee_calculate(float $amount): float {
        return $amount + $this->commissionStrategy->calculate($amount);
    }

    public function calculate_final_income(float $amount): void {
        $this->finalIncome += $amount;
    }

    public function get_final_income(): float {
        return $this->finalIncome;
    }
}