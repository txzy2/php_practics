<?php

class Gen
{
    protected $length;
    protected $multiplicity;

    private $password = '';

    protected $regdx = '/^(?=\S{8,25})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/';
    protected $regdx_eazy = '/^[a-zA-Z0-9]{8,25}$/';
    protected $regdx_medium = '/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{8,25}$/';
    protected $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*_+-=';

    public function __construct($params)
    {
        $this->length = $params['length'] ?? 8;
        $this->multiplicity = $params['multiplicity'] ?? 'medium';
    }

    private function pass()
    {
        $this->password = '';
        for ($i = 0; $i < $this->length; $i++) {
            $this->password .= $this->characters[mt_rand(0, strlen($this->characters) - 1)];
        }
    }

    private function gen()
    {
        $multiplicity = $this->multiplicity === 'easy'
            ? $this->regdx_eazy
            : (
                $this->multiplicity === 'medium'
                ? $this->regdx_medium
                : $this->regdx
            );

        do {
            $this->pass();
        } while (!preg_match($multiplicity, $this->password));
    }

    public function getResult()
    {
        $this->gen();
        return $this->password;
    }
}

$params = [
    'length' => 12,
    'multiplicity' => 'strong'
];

if (empty($params['length']) || $params['length'] < 8) {
    echo 'length is null or less than 8';
    return;
}

if ($params['multiplicity'] === 'strong' && $params['length'] < 12) {
    echo 'lenght must be more them 12';
}

$gen = new Gen($params);
echo $gen->getResult();
