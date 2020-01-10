<?php /* Smarty version 2.6.31, created on 2020-01-10 10:50:29
         compiled from Modify.tpl */ ?>
<html lang="zh-CN">

    <head>
        <meta charset="UTF-8">
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
        <title>首页设置</title>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_head.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php echo '
            <style>
                .row{margin-left: 0;margin-right: 0;}
            </style>
        '; ?>

    </head>
    <body class="body_bgcolor">
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_img.tpl", 'smarty_include_vars' => array('sitename' => 'DIY_IMG')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

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

                        <?php if ($this->_tpl_vars['class_name'] == 'app_wechat' || $this->_tpl_vars['class_name'] == 'mini_wechat' || $this->_tpl_vars['class_name'] == 'jsapi_wechat'): ?>

                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label">是否显示：</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="radio" value="1" name="status" <?php if ($this->_tpl_vars['list']->status != 0): ?>checked<?php endif; ?>>是
                                <input type="radio" value="0" name="status" <?php if ($this->_tpl_vars['list']->status == 0): ?>checked<?php endif; ?>>否
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label required">AppId</label>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control" value="<?php echo $this->_tpl_vars['list']->appid; ?>
" name="<?php echo $this->_tpl_vars['class_name']; ?>
[appid]" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label required">AppSecret</label>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-hide">
                                    <input class="form-control" value="<?php echo $this->_tpl_vars['list']->appsecret; ?>
" name="<?php echo $this->_tpl_vars['class_name']; ?>
[appsecret]">
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
                                <input class="form-control" name="<?php echo $this->_tpl_vars['class_name']; ?>
[notify_url]" value="<?php echo $this->_tpl_vars['list']->notify_url; ?>
" />
                            </div>
                            <div class="text-danger">注：回调路径默认为 <?php echo $this->_tpl_vars['mrnotify_url']; ?>
</div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label required">微信支付商户号</label>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control" value="<?php echo $this->_tpl_vars['list']->mch_id; ?>
" name="<?php echo $this->_tpl_vars['class_name']; ?>
[mch_id]">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label required">微信支付Api密钥</label>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-hide">
                                    <input class="form-control" value="<?php echo $this->_tpl_vars['list']->mch_key; ?>
" name="<?php echo $this->_tpl_vars['class_name']; ?>
[mch_key]">
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
                                    <textarea rows="5" class="form-control secret-content" name="<?php echo $this->_tpl_vars['class_name']; ?>
[cert_pem]"><?php echo $this->_tpl_vars['list']->cert_pem; ?>
</textarea>
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
                                    <textarea rows="5" class="form-control secret-content" name="<?php echo $this->_tpl_vars['class_name']; ?>
[key_pem]"><?php echo $this->_tpl_vars['list']->key_pem; ?>
</textarea>
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

                        <?php elseif ($this->_tpl_vars['class_name'] == 'wallet_pay'): ?>


                        钱包参数暂时无需配置

                        <?php elseif ($this->_tpl_vars['class_name'] == 'alipay'): ?>

                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label">是否显示：</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="radio" value="1" name="status" <?php if ($this->_tpl_vars['list']->status != 0): ?>checked<?php endif; ?>>是
                                <input type="radio" value="0" name="status" <?php if ($this->_tpl_vars['list']->status == 0): ?>checked<?php endif; ?>>否
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label required">支付宝AppId</label>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control" value="<?php echo $this->_tpl_vars['list']->appid; ?>
" name="<?php echo $this->_tpl_vars['class_name']; ?>
[appid]">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label">支付宝回调路径</label>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control" name="<?php echo $this->_tpl_vars['class_name']; ?>
[notify_url]" value="<?php echo $this->_tpl_vars['list']->notify_url; ?>
">
                            </div>
                            <div class="text-danger">注：回调路径默认为 <?php echo $this->_tpl_vars['mrnotify_url']; ?>
</div>
                        </div>

                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label">签名类型</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="radio" value="RSA" name="<?php echo $this->_tpl_vars['class_name']; ?>
[signType]" <?php if ($this->_tpl_vars['list']->signType != RSA2): ?>checked<?php endif; ?>>RSA
                                <input type="radio" value="RSA2" name="<?php echo $this->_tpl_vars['class_name']; ?>
[signType]" <?php if ($this->_tpl_vars['list']->signType == RSA2): ?>checked<?php endif; ?>>RSA2
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label">加密密钥</label>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-hide">
                                    <input class="form-control" name="<?php echo $this->_tpl_vars['class_name']; ?>
[encryptKey]" value="<?php echo $this->_tpl_vars['list']->encryptKey; ?>
"></input>
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
                                    <textarea rows="5" class="form-control secret-content" name="<?php echo $this->_tpl_vars['class_name']; ?>
[rsaPrivateKey]"><?php echo $this->_tpl_vars['list']->rsaPrivateKey; ?>
</textarea>
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
                                    <textarea rows="5" class="form-control secret-content" name="<?php echo $this->_tpl_vars['class_name']; ?>
[alipayrsaPublicKey]"><?php echo $this->_tpl_vars['list']->alipayrsaPublicKey; ?>
</textarea>
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
                        <?php elseif ($this->_tpl_vars['class_name'] == 'alipay_minipay'): ?>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label">是否显示：</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="radio" value="1" name="status" <?php if ($this->_tpl_vars['list']->status != 0): ?>checked<?php endif; ?>>是
                                    <input type="radio" value="0" name="status" <?php if ($this->_tpl_vars['list']->status == 0): ?>checked<?php endif; ?>>否
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label required">支付宝小程序AppId</label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" value="<?php echo $this->_tpl_vars['list']->appid; ?>
" name="<?php echo $this->_tpl_vars['class_name']; ?>
[appid]">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label">支付宝回调路径</label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" name="<?php echo $this->_tpl_vars['class_name']; ?>
[notify_url]" value="<?php echo $this->_tpl_vars['list']->notify_url; ?>
">
                                </div>
                                <div class="text-danger">注：回调路径默认为 <?php echo $this->_tpl_vars['mrnotify_url']; ?>
</div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label">签名类型</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="radio" value="RSA" name="<?php echo $this->_tpl_vars['class_name']; ?>
[signType]" <?php if ($this->_tpl_vars['list']->signType != RSA2): ?>checked<?php endif; ?>>RSA
                                    <input type="radio" value="RSA2" name="<?php echo $this->_tpl_vars['class_name']; ?>
[signType]" <?php if ($this->_tpl_vars['list']->signType == RSA2): ?>checked<?php endif; ?>>RSA2
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label">开发者私钥</label>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-hide">
                                        <textarea rows="5" class="form-control secret-content" name="<?php echo $this->_tpl_vars['class_name']; ?>
[rsaPrivateKey]"><?php echo $this->_tpl_vars['list']->rsaPrivateKey; ?>
</textarea>
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
                                        <textarea rows="5" class="form-control secret-content" name="<?php echo $this->_tpl_vars['class_name']; ?>
[alipayrsaPublicKey]"><?php echo $this->_tpl_vars['list']->alipayrsaPublicKey; ?>
</textarea>
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
                        <?php elseif ($this->_tpl_vars['class_name'] == 'tt_alipay'): ?>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label">是否显示：</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="radio" value="1" name="status" <?php if ($this->_tpl_vars['list']->status != 0): ?>checked<?php endif; ?>>是
                                    <input type="radio" value="0" name="status" <?php if ($this->_tpl_vars['list']->status == 0): ?>checked<?php endif; ?>>否
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label required">头条小程序AppId</label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" value="<?php echo $this->_tpl_vars['list']->ttAppid; ?>
" name="<?php echo $this->_tpl_vars['class_name']; ?>
[ttAppid]">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label required">头条小程序秘钥</label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" value="<?php echo $this->_tpl_vars['list']->ttAppSecret; ?>
" name="<?php echo $this->_tpl_vars['class_name']; ?>
[ttAppSecret]">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label required">支付宝回调路径</label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" name="<?php echo $this->_tpl_vars['class_name']; ?>
[notify_url]" value="<?php echo $this->_tpl_vars['list']->notify_url; ?>
">
                                </div>
                                <div class="text-danger">注：回调路径默认为 <?php echo $this->_tpl_vars['mrnotify_url']; ?>
</div>
                            </div>
                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label required">头条支付商户ID</label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" name="<?php echo $this->_tpl_vars['class_name']; ?>
[ttshid]" value="<?php echo $this->_tpl_vars['list']->ttshid; ?>
">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label required">头条支付appid</label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" name="<?php echo $this->_tpl_vars['class_name']; ?>
[ttpayappid]" value="<?php echo $this->_tpl_vars['list']->ttpayappid; ?>
">
                                </div>
                                <div class="text-danger">注：与上面的小程序appid不是同一个,在头条商户支付页面获取。</div>
                            </div>
                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label required">头条支付秘钥</label>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-hide">
                                        <input class="form-control" name="<?php echo $this->_tpl_vars['class_name']; ?>
[ttpaysecret]" value="<?php echo $this->_tpl_vars['list']->ttpaysecret; ?>
">
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
                        <?php elseif ($this->_tpl_vars['class_name'] == 'baidu_pay'): ?>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label">是否显示：</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="radio" value="1" name="status" <?php if ($this->_tpl_vars['list']->status != 0): ?>checked<?php endif; ?>>是
                                    <input type="radio" value="0" name="status" <?php if ($this->_tpl_vars['list']->status == 0): ?>checked<?php endif; ?>>否
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label required">百度小程序App Key</label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" value="<?php echo $this->_tpl_vars['list']->bdmpappid; ?>
" name="<?php echo $this->_tpl_vars['class_name']; ?>
[bdmpappid]">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label">百度小程序App Secret</label>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-hide">
                                        <input class="form-control" name="<?php echo $this->_tpl_vars['class_name']; ?>
[bdmpappsk]" value="<?php echo $this->_tpl_vars['list']->bdmpappsk; ?>
"></input>
                                        <div class="tip-block">已隐藏内容，点击查看或编辑</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label required">支付APP ID</label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" value="<?php echo $this->_tpl_vars['list']->appid; ?>
" name="<?php echo $this->_tpl_vars['class_name']; ?>
[appid]">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group-label col-sm-2 text-right">
                                    <label class="col-form-label">支付APP KEY</label>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-hide">
                                        <input class="form-control" name="<?php echo $this->_tpl_vars['class_name']; ?>
[appkey]" value="<?php echo $this->_tpl_vars['list']->appkey; ?>
"></input>
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
                                        <input class="form-control" name="<?php echo $this->_tpl_vars['class_name']; ?>
[dealId]" value="<?php echo $this->_tpl_vars['list']->dealId; ?>
"></input>
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
                                        <textarea rows="5" class="form-control secret-content" name="<?php echo $this->_tpl_vars['class_name']; ?>
[rsaPrivateKey]"><?php echo $this->_tpl_vars['list']->rsaPrivateKey; ?>
</textarea>
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
                                        <textarea rows="5" class="form-control secret-content" name="<?php echo $this->_tpl_vars['class_name']; ?>
[rsaPublicKey]"><?php echo $this->_tpl_vars['list']->rsaPublicKey; ?>
</textarea>
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

                        <?php else: ?>

                        其他支付方式待添加 $class_name

                        <?php endif; ?>

                    </form>
                </div>
            </div>
        </div>
        </div>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_footer.tpl", 'smarty_include_vars' => array('sitename' => "DIY底部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </body>
</html>