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
      $config = $log->getConfig($name=='default'?null:$name);
      $method = "use".ucfirst(strtolower($config['mode']))."Files";
      $log->{$method}($config['logpath'],$config['level'],$config['formatter']);
    }
    return self::$logs[$name];
  }

  private function getConfig($name = null){
    if($name != null){
      $dateFormat = config('log4l.'.$name.'.dateFormat');
      $outputFormat = config('log4l.'.$name.'.outputFormat');
      $formatter = new LineFormatter($outputFormat, $dateFormat, false, false);
      return [
        'formatter' => $formatter,
        'level' => config('log4l.'.$name.'.level'),
        'mode'  => config('log4l.'.$name.'.mode'),
        'logpath' => config('log4l.'.$name.'.logpath')
      ];
    }
    return [
      'formatter' => new LineFormatter(null, null, true, true),
      'level'     => 'debug',
      'mode'      => 'single'
    ];
  }

  public function __call($method,$parameters){
    return call_user_func_array([$this->writer, $method], $parameters);
  }

  public static function __callStatic($method,$parameters){
    return call_user_func_array([Log::instance(), $method], $parameters);
  }
}