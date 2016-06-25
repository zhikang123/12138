# 操作步骤
拷贝`log4l.php.example`文件到`app/config`中,并把文件改名为`log4l.php`


# 使用方法
```php
use Log4l\Log;
Log::info($msg);
Log::error($msg);

//其他能用方法有:
'debug'     => Logger::DEBUG,
'info'      => Logger::INFO,
'notice'    => Logger::NOTICE,
'warning'   => Logger::WARNING,
'error'     => Logger::ERROR,
'critical'  => Logger::CRITICAL,
'alert'     => Logger::ALERT,
'emergency' => Logger::EMERGENCY,
