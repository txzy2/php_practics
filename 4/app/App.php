<?php

class App
{
    protected int $f;
    protected int $b;

    public function __construct(int $f = null, int $b = null)
    {
        $this->f = $f;
        $this->b = $b;
    }

    /**
     * Summary of check
     * @return string
     */
    protected function check(): string
    {
        if (!is_numeric($this->f) || !is_numeric($this->b)) {
            return 'EMPTY OR NOT VALID PARAMS';
        }

        return 'Ok';
    }

    protected function sum(): string
    {
        $params = $this->check();

        if ($params === 'Ok') {
            return (string)($this->f + $this->b);
        }

        return $params;
    }

    /**
     * Summary of odds
     * @return string
     */
    protected function odds(): string
    {
        $params = $this->check();

        if ($params === 'Ok') {
            return (string)($this->f - $this->b);
        }

        return $params;
    }

    /**
     * Summary of getMath
     * @return string[]
     */
    public function getMath()
    {
        return [
          'sum' => $this->sum(),
          'odds' => $this->odds(),
          ];
    }

}
