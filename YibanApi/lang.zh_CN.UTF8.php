<?php
    /**
	 * 语言包
	 */
	class YBLANG{
		const WEB_APP_TITLE		= '开放平台-轻应用授权';
		
		const E_NO_APPID		= '末设置AppID值！';
		const E_NO_APPSECRET	= '末设置AppSecret值！';
		const E_NO_CALLBACKURL	= '末设置回调地址！';
		const E_NO_ACCESSTOKEN	= '末设置access_token值！';
		
		const E_EXE_PERFORM		= 'perform()方法调用错误，请检查是否在轻应用入口页面进行调用！';
		const E_DEC_STRING		= 'verify_request参数解密失败！';
		const E_DEC_RESULT		= 'verify_request参数解密结果异常！';
		
		const EXIT_NOT_AUTHORIZED	= '未通过授权，请先完成授权认证再测试功能接口！';
	}
?>