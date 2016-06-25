# 操作步骤
## 1.在要调用的项目的`composer.json`中增加:
### 1.1 require标签增加
```php
kxutils/log4l

### 1.2 增加repositories标签(如果没有),并增加
```php
"repositories":[
{
    "type":"vcs",
    "url":"git@git.7color.net.cn:lib/log4l.git"
}
]

### 1.3 更新
```sh
composer install

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
