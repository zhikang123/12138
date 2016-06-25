<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/6/24
 * Time: 20:04
 */
namespace log4l;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Log {

  public static function __callStatic($method,$parameters){
    $dateFormat = config('log4l.dateFormat', 'Y-m-d H:i:s');
    $outputFormat = config('log4l.outputFormat', "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n");

    $logger = new Logger("log4j");
    $formatter = new LineFormatter($outputFormat, $dateFormat, false, false);
    $stream = new StreamHandler(config("log4l.file",storage_path() . '/logs/laravel.log'));
    $stream->setFormatter($formatter);
    $logger->pushHandler($stream);
    return call_user_func_array([$logger,$method],$parameters);
  }
}