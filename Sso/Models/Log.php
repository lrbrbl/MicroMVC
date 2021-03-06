<?php
/**
 * 日志类
 *
 * @author zhiyuan <zhiyuan12@staff.weibo.com>
 */
namespace Sso\Models;
use \Framework\Libraries\SingletonManager;

class Log {
    const LOGIN_COUNT_INDEX     = 0;
    const SQL_LOG_INDEX         = 1;
    private static $_LOG_FORMAT = array(
        self::LOGIN_COUNT_INDEX => "{type}\t{name}",
        self::SQL_LOG_INDEX     => "{sql}\t{params}"
    );
    public static function SqlLog(string $sql, array $params = array()) {
        self::writeLog(self::SQL_LOG_INDEX, array('sql' => $sql, 'params' => json_encode($params)), 'sql_log', 'sql_log');
    }
    public static function LoginUser(string $name, string $type = 'web') {
        self::writeLog(self::LOGIN_COUNT_INDEX, array('name' => $name, 'type' => $type), 'login_log','login_log');
    }
    public static function writeLog(int $index, array $params, string $msg_name, string $config_name = 'login_log') {
        $logger = SingletonManager::$SINGLETON_POOL->getInstance('\Framework\Libraries\Logger', $config_name, 'Sso');
        $logger->info(self::$_LOG_FORMAT[$index], $params, $msg_name);
    }
}