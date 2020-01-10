<html lang="zh-CN">

    <head>
        <meta charset="UTF-8">
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
        <title>首页设置</title>
        {include file="../../include_path/software_head.tpl" sitename="DIY头部"}
        {literal}
            <style>
                .row{margin-left: 0;margin-right: 0;}
            </style>
        {/literal}
    </head>
    <body class="body_bgcolor">
        {include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}

        <nav class="breadcrumb page_bgcolor">
            <span class="c-gray en"></span>
            <span style="color: #414658;">权限管理</span>
            <span class="c-gray en">&gt;</span>
            <a style="margin-top: 10px;" onclick="javascript :history.back(-1);">支付管理 </a>
            <span class="c-gray en">&gt;</span>
            <a style="margin-top: 10px;" onclick="javascript :history.back(-1);">参数修改 </a>
        </nav>

        <div class="main-body pd-20 page_absolute">
            <div class="panel mb-3 page_bgcolor sewo" id="app">

                <div class="panel-body">
                    <form class="auto-form" method="post" return="index.php?module=payment&action=Index">

                        {if $class_name == 'app_wechat' || $class_name == 'mini_wechat' || $class_name == 'jsapi_wechat'}

                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label">是否显示：</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="radio" value="1" name="status" {if $list->status != 0}checked{/if}>是
                                <input type="radio" value="0" name="status" {if $list->status == 0}checked{/if}>否
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label required">AppId</label>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control" value="{$list->appid}" name="{$class_name}[appid]" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label required">AppSecret</label>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-hide">
                                    <input class="form-control" value="{$list->appsecret}" name="{$class_name}[appsecret]">
                                    <div class="tip-block">已隐藏内容，点击查看或编辑</div>
                                </div>
                                <div class="text-danger">注：若微信支付尚未开通，以下选项请设置0</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label">回调路径</label>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control" name="{$class_name}[notify_url]" value="{$list->notify_url}" />
                            </div>
                            <div class="text-danger">注：回调路径默认为 {$mrnotify_url}</div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label required">微信支付商户号</label>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control" value="{$list->mch_id}" name="{$class_name}[mch_id]">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label required">微信支付Api密钥</label>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-hide">
                                    <input class="form-control" value="{$list->mch_key}" name="{$class_name}[mch_key]">
                                    <div class="tip-block">已隐藏内容，点击查看或编辑</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label">微信支付apiclient_cert.pem</label>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-hide">
                                    <textarea rows="5" class="form-control secret-content" name="{$class_name}[cert_pem]">{$list->cert_pem}</textarea>
                                    <div class="tip-block">已隐藏内容，点击查看或编辑</div>
                                </div>
                                <div class="fs-sm text-muted">使用文本编辑器打开apiclient_cert.pem文件，将文件的全部内容复制进来</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label">微信支付apiclient_key.pem</label>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-hide">
                                    <textarea rows="5" class="form-control secret-content" name="{$class_name}[key_pem]">{$list->key_pem}</textarea>
                                    <div class="tip-block">已隐藏内容，点击查看或编辑</div>
                                </div>
                                <div class="fs-sm text-muted">使用文本编辑器打开apiclient_key.pem文件，将文件的全部内容复制进来</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                            </div>
                            <div class="col-sm-6">
                                <a style="width: 50px;" class="btn btn-primary auto-form-btn" href="javascript:">保存</a>
                            </div>
                        </div>

                        {elseif $class_name == 'wallet_pay'}


                        钱包参数暂时无需配置

                        {elseif $class_name == 'alipay'}

                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label">是否显示：</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="radio" value="1" name="status" {if $list->status != 0}checked{/if}>是
                                <input type="radio" value="0" name="status" {if $list->status == 0}checked{/if}>否
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label required">支付宝AppId</label>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control" value="{$list->appid}" name="{$class_name}[appid]">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label">支付宝回调路径</label>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control" name="{$class_name}[notify_url]" value="{$list->notify_url}">
                            </div>
                            <div class="text-danger">注：回调路径默认为 {$mrnotify_url}</div>
                        </div>

                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label">签名类型</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="radio" value="RSA" name="{$class_name}[signType]" {if $list->signType != RSA2}checked{/if}>RSA
                                <input type="radio" value="RSA2" name="{$class_name}[signType]" {if $list->signType == RSA2}checked{/if}>RSA2
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label">加密密钥</label>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-hide">
                                    <input class="form-control" name="{$class_name}[encryptKey]" value="{$list->encryptKey}"></input>
                                    <div class="tip-block">已隐藏内容，点击查看或编辑</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label">开发者私钥</label>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-hide">
                                    <textarea rows="5" class="form-control secret-content" name="{$class_name}[rsaPrivateKey]">{$list->rsaPrivateKey}</textarea>
                                    <div class="tip-block">已隐藏内容，点击查看或编辑</div>
                                </div>
                                <div class="fs-sm text-muted">请填写开发者私钥去头去尾去回车，一行字符串</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label">支付宝公钥</label>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-hide">
                                    <textarea rows="5" class="form-control secret-content" name="{$class_name}[alipayrsaPublicKey]">{$list->alipayrsaPublicKey}</textarea>
                                    <div class="tip-block">已隐藏内容，点击查看或编辑</div>
                                </div>
                                <div class="fs-sm text-muted">填写支付宝公钥，一行字符串</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                            </div>
                            <div class="col-sm-6">
                                <a style="width: 50px;" class="btn btn-primary auto-form-btn" href="javascript:">保存</a>
                            </div>
                        </div>
                        {elseif $class_name == 'alipay_minipay'}

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label">是否显示：</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="radio" value="1" name="status" {if $list->status != 0}checked{/if}>是
                                    <input type="radio" value="0" name="status" {if $list->status == 0}checked{/if}>否
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label required">支付宝小程序AppId</label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" value="{$list->appid}" name="{$class_name}[appid]">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label">支付宝回调路径</label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" name="{$class_name}[notify_url]" value="{$list->notify_url}">
                                </div>
                                <div class="text-danger">注：回调路径默认为 {$mrnotify_url}</div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label">签名类型</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="radio" value="RSA" name="{$class_name}[signType]" {if $list->signType != RSA2}checked{/if}>RSA
                                    <input type="radio" value="RSA2" name="{$class_name}[signType]" {if $list->signType == RSA2}checked{/if}>RSA2
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label">开发者私钥</label>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-hide">
                                        <textarea rows="5" class="form-control secret-content" name="{$class_name}[rsaPrivateKey]">{$list->rsaPrivateKey}</textarea>
                                        <div class="tip-block">已隐藏内容，点击查看或编辑</div>
                                    </div>
                                    <div class="fs-sm text-muted">请填写开发者私钥去头去尾去回车，一行字符串</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label">支付宝公钥</label>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-hide">
                                        <textarea rows="5" class="form-control secret-content" name="{$class_name}[alipayrsaPublicKey]">{$list->alipayrsaPublicKey}</textarea>
                                        <div class="tip-block">已隐藏内容，点击查看或编辑</div>
                                    </div>
                                    <div class="fs-sm text-muted">填写支付宝公钥，一行字符串</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                </div>
                                <div class="col-sm-6">
                                    <a style="width: 50px;" class="btn btn-primary auto-form-btn" href="javascript:">保存</a>
                                </div>
                            </div>
                        {elseif $class_name == 'tt_alipay'}

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label">是否显示：</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="radio" value="1" name="status" {if $list->status != 0}checked{/if}>是
                                    <input type="radio" value="0" name="status" {if $list->status == 0}checked{/if}>否
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label required">头条小程序AppId</label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" value="{$list->ttAppid}" name="{$class_name}[ttAppid]">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label required">头条小程序秘钥</label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" value="{$list->ttAppSecret}" name="{$class_name}[ttAppSecret]">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label required">支付宝回调路径</label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" name="{$class_name}[notify_url]" value="{$list->notify_url}">
                                </div>
                                <div class="text-danger">注：回调路径默认为 {$mrnotify_url}</div>
                            </div>
                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label required">头条支付商户ID</label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" name="{$class_name}[ttshid]" value="{$list->ttshid}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label required">头条支付appid</label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" name="{$class_name}[ttpayappid]" value="{$list->ttpayappid}">
                                </div>
                                <div class="text-danger">注：与上面的小程序appid不是同一个,在头条商户支付页面获取。</div>
                            </div>
                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label required">头条支付秘钥</label>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-hide">
                                        <input class="form-control" name="{$class_name}[ttpaysecret]" value="{$list->ttpaysecret}">
                                    </div>
                                </div>
                                <div class="text-danger">注：与上面的小程序秘钥不是同一个,在头条商户支付页面获取。</div>
                            </div>
                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                </div>
                                <div class="col-sm-6">
                                    <a style="width: 50px;" class="btn btn-primary auto-form-btn" href="javascript:">保存</a>
                                </div>
                            </div>
                        {elseif $class_name == 'baidu_pay'}

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label">是否显示：</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="radio" value="1" name="status" {if $list->status != 0}checked{/if}>是
                                    <input type="radio" value="0" name="status" {if $list->status == 0}checked{/if}>否
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label required">百度小程序App Key</label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" value="{$list->bdmpappid}" name="{$class_name}[bdmpappid]">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label">百度小程序App Secret</label>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-hide">
                                        <input class="form-control" name="{$class_name}[bdmpappsk]" value="{$list->bdmpappsk}"></input>
                                        <div class="tip-block">已隐藏内容，点击查看或编辑</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label required">支付APP ID</label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" value="{$list->appid}" name="{$class_name}[appid]">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label">支付APP KEY</label>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-hide">
                                        <input class="form-control" name="{$class_name}[appkey]" value="{$list->appkey}"></input>
                                        <div class="tip-block">已隐藏内容，点击查看或编辑</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label">dealId</label>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-hide">
                                        <input class="form-control" name="{$class_name}[dealId]" value="{$list->dealId}"></input>
                                        <div class="tip-block">已隐藏内容，点击查看或编辑</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label">开发者私钥</label>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-hide">
                                        <textarea rows="5" class="form-control secret-content" name="{$class_name}[rsaPrivateKey]">{$list->rsaPrivateKey}</textarea>
                                        <div class="tip-block">已隐藏内容，点击查看或编辑</div>
                                    </div>
                                    <div class="fs-sm text-muted">填写百度开发者私钥（文档里面直接复制粘贴）</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label">平台公钥</label>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-hide">
                                        <textarea rows="5" class="form-control secret-content" name="{$class_name}[rsaPublicKey]">{$list->rsaPublicKey}</textarea>
                                        <div class="tip-block">已隐藏内容，点击查看或编辑</div>
                                    </div>
                                    <div class="fs-sm text-muted">填写平台公钥，一行字符串</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                </div>
                                <div class="col-sm-6">
                                    <a style="width: 50px;" class="btn btn-primary auto-form-btn" href="javascript:">保存</a>
                                </div>
                            </div>

                        {else}

                        其他支付方式待添加 $class_name

                        {/if}

                    </form>
                </div>
            </div>
        </div>
        </div>

        {include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
    </body>
</html>