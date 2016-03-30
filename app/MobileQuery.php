<?php namespace app;
/**
 * @description 手机归属地查询模块
 * 
 * @author Jason <shuaijinchao@gmail.com>
 * 
 * @create 2015-11-29 15:26
 */

use libs\HttpRequest;
use libs\ImRedis;

class MobileQuery
{

    const PHONE_API = 'https://tcc.taobao.com/cc/json/mobile_tel_segment.htm';

    const QUERY_PHONE = 'PHONE:INFO:';

    public static function formatData($data)
    {
        $ret = null;
        if (!empty($data)) {
            preg_match_all("/(\w+):'([^']+)/", $data, $res);
            $items = array_combine($res[1], $res[2]);
            foreach ($items as $itemKey => $itemVal) {
                $ret[$itemKey] = iconv('GB2312', 'UTF-8', $itemVal);
            }
        }
        return $ret;
    }

    public static function query($phone)
    {
        $phoneData = null;
        if (self::verifyPhone($phone)) {
            $redisKey = sprintf(self::QUERY_PHONE . '%s', substr($phone, 0, 7));
            $phoneInfo = ImRedis::getRedis()->get($redisKey);
            if (!$phoneInfo) {
                $response = HttpRequest::request(self::PHONE_API, ['tel' => $phone]);
                $phoneData = self::formatData($response);
                if ($phoneData) {
                    ImRedis::getRedis()->set($redisKey, json_encode($phoneData));
                }
                $phoneData['msg'] = '数据由阿里巴巴提供';
            } else {
                $phoneData = json_decode($phoneInfo, true);
                $phoneData['msg'] = '数据由IMOOC提供';
            }
        }
        return $phoneData;
    }

    public static function verifyPhone($phone)
    {
        if (preg_match("/^1[34578]{1}\d{9}/", $phone)) {
            return true;
        } else {
            return false;
        }
    }
}