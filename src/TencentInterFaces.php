<?php

use TencentCloud\Common\Credential;
use TencentCloud\Sms\V20210111\Models\ModifySmsSignRequest;
use TencentCloud\Sms\V20210111\Models\DescribeSmsSignListRequest;
use TencentCloud\Sms\V20210111\Models\AddSmsTemplateRequest;
use TencentCloud\Sms\V20210111\Models\DeleteSmsTemplateRequest;
use TencentCloud\Sms\V20210111\Models\ModifySmsTemplateRequest;
use TencentCloud\Sms\V20210111\Models\DescribeSmsTemplateListRequest;
/**
 * @author    : Death-Satan
 * @date      : 2021/8/20
 * @createTime: 0:32
 * @company   : Death撒旦
 * @link      https://www.cnblogs.com/death-satan
 */


class TencentInterFaces implements \SaTan\Think\Sms\interfaces\SmsInterface
{
    protected Credential $cred;
    protected TencentCloud\Common\Profile\ClientProfile $client_profile;
    protected TencentCloud\Common\Profile\HttpProfile $http_profile;
    protected TencentCloud\Sms\V20210111\SmsClient $sms_client;
    public function __construct ($config)
    {
        $this->cred = new Credential($config['secretId'],$config['secretKey']);
        $this->http_profile = new TencentCloud\Common\Profile\HttpProfile();
        $this->http_profile->setEndpoint($config['endpoint']);
        $this->client_profile = new TencentCloud\Common\Profile\ClientProfile();
        $this->client_profile->setHttpProfile($this->http_profile);
        $this->sms_client = new TencentCloud\Sms\V20210111\SmsClient($this->cred,$config['region'],$this->client_profile);
    }
    /**
     * @inheritDoc
     */
    public function sendSms (int $phone, string $sign_name, string $template_code, array $TemplateParam = [], array $extras = [])
    {
        $req = new \TencentCloud\Sms\V20210111\Models\SendSmsRequest();
        $params = [
            'PhoneNumberSet'=>[$phone],
            'TemplateId'=>$template_code
        ];
        if (!empty($sign_name)) $params['SignName']=$sign_name;

        if (!empty($TemplateParam)) $params['TemplateParamSet']=$TemplateParam;

        if (!empty($extras['SmsSdkAppId'])) $params['SmsSdkAppId'] = $extras['SmsSdkAppId'];

        if (!empty($extras['ExtendCode'])) $params['ExtendCode'] = $extras['ExtendCode'];

        if (!empty($extras['SessionContext'])) $params['SessionContext'] = $extras['SessionContext'];

        if (!empty($extras['SenderId'])) $params['SenderId'] = $extras['SenderId'];

        $req->fromJsonString(collect($params)->toJson());
        return $this->sms_client->SendSms($req);
    }

    /**
     * @inheritDoc
     */
    public function sendBatchSms (array $phones, array $sign_name, string $template_code, array $extras = [])
    {
        $req = new \TencentCloud\Sms\V20210111\Models\SendSmsRequest();
        $params = [
            'PhoneNumberSet'=>$phones,
            'TemplateId'=>$template_code
        ];
        if (!empty($sign_name)) $params['SignName']=$sign_name;

        if (!empty($extras['TemplateParam'])) $params['TemplateParamSet']=$extras['TemplateParam'];

        if (!empty($extras['SmsSdkAppId'])) $params['SmsSdkAppId'] = $extras['SmsSdkAppId'];

        if (!empty($extras['ExtendCode'])) $params['ExtendCode'] = $extras['ExtendCode'];

        if (!empty($extras['SessionContext'])) $params['SessionContext'] = $extras['SessionContext'];

        if (!empty($extras['SenderId'])) $params['SenderId'] = $extras['SenderId'];

        $req->fromJsonString(collect($params)->toJson());
        return $this->sms_client->SendSms($req);
    }

    /**
     * @inheritDoc
     */
    public function addSmsSign (string $sign_name, string $sign_source, string $remark, array $extras = [])
    {
        $req = new \TencentCloud\Sms\V20210111\Models\AddSmsSignRequest();

        $params = array(
            "SignName" => $sign_name,
            "SignType" => (int)$sign_source,
            "Remark" => $remark
        );
        if (!empty($extras['DocumentType'])) $params['DocumentType'] = $extras['DocumentType'];
        if (!empty($extras['International'])) $params['International'] = $extras['International'];
        if (!empty($extras['SignPurpose'])) $params['SignPurpose'] = $extras['SignPurpose'];
        if (!empty($extras['ProofImage'])) $params['ProofImage'] = $extras['ProofImage'];
        if (!empty($extras['CommissionImage'])) $params['CommissionImage'] = $extras['CommissionImage'];

        $req->fromJsonString(collect($params)->toJson());

        return $this->sms_client->AddSmsSign($req);
    }

    /**
     * @inheritDoc
     */
    public function deleteSmsSign (string $sign_name, array $extras = [])
    {
        $req = new \TencentCloud\Sms\V20210111\Models\DeleteSmsSignRequest();
        $params = array(
            "SignId" => (int)$sign_name
        );
        $req->fromJsonString(collect($params)->toJson());
        return $this->sms_client->DeleteSmsSign($req);
    }

    /**
     * @inheritDoc
     */
    public function modifySmsSign (string $sign_name, string $sign_source, string $remark, array $extras = [])
    {
        $req = new ModifySmsSignRequest();

        $params = array(
            "SignName" => $sign_name,
            "SignType" => (int)$sign_source,
            "Remark" => $remark
        );
        if (!empty($extras['SignId'])) $params['SignId']=$extras['SignId'];

        if (!empty($extras['DocumentType'])) $params['DocumentType']=$extras['DocumentType'];

        if (!empty($extras['International'])) $params['International']=$extras['International'];
        if (!empty($extras['SignPurpose'])) $params['SignPurpose']=$extras['SignPurpose'];
        if (!empty($extras['ProofImage'])) $params['ProofImage']=$extras['ProofImage'];
        if (!empty($extras['CommissionImage'])) $params['CommissionImage']=$extras['CommissionImage'];

        $req->fromJsonString(collect($params)->toJson());

        return $this->sms_client->ModifySmsSign($req);
    }

    /**
     * @inheritDoc
     */
    public function querySmsSign (string $sign_name = '', array $extras = [])
    {
        $req = new DescribeSmsSignListRequest();
        $params = array(
            "SignIdSet" => [$sign_name],
        );
        if (!empty($extras['International'])) $params['International']=$extras['International'];
        $req->fromJsonString(collect($params)->toJson());
        return $this->sms_client->DescribeSmsSignList($req);
    }

    /**
     * @inheritDoc
     */
    public function addSmsTemplate (string $template_name, int $template_type, string $template_content, string $remark, array $extras = [])
    {
        $req = new AddSmsTemplateRequest();
        $params = array(
            "TemplateName" => $template_name,
            "TemplateContent" => $template_content,
            "SmsType" => $template_type,
            "Remark" => $remark
        );
        if (!empty($extras['International'])) $params['International']=$extras['International'];

        $req->fromJsonString(collect($params)->toJson());

        return $this->sms_client->AddSmsTemplate($req);
    }

    /**
     * @inheritDoc
     */
    public function deleteSmsTemplate (string $template_code, array $extras = [])
    {
        $req = new DeleteSmsTemplateRequest();
        $params = array(
            "TemplateId" => (int)$template_code
        );
        $req->fromJsonString(collect($params)->toJson());
        return $this->sms_client->DeleteSmsTemplate($req);
    }

    /**
     * @inheritDoc
     */
    public function modifySmsTemplate (string $template_code, int $template_type, string $template_name, string $template_content, string $remark, array $extras = [])
    {
        $req = new ModifySmsTemplateRequest();
        $params = array(
            "TemplateId" => $template_code,
            "TemplateName" => $template_name,
            "TemplateContent" => $template_content,
            "SmsType" => $template_type,
            "Remark" => $remark
        );
        if (!empty($extras['International'])) $params['International']=$extras['International'];
        $req->fromJsonString(collect($params)->toJson());
        return $this->sms_client->ModifySmsTemplate($req);
    }

    /**
     * @inheritDoc
     */
    public function querySmsTemplate (string $template, array $extras = [])
    {
        $req = new DescribeSmsTemplateListRequest();
        $params = array(
            "TemplateIdSet" => [$template],
        );
        if (!empty($extras['International'])) $params['International']=$extras['International'];
        $req->fromJsonString(collect($params)->toJson());
        return $this->sms_client->DescribeSmsTemplateList($req);
    }
}