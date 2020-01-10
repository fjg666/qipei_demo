{include file="../../include_path/header.tpl" sitename="DIY头部"}

{literal}
<style type="text/css">
    .divhide{
        display: none;
    }
	
	.form_content{margin-left: 102px;background:rgba(244,247,249,1);border-radius: 4px;padding-bottom: 30px;}
	.form_content_title{margin: 0!important;height: 50px;font-size: 16px;font-weight: 400;font-family:MicrosoftYaHei;color:#414658;line-height:50px;padding-left: 20px;border-bottom: 1px solid #E9ECEF;}
	.row .form-label{width:192px!important;}
	
	.form-horizontal .row {padding-left: 29px;}
	.form-horizontal .radio{margin-top: 0;}
</style>
{/literal}
</head>

<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
	<div class="page_title">图片管理</div>
    <form name="form1" class="form form-horizontal" style="padding: 60px;padding-top: 40px;">
        <div class="row cl" style="display: flex; align-items: center;margin-top: 0;padding: 0;">
            <label class="form-label col-xs-4 col-sm-4" style="width: 102px!important;margin-top: 0;"><span class="c-red">*</span>上传服务器：</label>
            <div class="formControls col-xs-8 col-sm-6">
                <input class="radio" type="radio" name="upserver" value="local" {if $upserver==1}checked{/if}>本地
                <input class="radio" type="radio" name="upserver" value="OSS" {if $upserver==2}checked{/if} style="margin-left:20px;">阿里云
                {*<input class="radio" type="radio" name="upserver" value="tenxun" {if $upserver==3}checked{/if} style="margin-left:20px;">腾讯云*}
                {*<input class="radio" type="radio" name="upserver" value="qiniu" {if $upserver==4}checked{/if} style="margin-left:20px;">七牛云*}
            </div>
        </div>
		
        <div id="local" name="seriver" class="divhide form_content">
            <div class="row cl form_content_title">本地配置：</div>
            <div class="row cl" style="margin-top: 30px;">
                <label class="form-label col-3"><span class="c-red">*</span>图片上传域名</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="{$local.uploadImg_domain}" placeholder="" id="" name="uploadImg_domain">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-3"><span class="c-red">*</span>图片上传位置</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="{$local.uploadImg}" placeholder="" id="" name="uploadImg">
                </div>
            </div>
        </div>

        <div id="OSS" name="seriver" class="divhide form_content">
            <div class="row cl form_content_title">阿里云OSS</div>
            <div class="row cl" style="margin-top: 30px;">
                <label class="form-label col-3"><span class="c-red">*</span>存储空间名称（Bucket）</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="{$oss.Bucket}" placeholder="" id="" name="OSSBucket">
                </div>
                <div style="color:#666;">请设置存储空间为公共读</div>
            </div>
            <div class="row cl">
                <label class="form-label col-3"><span class="c-red">*</span>Endpoint（或自定义域名）</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="{$oss.Endpoint}" placeholder="" id="" name="OSSEndpoint">
                </div>
                <div style="color:#666;">例子：oss-cn-hangzhou.aliyuncs.com，结尾不需要/</div>
            </div>
            <div class="row cl">
                <label class="form-label col-3"><span class="c-red"></span>是否开启自定义域名</label>
                <div class="formControls col-2 skin-minimal" style="display: flex; height: 25px; align-items: center;">
                    <div class="radio-box" style="display: flex;align-items: center;padding: 0;">
                        <input name="OSSzidingyi" type="radio" value="0"
                               {if $oss.isopenzdy==0}checked="checked"{/if} style="width: 14px;height: 14px!important;margin-top: 0;"/>
                        <label for="sex-0">否</label>
                    </div>
                    <div class="radio-box" style="display: flex;align-items: center;padding: 0;margin-left: 20px;">
                        <input name="OSSzidingyi" type="radio" value="1" {if $oss.isopenzdy==1}checked="checked"{/if} style="width: 14px;height: 14px!important;margin-top: 0;"/>
                        <label for="sex-1">是</label>
                    </div>
                </div>
                <div class="col-4"> </div>
            </div>

            <div class="row cl">
                <label class="form-label col-3"><span class="c-red">*</span>Access Key ID</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="{$oss.AccessKeyID}" placeholder="" id="" name="OSSAccessKey">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-3"><span class="c-red">*</span>Access Key Secret</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="{$oss.AccessKeySecret}" placeholder="" id="" name="OSSAccessSecret">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-3">图片样式接口（选填）</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="{$oss.imagestyle}" placeholder="" id="" name="OSSimgstyleapi">
                </div>
            </div>
        </div>

        <div id="tenxun" name="seriver" class="divhide form_content">
            <div class="row cl form_content_title">腾讯云配置</div>
            <div class="row cl" style="margin-top: 30px;">
                <label class="form-label col-3"><span class="c-red">*</span>存储空间名称（Bucket）</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="{$tenxun.Bucket}" placeholder="" id="" name="tenxunBucket">
                </div>
                <div style="color:#666;">请设置存储空间为公共读</div>
            </div>
            <div class="row cl">
                <label class="form-label col-3"><span class="c-red">*</span>默认域名</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="{$tenxun.Endpoint}" placeholder="" id="" name="tenxunEndpoint">
                </div>
                <div style="color:#666;">例子：bucket-appid.cossh.myqcloud.com或者bucket-appid.cos.ap-shanghai.myqcloud.com</div>
            </div>
            <div class="row cl">
                <label class="form-label col-3"><span class="c-red"></span>自定义域名</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="{$tenxun.zidingyi}" placeholder="" id="" name="tenxunzidingyi">
                </div>
                <div style="color:#666;">没有可不填</div>
            </div>

            <div class="row cl">
                <label class="form-label col-3"><span class="c-red">*</span>SecretId</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="{$tenxun.SecretId}" placeholder="" id="" name="tenxunAccessKey">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-3">SecretKey</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="{$tenxun.SecretKey}" placeholder="" id="" name="tenxunAccessSecret">
                </div>
            </div>

        </div>

        <div id="qiniu" name="seriver" class="divhide form_content">
            <div class="row cl form_content_title">七牛云配置</div>
            <div class="row cl" style="margin-top: 30px;">
                <label class="form-label col-3"><span class="c-red">*</span>存储空间名称（Bucket）</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="{$qiniu.Bucket}" placeholder="" id="" name="qiniuBucket">
                </div>
                <div style="color:#666;">请设置存储空间为公共读</div>
            </div>
            <div class="row cl">
                <label class="form-label col-3"><span class="c-red">*</span>绑定域名（或测试域名）</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="{$qiniu.Endpoint}" placeholder="" id="" name="qiniuEndpoint">
                </div>
                <div style="float: left;width: 300px;color: #666;">例子：http://abstehdsdw.bkt.clouddn.com，结尾不需要/</div>
            </div>

            <div class="row cl">
                <label class="form-label col-3"><span class="c-red">*</span>AccessKey（AK）</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="{$qiniu.AccessKey}" placeholder="" id="" name="qiniuAccessKey">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-3">SecretKey（SK）</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="{$qiniu.SecretKey}" placeholder="" id="" name="qiniuAccessSecret">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-3">图片样式接口（选填）</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="{$qiniu.imagestyle}" placeholder="" id="" name="qiniuimgstyleapi">
                </div>
            </div>
        </div>

        <div class="page_bort">
            <input type="button" name="Submit" value="保存" class="fo_btn2 btn-right" id="updateset">
        </div>
    </form>
</div>
{include file="../../include_path/footer.tpl"}
{literal}
    <script>
        var servertype = '{/literal}{$upserver}{literal}';

        if(servertype == '1'){
            $('#local').removeClass('divhide');
        }else if(servertype == '2'){
            $('#OSS').removeClass('divhide');
        }else if(servertype == '3'){
            $('#tenxun').removeClass('divhide');
        }else if(servertype == '4'){
            $('#qiniu').removeClass('divhide');
        }
        

        $('input[name=upserver]').change(function(){
            var server = $(this).val();
            $('div[name=seriver]').addClass('divhide');
            $('#'+server).removeClass('divhide');

        })

        $("#updateset").click(function (){
            var upserver = $('input[name=upserver]:checked').val();
            var checkser = '1';
            if(upserver == 'local'){
                checkser = '1';
            }else if(upserver == 'OSS'){
                checkser = '2';
            }else if(upserver == 'tenxun'){
                checkser = '3';
            }else if(upserver == 'qiniu'){
                checkser = '4';
            }
            if(checkser != servertype){
                confirm(upserver);
            }else{
                subserver(upserver);
            }
        })

        function subserver(upserver){
            var data = {upserver:upserver};

            var uploadImg = $('input[name=uploadImg]').val();
            var uploadImg_domain = $('input[name=uploadImg_domain]').val();

            var OSSBucket = $('input[name=OSSBucket]').val();
            var OSSEndpoint = $('input[name=OSSEndpoint]').val();
            var OSSzidingyi = $('input[name=OSSzidingyi]:checked').val();
            var OSSAccessKey = $('input[name=OSSAccessKey]').val();
            var OSSAccessSecret = $('input[name=OSSAccessSecret]').val();
            var OSSimgstyleapi = $('input[name=OSSimgstyleapi]').val();

            var tenxunBucket = $('input[name=tenxunBucket]').val();
            var tenxunEndpoint = $('input[name=tenxunEndpoint]').val();
            var tenxunzidingyi = $('input[name=tenxunzidingyi]').val();
            var tenxunAccessKey = $('input[name=tenxunAccessKey]').val();
            var tenxunAccessSecret = $('input[name=tenxunAccessSecret]').val();

            var qiniuBucket = $('input[name=qiniuBucket]').val();
            var qiniuEndpoint = $('input[name=qiniuEndpoint]').val();
            var qiniuAccessKey = $('input[name=qiniuAccessKey]').val();
            var qiniuAccessSecret = $('input[name=qiniuAccessSecret]').val();
            var qiniuimgstyleapi = $('input[name=qiniuimgstyleapi]').val();


            $.ajax({
                url: "index.php?module=setupload&action=Index",
                type: 'post',
                dataType: 'json',
                data: {upserver:upserver,uploadImg_domain:uploadImg_domain,uploadImg:uploadImg,OSSBucket:OSSBucket,OSSEndpoint:OSSEndpoint,OSSzidingyi:OSSzidingyi,OSSAccessKey:OSSAccessKey,OSSAccessSecret:OSSAccessSecret,OSSimgstyleapi:OSSimgstyleapi,tenxunBucket:tenxunBucket,tenxunEndpoint:tenxunEndpoint,tenxunzidingyi:tenxunzidingyi,tenxunAccessKey:tenxunAccessKey,tenxunAccessSecret:tenxunAccessSecret,qiniuBucket:qiniuBucket,qiniuEndpoint:qiniuEndpoint,qiniuAccessKey:qiniuAccessKey,qiniuAccessSecret:qiniuAccessSecret,qiniuimgstyleapi:qiniuimgstyleapi},
                success: function (data){
                
                    if(data.code == 1){
                        
                             layer.msg('修改成功！',{time:2000});
                             setTimeout(function(){
                                 location.reload();
                             },1000)
                      
                       
                    }else{
                        
                        layer.msg('修改失败！',{time:2000})
                       
                       
                    }
                    $(".maskNew").remove();
                }
            });
        }

        function confirm (upserver){
            $("body").append(`
                <div class="maskNew">
                    <div class="maskNewContent" style="height: 300px !important;">
                        <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                        <div class="maskTitle">提示</div>
                        <div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
                        <div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
                            切换服务器将导致原来的资源失效,确认要切换么?
                        </div>
                        <div style="text-align:center;margin-top:30px">
                            <button class="closeMask" style="margin-right:20px" onclick=subserver('${upserver}')>确认</button>
                            <button class="closeMask" onclick=closeMask1() >取消</button>
                        </div>
                    </div>
                </div>
            `)
      }

      function closeMask1() {
            $(".maskNew").remove();
        }
    </script>
{/literal}
</body>
</html>