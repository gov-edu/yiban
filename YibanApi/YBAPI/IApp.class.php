<?php

/**
 * @package YBAPI
 * 轻应用开发接入辅助类
 *
 * 对使用轻应用接入方式的应用，提供快速进行授权认证方法
 * 对于没通过授权的用户，直接跳转到授权认证页面（不需要自己实现跳转）
 * 已通过授权的用户返回相关用户信息（包含访问令牌）
 */
class YBAPI_IApp {

    const API_OAUTH_CODE = "oauth/authorize";

    private $appJsUrl = 'http://f.yiban.cn/';
    
    /**
     * 构造函数
     *
     * 使用YBOpenApi里的config数组初始化
     *
     * @param   Array 配置（对应YBOpenApi里的config数组）
     */
    public function __construct($config) {
        foreach ($config as $key => $val) {
            $this->$key = $val;
        }
    }

    /**
     * 对轻应用授权进行验证
     *
     * 对于轻应用通过页面跳转的方式，
     * 认证时从GET的参数verify_request串中解密出相关授权信息
     * 如已经授权，显示应用内容，
     * 若末授权，则跳转到授权服务去进行授权
     *
     * @return Array 授权信息数据
     */
    public function perform() {
        $code = $_GET['verify_request'];
        
        if (!isset($code) || empty($code)) {
            throw new YBException(YBLANG::E_EXE_PERFORM);//perform()方法调用错误，请检查是否在轻应用入口页面进行调用！
        }
        $decInfo = $this->decrypts($code);
        if (!$decInfo){
            throw new YBException(YBLANG::E_DEC_STRING);//verify_request参数解密失败！
        }
        if (!is_array($decInfo) || !isset($decInfo['visit_oauth'])) {
            throw new YBException(YBLANG::E_DEC_RESULT);//verify_request参数解密结果异常！
        }
        if (!$decInfo['visit_oauth']) {//未授权跳转
            header('location: '.$this->forwardurl());
            return false;
        }
        return $decInfo;
    }

    //解密授权信息
    public function decrypts($code){
        $encText = addslashes($code);
        $strText = pack("H*", $encText);
        $decText = (strlen($this->appid) == 16) ? mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->seckey, $strText, MCRYPT_MODE_CBC, $this->appid) : mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->seckey, $strText, MCRYPT_MODE_CBC, $this->appid);
        if (empty($decText)) {
            return false;
        }
        $decInfo = json_decode(trim($decText), true);
        return $decInfo;
    }
    
    
    /**
     * 生成授权认证地址
     *
     * 重定向到授权地址
     * 获取授权认证的CODE用于取得访问令牌
     *
     * @return	String 授权认证页面地址
	 */
    private function forwardurl() {
        assert(!empty($this->appid),   YBLANG::E_NO_APPID);
        assert(!empty($this->backurl), YBLANG::E_NO_CALLBACKURL);
        
        $query = http_build_query(array(
            'client_id'		=> $this->appid,
            'redirect_uri'	=> $this->backurl,
            'display'		=> 'html',
        ));
        
        return YBOpenApi::YIBAN_OPEN_URL.self::API_OAUTH_CODE.'?'.$query;
	}

}

?>