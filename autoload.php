<?php
/**
 * @description 自动加载类
 * 
 * @author Jason <shuaijinchao@gmail.com>
 * 
 * @create 2015-11-29 15:23
 */

class autoload {

    public static function load($fileName)
    {
        $filePath = sprintf('%s.php', str_replace('\\', '/', $fileName));
        if (is_file($filePath)) require_once $filePath;
    }

}

spl_autoload_register(['autoload', 'load']);