<?php
/**
 * 易班开放平台SDK  软件开发工具包（Software Development Kit）
 * API是一个具体的函数，一个确定的功能，已经明确了它的作用（比如做加法）。而SDK就像是很多方法的集合体，是一个工具。
 */
class YBOpenApi{

    const YIBAN_OPEN_URL = "https://openapi.yiban.cn/";//易班的官方接口地址头
    
    private static $mpInstance = NULL;

    private $_config = array(
        'appid'     => '',
        'seckey'    => '',
        'token'     => '',
        'backurl'   => ''
    );

    private $_instance = array();
    
    /**
     * 取YBOpenApi实例对象
     *
     * 单例，其它的配置参数使用init()或bind()方法设置
     */
    public static function getInstance() {
        if(self::$mpInstance == NULL) {
            self::$mpInstance = new self();
        }
        
        return self::$mpInstance;
    }

    /**
     * 构造函数
     *
     * 使用 YBOpenApi::getInstance() 初始化
     */
    private function __construct() {
        
    }

    /**
     * 初始化设置
     *
     * YBOpenApi对象的AppID、AppSecret、回调地址参数设定
     *
     * @param   String 应用的APPID
     * @param   String 应用的AppSecret
     * @param   String 回调地址
     * @return  YBOpenApi 自身实例
     */
    public function init($appID, $appSecret, $callback_url = '') {
        $this->_config['appid'] = $appID;
        $this->_config['seckey'] = $appSecret;
        $this->_config['backurl'] = $callback_url;
        
        return self::$mpInstance;
    }

    /**
     * 设定访问令牌
     *
     * 如果已经取到访问令牌，使用此方法设定
     * 大多的接口只需要访问令牌即可完成操作
     * 这类接口不需要调用init()方法
     *
     * @param   String 访问令牌
     * @return  YBOpenApi 自身实例
     */
    public function bind($access_token) {
        $this->_config['token'] = $access_token;
        
        return self::$mpInstance;
    }

    /**
     * HTTP请求辅助函数
     *
     * 对CURL使用简单封装，实现POST与GET请求
     *
     * @param   String api接口地址
     * @param   Array 请求参数数组
     * @param   Boolean 是否使用POST方式请求,默认使用GET方式
     * @return  Array 服务返回的JSON数组
     */
    public static function QueryURL($url, $param = array(), $isPOST = false) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if($isPOST) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        }else if(!empty($param)) {
            $xi = parse_url($url);
            $url .= empty($xi['query']) ? '?' : '&';
            $url .= http_build_query($param);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        if($result == false) {
            throw new YBException(curl_error($ch));
        }
        curl_close($ch);
        
        return json_decode($result, true);
    }
    
    /**
     * API调用方法
     *
     * @param   String api接口地址
     * @param   Array 请求参数数组
     * @param   Boolean 是否使用POST方式请求,默认使用GET方式
     * @param   Boolean 请求参数中是否需要传access_token
     * @return  Array 服务返回的JSON数组
     */
    public function request($url, $param = array(), $isPOST = false, $applyToken = true){
        $url = self::YIBAN_OPEN_URL.$url;
        if($applyToken) {
            $param['access_token'] = $this->_config['token'];
        }
        
        return self::QueryURL($url, $param, $isPOST);
    }
    
    /**
     * 获取配置参数
     * 
     * @param String 配置名称
     */
    public function getConfig($configName){
        return $this->_config[$configName];
    }
    
    /**
     * 轻应用接入
     *
     * @return YBAPI::IApp
     */
    public function getIApp() {
        if (!isset($this->_instance['iapp'])) {
            $this->_instance['iapp'] = new YBAPI_IApp($this->_config);
        }
        
        return $this->_instance['iapp'];
    }
    
}

?>