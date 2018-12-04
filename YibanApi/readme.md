# 基于PHP的易班API

### 一、文档目录结构

-- /
  |
  |-- classes/      开放平台SDK(轻应用)
    |

#####     |-- YBAPI/      易班API接口配置

​      |
      |-- IApp.class.php          对使用轻应用接入方式的应用，提供快速进行授权认证方法
      |                           对于没通过授权的用户，直接跳转到授权认证页面（不需要自己实现跳转）
      |                           已通过授权的用户返回相关用户信息（包含访问令牌）
    |

#####     |-- lang.zh_CN.UTF8.php       语言包

​    |

#####     |-- yb-globals.inc.php        全局整合

​    |

#####     |-- YBException.class.php     异常类

​    |

#####     |-- YBOpenApi.class.php       易班开放平台SDK

  |
  |-- demo/     测试实例
    |
    |-- config.php      配置文件，您需要修改这个文件写入对应的 AppID 等信息
    |
    |-- index.php       DEMO入口
    |
    |-- iapp.php        轻应用授权流程(使用DEMO时请将管理中心->应用详细中应用地址指向此文件所在的URL)
    |
    |-- apitest.php     功能接口测试（需要完成授权流程获取到access_token才能进行接口测试）
    |
    |-- revoke.php      撤销授权功能调用测试
  |
  |-- README.txt          本文档

### 二、SDK初始化简要说明

1、将 classes/ 目录下所有文件放到您的项目中，保持里面的目录结构
2、引用classes/下yb-globals.inc.php文件
3、通过$api = YBOpenApi::getInstance()->init() 实例化对象并配置应用信息
4、(轻应用授权)通过 $api->getIApp()->perform() 完成用户授权，获得access_token(可参考demo中iapp.php文件)
5、通过$api->bind()绑定access_token

### 三、SDK接口调用简要说明

完成初始化后，通过YBOpenApi::getInstance()->request($url, $param, $isPOST, $applyToken)来调用易班api
参数说明：
$url			    String	具体调用的接口名称,例如user/me
$param		  	Array	  接口请求参数数组
$isPOST  		  Boolean	是否使用POST方式请求,默认使用GET方式
$applyToken		Boolean	请求参数中是否需要添加access_token，设置为true时自动添加之前绑定的token到参数数组中(如果为true请先通过bind()将token绑定至实例中)

以 获取当前用户信息 为例：（接口说明  https://o.yiban.cn/wiki/index.php?page=user/me ）
$url 		= 'user/me';
$param 		= array();
$isPOST		= false;
$applyToken = true;
$result = YBOpenApi::getInstance()->request($url, $param, $isPOST, $applyToken);//获取接口返回信息

### 四、应用如何实现授权（通用）

  1、引导需要授权的用户重定向至如下地址
    https://oauth.yiban.cn/code/html?client_id=APPID&redirect_uri=CALLBACK&state=STATE
其中：
  APPID为应用的AppID，在管理中心应用信息中可见
  CALLBACK为授权回调地址（站内应用与轻应用类型时为站内地址，等同授权回调地址），在管理中心应用信息中可见
  STATE为开发者自行设定的防跨站伪造参数
  2、如果用户同意授权，页面重定向至应用端设置的授权回调地址并带上用户令牌 CALLBACK?code=CODE
*如果应用类型是站内应用或轻应用，则页面重定向至站内地址并post方式提供访问用户授权信息， 重新回到判断是否授权的流程，不用后续的授权操作。
  3、换取用户授权凭证access_token，调用如下接口
https://oauth.yiban.cn/token/info?code=CODE&client_id=APPID&client_secret=APPSECRET&redirect_uri=CALLBACK
其中：
  CODE为第2步提供的用户令牌
  APPID为应用的AppID，在管理中心应用信息中可见
  APPSECRET为应用的AppSecret，在管理中心应用信息中可见
  CALLBACK为授权回调地址（站内应用类型时为站内地址，等同授权回调地址），在管理中心应用信息中可见
    返回成功状态的json数组：
{
  "access_token":"授权凭证",
  "userid":"授权用户id",
  "expires":"截止有效期"
}
  4、使用用户授权凭证调用所需的易班开放api，请参考 文档-易班api 。