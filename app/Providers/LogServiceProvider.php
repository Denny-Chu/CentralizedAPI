<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Level;

class LogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton('Psr\Log\LoggerInterface', function ($app) {
            $logFile = storage_path('logs/lumen.log');
            $logLevel = $this->getLogLevel();

            // 確保日誌目錄存在
            $logDir = dirname($logFile);
            if (!file_exists($logDir)) {
                mkdir($logDir, 0775, true);
            }

            // 如果日誌文件不存在，創建它並設置權限
            if (!file_exists($logFile)) {
                touch($logFile);
                chmod($logFile, 0664);
            }

            $logger = new Logger('lumen');
            $handler = new StreamHandler($logFile, $logLevel);
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