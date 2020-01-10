
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />

<link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
{literal}
<style type="text/css">
</style>
<script type="text/javascript">
document.onkeydown = function (e) {
	            if (!e) e = window.event;
	            if ((e.keyCode || e.which) == 13) {
	                $("[name=Submit]").click();
	            }
        	}
function check() {
    $.ajax({
		cache: true,
		type: "POST",
		dataType:"json",
		url:'index.php?module=bgcolor&action=modify',
		data:$('#form1').serialize(),// 你的formid
		async: true,
		success: function(data) {
			console.log(data)
			layer.msg(data.status,{time:2000});
			if(data.suc){
				location.href="index.php?module=bgcolor";
			}
		}
	});
}
</script>
{/literal}
<title>修改颜色</title>
</head>
<body>

{include file="../../include_path/nav.tpl" sitename="面包屑"}

<div class="pd-20 page_absolute">
    <form name="form1" id="form1" class="form form-horizontal" method="post"  enctype="multipart/form-data" >
        <input type="hidden" name="id" value="{$id}" />
        <input type="hidden" name="editable" value="true" />
        <div class="row cl">
            <label class="form-label col-5"><span class="c-red"></span>颜色名称{$id}：</label>
            <div class="formControls col-2">
                <input type="text" class="input-text" style="width: 450px;" name="color_name" value="{$color_name}" placeholder="" >
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-5"><span class="c-red"></span>颜色代码：</label>
            <div class="formControls col-2">
                <input type="text" class="input-text" style="width: 450px;" value="{$color}" placeholder="" name="color">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-5">排序号：</label>
            <div class="formControls col-2">
                <input type="text" class="input-text" value="{$sort}" placeholder="" name="sort">
            </div>
        </div>
        <div class="row cl page_footer" >
            <div class="" >
                
                <button class="btn btn-secondary radius ta_btn4" type="reset" name="reset">重置</button>
                <input class="btn btn-primary radius submit1 ta_btn3" onclick="check()" type="button" name="Submit" value="提交">
            </div>
        </div>
    </form>
</div>

<!--<script type="text/javascript" src="modpub/js/check.js" > </script>-->

<script type="text/javascript" src="style/js/jquery.min.js"></script> 
<script type="text/javascript" src="style/js/layer/layer.js"></script> 
<!--<script type="text/javascript" src="style/lib/My97DatePicker/WdatePicker.js"></script> 
<script type="text/javascript" src="style/lib/icheck/jquery.icheck.min.js"></script> 
<script type="text/javascript" src="style/lib/Validform/5.3.2/Validform.min.js"></script> 
<script type="text/javascript" src="style/lib/webuploader/0.1.5/webuploader.min.js"></script> 
<script type="text/javascript" src="style/lib/ueditor/1.4.3/ueditor.config.js"></script> 
<script type="text/javascript" src="style/lib/ueditor/1.4.3/ueditor.all.min.js"> </script> 
<script type="text/javascript" src="style/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script> 
<script type="text/javascript" src="style/js/H-ui.js"></script> 
<script type="text/javascript" src="style/js/H-ui.admin.js"></script> -->

{literal}
<script type="text/javascript">
$(function(){
    $('.skin-minimal input').iCheck({
        checkboxClass: 'icheckbox-blue',
        radioClass: 'iradio-blue',
        increaseArea: '20%'
    });
    
    $list = $("#fileList"),
    $btn = $("#btn-star"), // 开始上传的id名称
    state = "pending",
    uploader;

    var uploader = WebUploader.create({
        auto: true,
        swf: 'style/lib/webuploader/0.1.5/Uploader.swf',
    
        // 文件接收服务端。
        server: 'http://lib.h-ui.net/webuploader/0.1.5/server/fileupload.php',
    
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker',
    
        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        resize: false,
        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });
    uploader.on( 'fileQueued', function( file ) {
        var $li = $(
            '<div id="' + file.id + '" class="item">' +
                '<div class="pic-box"><img></div>'+
                '<div class="info">' + file.name + '</div>' +
                '<p class="state">等待上传...</p>'+
            '</div>'
        ),
        $img = $li.find('img');
        $list.append( $li );
    
        // 创建缩略图
        // 如果为非图片文件，可以不用调用此方法。
        // thumbnailWidth x thumbnailHeight 为 100 x 100
        uploader.makeThumb( file, function( error, src ) {
            if ( error ) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }
    
            $img.attr( 'src', src );
        }, thumbnailWidth, thumbnailHeight );
    });
    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
        var $li = $( '#'+file.id ),
            $percent = $li.find('.progress-box .sr-only');
    
        // 避免重复创建
        if ( !$percent.length ) {
            $percent = $('<div class="progress-box"><span class="progress-bar radius"><span class="sr-only" style="width:0%"></span></span></div>').appendTo( $li ).find('.sr-only');
        }
        $li.find(".state").text("上传中");
        $percent.css( 'width', percentage * 100 + '%' );
    });
    
    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on( 'uploadSuccess', function( file ) {
        $( '#'+file.id ).addClass('upload-state-success').find(".state").text("已上传");
    });
    
    // 文件上传失败，显示上传出错。
    uploader.on( 'uploadError', function( file ) {
        $( '#'+file.id ).addClass('upload-state-error').find(".state").text("上传出错");
    });
    
    // 完成上传完了，成功或者失败，先删除进度条。
    uploader.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress-box').fadeOut();
    });
    uploader.on('all', function (type) {
        if (type === 'startUpload') {
            state = 'uploading';
        } else if (type === 'stopUpload') {
            state = 'paused';
        } else if (type === 'uploadFinished') {
            state = 'done';
        }

        if (state === 'uploading') {
            $btn.text('暂停上传');
        } else {
            $btn.text('开始上传');
        }
    });

    $btn.on('click', function () {
        if (state === 'uploading') {
            uploader.stop();
        } else {
            uploader.upload();
        }
    });

    
    
    var ue = UE.getEditor('editor');
    
});

function mobanxuanze(){
    
}
</script>
{/literal}
</body>
</html>