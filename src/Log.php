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

  private static $logs = [];
  private $writer;

  public static function instance($name = "default"){
    if(!in_array($name,self::$logs)){
      $log = new Log();
      $log->writer = new Writer();
      $formatter = new LineFormatter(null, null, true, true);
      $logpath = storage_path() . '/logs/laravel.log';
      $mode = "single";
      $level = "debug";
      if($name != 'default'){
        $dateFormat = config('log4l.'.$name.'.dateFormat');
        $outputFormat = config('log4l.'.$name.'.outputFormat');
        $formatter = new LineFormatter($outputFormat, $dateFormat, false, false);
        $logpath = config('log4l.'.$name.'.logpath');
        $mode = config('log4l.'.$name.'.mode');
        $level = config('log4l.'.$name.'.level');
      }
      $method = "use".ucfirst(strtolower($mode))."Files";
      $log->{$method}($logpath,$level,$formatter);
    }
    return self::$logs[$name];
  }

//  public function config($config = null){
//    $log = self::instance($config);
//    if($config != null){
//      $log->dateFormat = config("log4l.{$config}.dateFormat");
//      $log->outputFormat = config("log4l.{$config}.outputFormat");
//      $log->$logpath = config("log4l.{$config}.file");
//      $log->writer = new Writer();
//      $log->writer->useDailyFiles(config("log4l.{$config}.file"),5,'debug',)
//    }
//    return $log;
//  }

  public function __call($method,$parameters){
    return call_user_func_array([$this->writer, $method], $parameters);
  }

  public static function __callStatic($method,$parameters){
    return call_user_func_array([new static, $method], $parameters);
  }
}