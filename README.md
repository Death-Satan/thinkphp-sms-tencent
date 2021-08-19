# thinkphp6 腾讯云 sms 驱动
## 修改配置文件 `config/sms.php`

---
```php
return [
    'default'=>env('sms.default','aliyun'),
    'drives'=>[
        'tencent'=>[
            'type'=>'Tencent',
            'region'=>null,//地域
            'secretId'=>null,//
            'secretKey'=>null,//
            'endpoint'=>null,//
        ]
    ]
];
 ```
---