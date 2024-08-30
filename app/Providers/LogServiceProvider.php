<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Level;

class LogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton('Psr\Log\LoggerInterface', function ($app) {
            $logDir = storage_path('logs');
            $filename = 'lumen.log';
            $logFile = $logDir . '/' . $filename;
            $logLevel = $this->getLogLevel();

            // 確保日誌目錄存在
            if (!file_exists($logDir)) {
                mkdir($logDir, 0775, true);
            }

            $logger = new Logger('lumen');
            $handler = new RotatingFileHandler($logFile, 0, $logLevel, true, 0664);
            $logger->pushHandler($handler);

            return $logger;
        });
    }

    protected function getLogLevel()
    {
        $logLevel = env('LOG_LEVEL', 'debug');
        return match (strtolower($logLevel)) {
            'debug' => Level::Debug,
            'info' => Level::Info,
            'notice' => Level::Notice,
            'warning' => Level::Warning,
            'error' => Level::Error,
            'critical' => Level::Critical,
            'alert' => Level::Alert,
            'emergency' => Level::Emergency,
            default => Level::Debug,
        };
    }

    public function register()
    {
    }
}