{include file="../../include_path/header.tpl" sitename="公共头部"}
{literal}
<style type="text/css">
/*初始化样式*/
body,h1,h2,h3,h4,h5,ul,li,a,div,p,span,table,tr,td,img{margin: 0;padding: 0;}
ul{padding: 0;margin: 0;}
li{list-style: none;}
a{text-decoration: none;}
img{outline: none;border: 0;}
body{font-family: "Microsoft Yahei";}
/*清除浮动*/
.clearfix:before,
.clearfix:after{content: " ";display: table;}
.clearfix:after{clear: both;}
.clearfix{zoom: 1;}
/*浮动*/
.pull-right{float: right !important;}
.pull-left{float: left !important;}
/*----------------------------------------------------------------------------------------------------------*/
.content{float: left;}
pre{margin: 0 !important;}
.commentAll{padding: 20px;background-color: #fff;}
.plBtn{width: 112px;height: 36px;line-height: 36px;background-color:  #2890FF!important;text-align: center;
	display: block;color: #FFFFFF;font-size: 14px;border-radius: 2px;margin-right: 2px;
	position: absolute;bottom: 20px;right: 60px;}
.plBtn:hover{background-color: #2481e5!important;}

/*----------评论区域 begin----------*/
.comment-show{margin-top: 20px;}
.comment-show-con {
    width: 100%;
}
.comment-show-con-img {
    width: 36px;
    height: 36px;
    overflow: hidden;
    margin-top: 5px;
}
.comment-show-con-img img{
    width: 36px;
    height: 36px;
    overflow: hidden;
    /*margin-top: 5px;*/
}
.comment-show-con-list {
    width: 94%;
    margin-left:10px;
}
.pl-text {
    width: 100%;
    margin-top: 7px;
    word-wrap: break-word;
    overflow: hidden;
}
.date-dz {
    width: 100%;
    float: left;
}
.hf-list-con {
    float: left;
    width: 100%;
    background-color: #eaeaec;
    margin-top: 7px;
}
.comment-size-name {
    font-size: 12px;
    color: #8b8b8b;
}
.date-dz-left {
    font-size: 12px;
    color: #8b8b8b;
    display: block;
    padding-top: 18px;
}
.comment-time, .comment-pl-block {
    padding-top: 7px;
}
.comment-pl-block {
    margin-top: 0;
}
.date-dz-right {
    display: block;
    padding-top: 6px;
    padding-right: 18px;
    position: relative;
    overflow: hidden;
}
.date-dz-line{
    font-size: 12px;
    color: #8b8b8b;
}
.date-dz-line {
    display: block;
    padding: 0 20px;
}
pre {
    white-space: pre;
    white-space: pre-wrap;
    word-wrap: break-word;
}

textarea{
    outline: 0;
    margin: 0;
    border: none;
    padding: 0;
    *padding-bottom: 0!important;
}

textarea { margin-bottom: 25px }
textarea{
    line-height: 1.7;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 100%;
    padding: 10px 0px 10px 1%;
    border: 1px solid #c6c8ce;
    width: 99%;
    -webkit-appearance: none;
    background: #fff;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    -moz-background-clip: padding;
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    -webkit-box-shadow: 0 0 8px rgba(182, 195, 214, .6) inset, 0 1px 1px #fff;
    -moz-box-shadow: 0 0 8px rgba(182, 195, 214, .6) inset, 0 1px 1px #fff;
    box-shadow: 0 0 8px rgba(182, 195, 214, .6) inset, 0 1px 1px #fff;
    -webkit-transition-duration: 300ms;
    -moz-transition-duration: 300ms;
    -o-transition-duration: 300ms;
    -ms-transition-duration: 300ms;
    transition-duration: 300ms;
    -webkit-transition-easing: ease-in-out;
    -moz-transition-easing: ease-in-out;
    -o-transition-easing: ease-in-out;
    -ms-transition-easing: ease-in-out;
    transition-easing: ease-in-out;
    -webkit-transition-property: border-color, -webkit-box-shadow;
    -webkit-transition-property: border-color, box-shadow;
    -moz-transition-property: border-color, -moz-box-shadow;
    -moz-transition-property: border-color, box-shadow;
    -o-transition-property: border-color, box-shadow;
    -ms-transition-property: border-color, box-shadow;
    transition-property: border-color, box-shadow;
}
@media only screen and (-webkit-min-device-pixel-ratio:1.25), (min-resolution:120dpi) {
    html {
        background-size: 51px auto;
    }
}
@font-face {font-family: "iconfont";
  src: url('iconfont.eot?t=1529402722179'); /* IE9*/
  src: url('iconfont.eot?t=1529402722179#iefix') format('embedded-opentype'), /* IE6-IE8 */
  url('data:application/x-font-woff;charset=utf-8;base64,d09GRgABAAAAAAjcAAsAAAAADowAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAABHU1VCAAABCAAAADMAAABCsP6z7U9TLzIAAAE8AAAAQwAAAFZW7kl9Y21hcAAAAYAAAACXAAACCs+0bYlnbHlmAAACGAAABIMAAAeQeSY8oWhlYWQAAAacAAAALwAAADYRyjDIaGhlYQAABswAAAAgAAAAJAfsA5tobXR4AAAG7AAAABgAAAAkJAYAAGxvY2EAAAcEAAAAFAAAABQHbAlcbWF4cAAABxgAAAAfAAAAIAEaAHluYW1lAAAHOAAAAUUAAAJtPlT+fXBvc3QAAAiAAAAAWQAAAHKbl5QSeJxjYGRgYOBikGPQYWB0cfMJYeBgYGGAAJAMY05meiJQDMoDyrGAaQ4gZoOIAgCKIwNPAHicY2BkYWScwMDKwMHUyXSGgYGhH0IzvmYwYuRgYGBiYGVmwAoC0lxTGBwYKp43Mzf8b2CIYW5naAAKM4LkAN2mDAEAeJzFkTEOgzAMRb8hUKvqUPUcHTkUY0cmhMQVOvV+iY9Bf2KWqMz0Ry9SfmQn+gbQAWjJkwRAPhBkvelK8Vtcix8w8vzAnU6DKYaoSdNgsy22bhvvjrxawvp6Za9hx479e1ygNPqfutMk/3u61q3sr/3EVDDt8IsxOEwOUZ08xaROnmoanDxVmx0mDFscZg1bHegXKTwqZQB4nLVUXWgcVRS+Z2Zn7iTZ2XRnZmd/ZzYz05nZkHaT7M7ObohObWwMlShJStTQtCGFttrWIgrtS9ENUqvQH0UKvklbwRcfBR8stWiCIKit4EPiQxH7ICKI4FvJ1DO7SZpAnyIulzPf7Nxz7vm+c84lHCEPf2VvshkikxIZJPvIBCHA94GZYDQwXK/M9EHK4FJpJcG6lmtQyyyzT0La5BW14ntOmqd8NyRAh6pR8d0y40LNC5hhqKgaQDafOyDZBYl9Hzozrn4+fJa5DqmiVegOdof7d+1RKj2ycDYuSVlJuijwHCcwTKw7Aa+m1Q6uo5MPP+G6c6mbxV6mCPGsmxufEXvy0vy73mnNTncANJsg53sSn+5J5pK4zuVUWcrSHaKQyYnWTgXO3u/KyHHN+Y3gL4ZcmzHCNkmcqKRIdkVMCVVJ2id1h7iyDgpvOp5fN9YR6/lIS1V4yygDQ1bCexwHxsoKGBwX3lu5W7DtIdvWwsNaC0jZJHwuZbLJcFzKsM1oy2aX8FuwG47TsGHtGR7FzVYWMoRv5SayCyRDbNJPhrAOk5hfGVzHpAmgvJLWIa1W6gHUfc8FzBezxtyRgRwVIipI1Q6gjdIcumFpdPDRo6Kic4Ch3EH2vntpdu7u3Owlt1TaBMPepfABZsotLQKH5B4s/pizrJpl5cMjawCOjV0bG93Ns0mZls5cOFOicpLld48yY7OXo2CXZ+fuzG2Cqycx3OJ6uEUMz+yIAtUsAMuzcMEdyzKHBUVkhVqjURNYURGGzfVavROLsxdIF6miFqcIsVVsLxRCrfuq7OyMQAAtURIMylRGXRxUqvWP35KJoY7ZHQnIK8VIQbWyJ5LQ9/ojDTm3Hsn22A3M1z1a/tQ/J3O6fvCnPxbCLz5EdPz3Ey+9LknDF7/8/rM6tni8qgyL/b1XDs//MHfwvFUZ/5mXqaZTKUF1nSYkqmtUFqmm0fCqrvOizKOVxciK+DHCN7qqshdrKNV4f4zpfaPwQspLBEJj8PqRY99cfSZ5+sVjf72i67kTf7526D2n1NHXd3XuA7DP0Sio2D5sIx4eNr1x4taPa73PPmTfQj2jDgu29j7rV7DlE2CWwfPtRy8BQII1caidAKIeSqOsAc46PFxu9/XycnsU6knHlGUzMuHbLWw5hgIyY3cPTRw6eniisYPtyqhcvjl1oJmPqZk4+ya6LW8KE37XqRiuIctoOh/B8O+ByaDY88TkgJgSuuJT8wDzU2KXkCIUOd1mb7NPYb90kE68wYqkQZ5DZpYO7ZHgNhCLM9TOvwwyDobpRqPltfqk0uoZhfI2blLS1bWRURHVygATA5Av5XHBlXW0cGuV41Zvtex+b2T0o9Gnjxc0rfDyIxgujcxwwgCFWO35WgzogMDNwC9K5J1X2g+YXI+BdjWoalsjtOFXzPReCsA7lYrDA9C909F8PJ77vv/A3TV4mlLThl+vOdukfCO8g5lSQNKwHaofo0pRgAH6P9TWtXi8HUwHL0GLT7W3e9slurWsI1jpbZV2c1WZqM7/AuFqe3YAeJxjYGRgYADimnCGPfH8Nl8ZuFkYQOC637ckBP2/gYWXuR3I5WBgAokCACHRCl4AeJxjYGRgYG7438AQwyLLwPD/CwsvA1AEBXACAHTJBI94nGNhYGBgfsnAwAKkWWShNBoGACGmASoAAAAAAHYAxAFMAfQCXgLcA0wDyHicY2BkYGDgZMhlYGcAASYg5gJCBob/YD4DABSDAZQAeJxlj01OwzAQhV/6B6QSqqhgh+QFYgEo/RGrblhUavdddN+mTpsqiSPHrdQDcB6OwAk4AtyAO/BIJ5s2lsffvHljTwDc4Acejt8t95E9XDI7cg0XuBeuU38QbpBfhJto41W4Rf1N2MczpsJtdGF5g9e4YvaEd2EPHXwI13CNT+E69S/hBvlbuIk7/Aq30PHqwj7mXle4jUcv9sdWL5xeqeVBxaHJIpM5v4KZXu+Sha3S6pxrW8QmU4OgX0lTnWlb3VPs10PnIhVZk6oJqzpJjMqt2erQBRvn8lGvF4kehCblWGP+tsYCjnEFhSUOjDFCGGSIyujoO1Vm9K+xQ8Jee1Y9zed0WxTU/3OFAQL0z1xTurLSeTpPgT1fG1J1dCtuy56UNJFezUkSskJe1rZUQuoBNmVXjhF6XNGJPyhnSP8ACVpuyAAAAHicbchBDkAwEEbh+UtVLdzEoUrKSExHaEKcXhpb3+Yljwx9OvrnYVChhkUDhxYeHeH2D2ta9jUt/ag5qwyTisSU3cShbMdBS+186JUqiWxPWbdI9ALFBBXJAAAA') format('woff'),
  url('iconfont.ttf?t=1529402722179') format('truetype'), /* chrome, firefox, opera, Safari, Android, iOS 4.2+*/
  url('iconfont.svg?t=1529402722179#iconfont') format('svg'); /* iOS 4.1- */
}

.iconfont {
  font-family:"iconfont" !important;
  font-size:16px;
  font-style:normal;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

.icon-zhongping:before { content: "\e504"; }

.icon-haoping:before { content: "\e608"; }

.icon-frown:before { content: "\e77e"; }

.tag {
    position:relative;
    background-color:#eee;
    margin:14px 0px 0px 0;
    border-radius:4px;
    font-size:12px;
    padding:10px;
    color:#666;
}
.noe {
    display:block;
    border-width:10px;
    position:absolute;
    left:10px;
    top:-20px;
    border-style:solid dashed dashed;
    border-color:transparent transparent #eee transparent;
    font-size:0;
    line-height:0;
}
.closeI{
    display: inline-block;
    width: 11px;
    height: 4px;
    position: relative;
    background-color: #fff;
    top: -3px;
    left: 0px;
}
.closeSpan{
    right:2px;
    top: -6px;
}
.page_absolute{position: absolute;top:56px;right: 16px;left: 16px;bottom: 16px;background-color: white;padding: 0!important;}
.xian_h{clear: both;height: 24px;border-bottom: 1px solid #ddd;}
.chooseImg{background-color: #fff;border:1px solid #2890FF!important;color: #2890FF!important;height: 36px;display: flex;align-items: center; 
justify-content: center;border-radius: 2px;}
</style>
{/literal}
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<form name="form1" id="form1" enctype="multipart/form-data" method="post" style="background-color: transparent;">
    <input type="hidden" name="id" class="cid" value="{$cid}">
    <div class="commentAll page_absolute" style="padding:0 24px 24px!important;">
    	<!--回复区域 begin-->
        <div class="comment-show">
            <div class="comment-show-con clearfix">
                <div class="comment-show-con-img pull-left"><img src="{$headimgurl}" alt=""></div>
                <div class="comment-show-con-list pull-left clearfix" style="margin-top: 0;">
                    <div class="pl-text clearfix"  style="margin-top: 0;">
                        <span class="comment-size-name" >{$add_time} </span>
                    </div>
                    <div class="date-dz" >
                        <span class="date-dz-left pull-left comment-time" style="padding-top: 0;">{$user_name}:&nbsp;{$content}</span>
                        <div class="date-dz-right pull-right comment-pl-block">
                            <span class="pull-left date-dz-line">
    {if $CommentType == 'GOOD'}<span class="icon iconfont icon-haoping" style="color: #43CD80;"></span>{elseif $CommentType == 'NOTBAD'}<span style="color: #EEAD0E;" class="icon iconfont icon-zhongping"></span>{else}<span style="color: #EE4000;" class="icon iconfont icon-frown"></span>{/if}
                            </span>
                        </div>

                        
                    </div>

                    <div class="hf-list-con"></div>
                </div>
            </div>
            <div class="tag">
                <div class="noe"></div>
                掌柜回复：{$rec->content}
            </div>
        </div>
        <!--回复区域 end-->
    	
    	<div class="xian_h"></div>
        <!--评论区域 begin-->
        <div class="reviewArea clearfix">
            <div style="width: 100%;margin-top: 10px;">
            	<textarea class="content comment-input" name="comment_input" placeholder="请输入需要修改的内容" >{$content}</textarea>
            	<span class="plBtn" style="cursor: pointer;">修改评论</span>
            	<div class="clearfix" style="margin-top: 0;"></div>
            </div>
            <span>
         		 评论类型
    		      <lable>
    		        <i class='input_style radio_bg'><input type="radio" name="comment-type" {if $CommentType == 'GOOD'}checked="checked"{/if} value="5"></i>
    		        <span class="icon iconfont icon-haoping" style="color: #43CD80;"></span>好评 &nbsp;   &nbsp; 
    		      </lable>
    		      <lable>
    		        <i class='input_style radio_bg'><input type="radio" name="comment-type" {if $CommentType == 'NOTBAD'}checked="checked"{/if} value="3"></i>
    		        <span style="color: #EEAD0E;" class="icon iconfont icon-zhongping"></span>中评   &nbsp;  &nbsp; 
    		      </lable>
    		      <lable>
    		        <i class='input_style radio_bg'><input type="radio" name="comment-type" {if $CommentType == 'BAD'}checked="checked"{/if} value="1"></i>
    		       <span style="color: #EE4000;" class="icon iconfont icon-frown"></span>差评   &nbsp; 
    		      </lable>
        	</span>
        </div>

        <!-- 回复图片 -->
        <div class="reviewArea clearfix">
            <span>
                 回复图片:
                  {foreach from=$images item=item key=key name=f1}
                    <div style="display: inline-block;position: relative;">
                        <img id="thumb_url2{$key}" class="comment-show-con-img " src='{$item->comments_url}'>
                        <span class="closeSpan" style=""><i class="closeI"></i></span>
                        <input type="hidden" name="imgurls[]" value="{$item->comments_url}">
                    </div>
                  {/foreach}
            </span>
            <div id="btn486" style="display: inline-block;position: relative;">
                <button class="btn btn-success chooseImg" id="image2" type="button">选择图片</button>
            </div>
        </div>
    </div>
</form>
{include file="../../include_path/footer.tpl"}

<script type="text/javascript" src="style/js/jquery.js"></script>
<script type="text/javascript" src="style/lib/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" src="style/lib/ueditor/1.4.3/ueditor.all.min.js"> </script>
<script type="text/javascript" src="style/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
<!-- 新增编辑器引入文件 -->
<link rel="stylesheet" href="style/kindeditor/themes/default/default.css" />
<script src="style/kindeditor/kindeditor-min.js"></script>
<script src="style/kindeditor/lang/zh_CN.js"></script>

{literal}
<script type="text/javascript">
$(".closeSpan").each(
    function(){
        $(this).click(function(){
            $(this).parent().remove();
        })
    }
);

KindEditor.ready(function(K) {
    var editor = K.editor({
        allowFileManager : true,
        uploadJson : "index.php?module=system&action=UploadImg", //上传功能
        fileManagerJson : 'kindeditor/php/file_manager_json.php', //网络空间
    });
    //上传背景图片
    K('#image2').click(function () {
        if($("#up5").find('img').length<5){
            editor.loadPlugin('image', function () {
            editor.plugin.imageDialog({
                showRemote : false, //网络图片不开启
                //showLocal : false, //不开启本地图片上传
                imageUrl: K('#imgurls').val(),
                clickFn: function (url, title, width, height, border, align) {
                    let a= $("#up5").find('img').length
                    $("#up5").find("#thumb_url2").remove()
                    $("#btn486").before(`
                        <div style="display:inline-block;position:relative;">
                        <img id="thumb_url2${a}" class='comment-show-con-img' src='${url}'>
                        <span class="closeSpan" style=""><i class="closeI"></i></span>
                        <input type="hidden" name="imgurls[]" value="${url}">
                        </div>
                    `)
                    editor.hideDialog();
                    $(".closeSpan").each(function(){
                        $(this).click(function(){
                            $(this).parent().remove();
                        })
                    })
                }
                });
            });
        }
        else{
            layer.msg("最多上传5张图片!")
        }
        
    });
});

$(".plBtn").click( function () { 
    var comment_input = $(".comment-input").val(),
    comment_type = $('input[name="comment-type"]:checked').val(),
    id = $(".cid").val();
    if(comment_input.length > 0 && comment_type.length > 0){
        $.ajax({
            type: "POST",
            url: "index.php?module=comments&action=Modify&id="+id,
            data:$('#form1').serialize(),// 你的formid
            success: function(res){
                if(res == 1){
                    layer.msg('修改成功!');
                    intervalId = setInterval(function () {
                    clearInterval(intervalId);
                    location.href=history.go(-1);location.reload();
                    }, 2000);
                    location.href='index.php?module=comments';
                }else{
                    layer.msg('修改失败!');
                }
            }
        });
    }else{
        layer.msg('请填写完整!');
    }
});

</script>
{/literal}
</body>
</html>