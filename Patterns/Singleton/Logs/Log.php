<?php

class Log {
    private static ?Log $instance  = null;
    private $file;

    private function __construct()
    {
        $this->file = fopen(__DIR__ . '/base.log', 'a+');
    }

    public static function getInstance(): Log {
        if (self::$instance === null) {
            self::$instance = new Log();
        }
        return self::$instance;
    }

    public function setLog(string $log): void
    {
        if (empty($log)) {
            echo "Empty log message! \n";
            return;
        }

        $date = date("Y-m-d H:i:s");
        fwrite($this->file, "[$date] $log" . PHP_EOL);
    }

    public function getLog(): void
    {
        fseek($this->file, 0);
        $fileSize = filesize('/base.log');

        if ($fileSize > 0) {
            echo fread($this->file, $fileSize);
        } else {
            echo "Log file is empty.\n";
        }
    }

    public function __destruct()
    {
        fclose($this->file);
    }
}
