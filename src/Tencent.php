<?php
/**
 * @author    : Death-Satan
 * @date      : 2021/8/20
 * @createTime: 0:31
 * @company   : Death撒旦
 * @link      https://www.cnblogs.com/death-satan
 */

/**
 * 腾讯云 sms代理类
 * Class Tencent
 */
class Tencent extends \SaTan\Think\Sms\Driver
{
    protected function createSms (): \Satan\Think\Sms\interfaces\SmsInterface
    {
        return new TencentInterFaces($this->config);
    }
}