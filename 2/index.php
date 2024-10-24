<?php

class Gen
{
    protected $length;
    protected $multiplicity;
    protected $password = '';
    protected $regdx = '/^(?=\S{8,25})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/';
    protected $regdx_easy = '/^[a-zA-Z0-9]{8,25}$/';
    protected $regdx_medium = '/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{8,25}$/';
    protected $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*_+-=';

    public function __construct($params)
    {
        $this->length = $params['length'] ?? null;
        $this->multiplicity = $params['multiplicity'] ?? 'medium';

        if ($this->multiplicity === 'strong' && $this->length < 12) {
            throw new Exception('Length for strong passwords must be at least 12 characters.');
        }

        if ($this->length < 8) {
            throw new Exception('Length must be at least 8 characters.');
        }
    }

    private function generatePassword()
    {
        $this->password = '';
        for ($i = 0; $i < $this->length; $i++) {
            $this->password .= $this->characters[mt_rand(0, strlen($this->characters) - 1)];
        }
    }

    private function generateAndValidate()
    {
        $multiplicity = $this->multiplicity === 'easy'
            ? $this->regdx_easy
            : ($this->multiplicity === 'medium' ? $this->regdx_medium : $this->regdx);

        do {
            $this->generatePassword();
        } while (!preg_match($multiplicity, $this->password));
    }

    public function getResult()
    {
        $this->generateAndValidate();
        return $this->password;
    }
}

$params = [
    'length' => 12,
    'multiplicity' => 'strong'
];

try {
    $gen = new Gen($params);
    echo $gen->getResult();
} catch (Exception $e) {
    echo $e->getMessage();
}
