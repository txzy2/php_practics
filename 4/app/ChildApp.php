<?php

class ChildApp extends App
{
    /**
     * Summary of sum
     * @return string
     */
    protected function sum(): string
    {
        $params = $this->check();

        if ($params === 'Ok') {
            return (string)($this->f + $this->b + 10);
        }

        return $params;
    }

    /**
     * Summary of getMath
     * @return string
     */
    public function getMath(): string
    {
        return $this->sum();
    }
}
