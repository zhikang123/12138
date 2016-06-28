<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/6/24
 * Time: 20:04
 */
namespace Log4l;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Log {
  private static $logs = [];
  private $writer;
  private $location;

  public function __construct($location='')
  {
    $this->location = $location;
  }

  public static function __conn($name = "default",$location=''){
    if(!in_array($name,self::$logs)){
      $log = new Log($location);
      $log->writer = new Writer();
      //    $config = $log->getConfig($name=='default'?config("log4l.default","default"):$name);
      $config = $log->getConfig($name=='default'?"default":$name);
      $method = "use".ucfirst(strtolower($config['mode']))."Files";
      $log->writer->{$method}($config['logpath'],$config['level'],$config['formatter']);
      self::$logs[$name] = $log;
    }
    return self::$logs[$name];
  }

  private function getConfig($name){
    //    $dateFormat = config("log4l.$name.dateFormat",config('log4l.dateFormat',null));
    //    $outputFormat = config("log4l.$name.outputFormat",config('log4l.outputFormat',null));
    //    $level = config("log4l.$name.level",config('log4l.level','debug'));
    //    $mode = config("log4l.$name.mode",config('log4l.mode','single'));
    //    $logpath = config("log4l.$name.logpath",config('log4l.logpath',storage_path()."/logs/laravel.log"));

    $dateFormat = config('log4l.dateFormat');
    $outputFormat = config('log4l.outputFormat');
    $level = config("log4l.$name.level",'debug');
    $mode = config("log4l.$name.mode",'single');
    $logpath = config("log4l.$name.logpath",storage_path()."/logs/laravel.log");


    return [
        'formatter' => new LineFormatter($outputFormat, $dateFormat, false, false),
        'level'     => $level,
        'mode'      => $mode,
        'logpath'   => $logpath
    ];
  }

  public function __call($method,$parameters){
    $parameters[0]=($this->location).$parameters[0];
    return call_user_func_array([$this->writer, $method], $parameters);
  }

  public static function __callStatic($method,$parameters){
    $location = debug_backtrace()[2]['class'].':'.debug_backtrace()[1]['line'].':';
    if($method==='conn'){
      return Log::__conn($parameters[0],$location);
    }else{
      return call_user_func_array([Log::__conn('default',$location), $method], $parameters);
    }

  }
}
