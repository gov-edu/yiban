# OAuth 2.0的基本概念

#### 1.OAuth 2.0 是什么？

OAuth 2.0是在2006年底创建的下一代OAuth协议。OAuth 2.0为客户端开发者开发Web应用，桌面端应用程序，移动应用及客厅设备提供特定的授权流程。该规范是IETF OAuth WG工作组下基于OAuth WRAP协议制定的。

#### 2.OAuth 2.0 能做什么？

OAuth 2.0 授权框架允许第三方应用通过代表拥有编排批准交互的资源所有者和HTTP服务的资源或者通过允许第三方应用程序获得代表自己访问受限的HTTP服务。

#### 3.OAuth 2.0有哪些角色？

资源拥有者（resource owner）：能够授权访问被保护资源的一个实体。当它指的一个人时，就是称之为终端用户。

资源服务器（resource server）：管理受保护资源的服务器。当使用访问令牌访问资源时，它决定是否接受该令牌并输出受保护的资源。

客户端（client）：应用程序本身不存储任何受保护的资源，而是资源所有者授权通过后，使用它的授权访问受保护的资源，然后客户端把响应的数据展示/提交给服务器。 使受保护的资源请求资源所有者的代表和授权。

授权服务器（authorization server）：客户端成功验证资源所有者并获取授权后，授权服务器发放访问令牌给客户端。

#### 4.OAuth 2.0授权流程

4.1 客户端向资源拥有者发起授权请求，这种授权请求可以直接向资源拥有者发起（如图），也可以间接通过授权服务器作为中介发起。

4.2 客户端接收授权许可，这是一个代表资源所有者的授权凭证。授权类型可以OAuth 2.0规范中四种的任意一种，也可以是扩展授权类型。授权类型取决于方法所使用的客户端请求授权和授权服务器所支持的类型。

4.3 客户端通过私有证书和授权许可请求授权服务器授权。

4.4 授权服务器对客户端进行验证。验证通过后，返回访问令牌。

4.5 客户端使用访问令牌向资源服务器请求受保护资源。

4.6 资源服务器验证令牌的有效性，验证成功后，下发受保护的资源。



打算把用户数据共享给开发者，估计是疯了。当然，这也就涉及到开发者认证、API接口、Access Token、AppKey、OAuth这些你如果没接触过就会听的云里雾里的什么鬼。其实这些名词都包含在**OAuth 2.0**的概念中，从今天起，我要一步步掰开揉碎来理解它们，或许也能帮到你说不定。 

什么是 OAuth 2.0？

为什么是2.0？肯定有1.0。

 我打开了维基百科：OAuth（开放授权）是一个`开放标准`，允许用户让`第三方`应用访问该`用户`在某`一网站`上存储的私密的`资源`（如照片，视频，联系人列表），而无需将`用户名`和`密码`提供给第三方应用。看到这，也需你「哦」了一声，你是不是想起了QQ、微博等快捷登录、微信授权和TX的不要脸。OK，那接着看2.0。
 OAuth 2.0是OAuth协议的`下一版本`，但不向下兼容OAuth 1.0。OAuth 2.0关注客户端开发者的`简易性`，同时为`Web应用`、`桌面应用`和`手机`，和`起居室设备`提供专门的认证流程。不就是升级版么，有什么了不起。对了，这就是 OAuth 2.0 。

当你去点击微博或QQ图标的时候，会跳转一个授权页面，当你输入你的账户及密码后，就可以去静静的装逼了。当然，逼乎是不会知道你的微博或QQ密码的，这就用到了 OAuth 2.0 协议。 

### OAuth 2.0 协议有哪几种？

上面说到的「第三方快捷登录」只是 OAuth 2.0 协议的其中一种，其实它是有**四种**授权方式的，但无论如何客户端必须得到用户的授权（authorization grant），才能获得令牌（access token）。四种授权方式如下：

- **授权码模式（authorization code）**
- **简化模式（implicit）**
- **密码模式（resource owner password credentials）**
- **客户端模式（client credentials）**



**OAuth 就是一个开放授权协议！ OAuth 就是一个开放授权协议！！ OAuth 就是一个开放授权协议！！** 

# 做一个开发者中心 

你肯定已经了解到什么是 OAuth 2.0 了，你说它不就是一个协议么，但是那些第三方接口都有什么`ClientId`、`ClientSecret`、`Access Token`、`Refresh Token`等等之类的，看着都头晕，这些到底是什么阿阿阿？。

是这样的，我也如你一样苦恼，这些到底都是什么鬼、干什么的？这篇文章就讲清道明这些东西到底是什么鬼！！！ 

## 一个开发者中心的授权流程是怎样的

上文好像说到我们要开发一个「开发者中心」，所以，我想先讲一下这个所谓的「开发者中心」是怎样把数据开放给开发者的。
 正如你所知道的数据是无价的，我们并不想`任何人`都能通过我们的开放平台来获取数据。举个栗子：你家有好多书，其实你并不看，但有好多朋友想看，你又不想任何人都能去你家拿走你心爱的《C#入门经典》，首先他要向你说明他想借你的书看看，你同意后说：你`请我吃饭`吧，然后我给你`我家钥匙`你自己去取吧，我忙。

这个过程就叫做：**授权**！请你吃饭可以理解为`ClientId`、`ClientSecret`，你家的钥匙就是所谓的`Token`。
 够了够了，你说的这些我都懂，那怎么用代码要体现呢？

## 利用 Web API 来实现 OAuth 授权

为什么是 Web API ?
 因为 ASP.NET Web API 是针对接口而生的阿。况且它还是`REST风格`的哦，更轻量级一些，其实这些都不重要，重要的它够简单，十分钟即可上手。
 怎么使用 OAuth 的方式实现授权？
 Microsoft.Owin.Security.OAuth，就是它！你要知道这可是.Net的可爱之处，她把你需要的就放在了那里，你用不用她就在那。现在就使用它来实现 OAuth 2.0 中所说的四种授权模式之一的*客户端模式（client credentials）*。

 Ⅰ. 打开VS2013，新建一个 Web API 项目。[源码](https://github.com/mafly/OAuth2.0)
 Ⅱ. 在Project右键，选择“管理NuGet程序包”，搜索“Owin”。安装下面的包：

- Microsoft.Owin.Security.OAuth
- Microsoft.Owin.Security
- Microsoft.Owin
- Microsoft.Owin.Host.SystemWeb(我被它坑了好久)
- OWIN
- Microsoft ASP.Net Web API 2.2 OWIN
- Microsoft ASP.Net Identity OWIN

Ⅲ. 修改 Startup.cs 文件如下，如没有，则新建。

```
using ...

[assembly: OwinStartup(typeof (Startup))]

namespace Mafly.OAuth2._0.Demo
{
    public class Startup
    {
        public void Configuration(IAppBuilder app)
        {
            // 有关如何配置应用程序的详细信息，请访问 http://go.microsoft.com/fwlink/?LinkID=316888
            var config = new HttpConfiguration();
            WebApiConfig.Register(config);

            //开启OAuth服务
            ConfigureOAuth(app);

            app.UseWebApi(config);
        }

        public void ConfigureOAuth(IAppBuilder app)
        {
            // Token 生成配置
            var oAuthOptions = new OAuthAuthorizationServerOptions
            {
                AllowInsecureHttp = true, //允许客户端使用Http协议请求
                AuthenticationMode = AuthenticationMode.Active,
                TokenEndpointPath = new PathString("/token"), //请求地址
                AccessTokenExpireTimeSpan = TimeSpan.FromHours(2), //token过期时间

                //提供认证策略
                Provider = new OpenAuthorizationServerProvider()
                //RefreshTokenProvider = new RefreshAuthenticationTokenProvider()
            };
            app.UseOAuthBearerTokens(oAuthOptions);
        }
    }
}
```

Ⅳ. 新建`OpenAuthorizationServerProvider`

```
public class OpenAuthorizationServerProvider : OAuthAuthorizationServerProvider
    {
        /// <summary>
        ///     验证客户端
        /// </summary>
        /// <param name="context"></param>
        /// <returns></returns>
        public override async Task ValidateClientAuthentication(OAuthValidateClientAuthenticationContext context)
        {
            string clientId;
            string clientSecret;
            context.TryGetFormCredentials(out clientId, out clientSecret);
            //context.TryGetBasicCredentials(out clientId, out clientSecret); //Basic认证

            //TODO:读库，验证
            if (clientId != "malfy" && clientSecret != "111111")
            {
                context.SetError("invalid_client", "client is not valid");
                return;
            }
            context.OwinContext.Set("as:client_id", clientId);
            context.Validated(clientId);
        }

        /// <summary>
        ///     客户端授权[生成access token]
        /// </summary>
        /// <param name="context"></param>
        /// <returns></returns>
        public override Task GrantClientCredentials(OAuthGrantClientCredentialsContext context)
        {
            var oAuthIdentity = new ClaimsIdentity(context.Options.AuthenticationType);
            oAuthIdentity.AddClaim(new Claim(ClaimTypes.Name, context.OwinContext.Get<string>("as:client_id")));
            var ticket = new AuthenticationTicket(oAuthIdentity, new AuthenticationProperties {AllowRefresh = true});
            context.Validated(ticket);
            return base.GrantClientCredentials(context);
        }
    }
```

Ⅴ. 没有第五步了。是不是很简单。[源码](https://github.com/mafly/OAuth2.0)