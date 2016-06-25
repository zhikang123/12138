<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/6/25
 * Time: 10:41
 */

namespace log4l;


use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use InvalidArgumentException;

class Writer {

  private $monolog;

  private $levels = [
    'debug'     => Logger::DEBUG,
    'info'      => Logger::INFO,
    'notice'    => Logger::NOTICE,
    'warning'   => Logger::WARNING,
    'error'     => Logger::ERROR,
    'critical'  => Logger::CRITICAL,
    'alert'     => Logger::ALERT,
    'emergency' => Logger::EMERGENCY,
  ];

  public function __construct($name = "log4l")
  {
    $this->monolog = new Logger($name);
  }

  public function debug($message, array $context = []){
    return $this->writeLog(__FUNCTION__,$message,$context);
  }

  public function info($message, array $context = []){
    return $this->writeLog(__FUNCTION__,$message,$context);
  }

  public function notice($message, array $context = []){
    return $this->writeLog(__FUNCTION__,$message,$context);
  }

  public function warning($message, array $context = []){
    return $this->writeLog(__FUNCTION__,$message,$context);
  }

  public function critical($message, array $context = []){
    return $this->writeLog(__FUNCTION__,$message,$context);
  }

  public function alert($message, array $context = []){
    return $this->writeLog(__FUNCTION__,$message,$context);
  }

  public function emergency($message, array $context = []){
    return $this->writeLog(__FUNCTION__,$message,$context);
  }

  public function writeLog($level, $message, $context){
    return $this->monolog->{$level}($message,$context);
  }

  public function useSingleFiles($path, $level = 'debug',$formatter = null){
    $this->monolog->pushHandler($handler = new StreamHandler($path, $this->parseLevel($level)));

    $handler->setFormatter($formatter ? $formatter : $this->getDefaultFormatter());
  }

  public function useDailyFiles($path, $days = 0, $level = 'debug',$formatter = null){
    $this->monolog->pushHandler(
      $handler = new RotatingFileHandler($path, $days, $this->parseLevel($level))
    );

    $handler->setFormatter($formatter ? $formatter : $this->getDefaultFormatter());
  }

  private function getDefaultFormatter(){
    return new LineFormatter(null, null, true, true);
  }

  private function parseLevel($level){
    if(in_array($level,$this->levels)) return $level;
    throw new InvalidArgumentException('无效的日志级别');
  }
}