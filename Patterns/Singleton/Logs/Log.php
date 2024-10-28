<?php
date_default_timezone_set('Europe/Moscow');

class Log
{
    private static ?Log $instance = null;
    private $file;
    private string $filePath;

    private function __construct()
    {
        $this->filePath = __DIR__ . '/logs/' . date('Y-m-d') . '.log';
        if (!file_exists(__DIR__ . '/logs')) {
            mkdir(__DIR__ . '/logs', 0777, true);
        }
        $this->file = fopen($this->filePath, 'a+');
    }

    /**
     * Главный метод для получения экземпляра
     * @return Log
     */
    public static function getInstance(): Log
    {
        if (self::$instance === null) {
            self::$instance = new Log();
        }
        return self::$instance;
    }

    /**
     * Запись в лог
     * @param string $log
     * @param string $level
     * @return void
     */
    private function setLog(string $log, string $level = 'INFO'): void
    {
        if (empty($log)) {
            echo "Empty log message! \n";
            return;
        }

        $date = date("Y-m-d H:i:s");
        $formattedLog = sprintf("[%s] [%s] %s%s", $date, strtoupper($level), $log, PHP_EOL);
        fwrite($this->file, $formattedLog);
    }

    /**
     * Запись в лог информации
     * @param string $message
     * @return void
     */
    public function info(string $message): void
    {
        $this->setLog($message, 'INFO');
    }

    /**
     * Запись в лог ошибки
     * @param string $message
     * @return void
     */
    public function error(string $message): void
    {
        $this->setLog($message, 'ERROR');
    }

    public function getFileLogs() {
        return $this->filePath;
    }

    public function __destruct()
    {
        fclose($this->file);
    }
}
