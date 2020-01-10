{include file="../../include_path/header.tpl" sitename="公共头部"}

<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}

<div class="pd-20 page_absolute form-scroll">
	<div class="page_title">编辑公告</div>
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data" style="padding-top: 0; margin-top: 40px;">
        <input type="hidden" name="id" value="{$res->id}">
        <div class="row cl">
            <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;">标题：</label>
            <div class="formControls col-10">
                <input type="text" name="title" class="input-text" value="{$res->title}" style="border: 1px solid #eee;border-radius:5px;width:60%;height: 31px;line-height: 25px;padding-left: 10px;">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;">类型：</label>
            <div class="formControls col-10">
                <select name="telltype" class="select" style="border-radius:5px;width: 180px;height: 31px;vertical-align: middle;">
                    <option value="1" {if $res->type==1}selected{/if}>系统维护</option>
                    <option value="2" {if $res->type==2}selected{/if}>版本升级</option>
                </select>
            </div>
        </div>

        <div class="row cl" id="settimes">
            <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;">时间：</label>
            <div class="formControls col-10">
                开始时间
                <input type="text" name="startdate" id="startdate" value="{$res->startdate}" style="border: 1px solid #eee;border-radius:5px;height: 31px;line-height: 25px;padding-left: 10px;">
                结束时间
                <input type="text" name="enddate" id="enddate" value="{$res->enddate}" style="border: 1px solid #eee;border-radius:5px;height: 31px;line-height: 31px;padding-left: 10px;">
                <span style="color:gray;">(时间设置用来限制用户登录. 在规定时间内，用户无法登录系统)</span>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;">内容：</label>
            <div class="formControls col-10">
                <script id="editor" type="text/plain" style="width:80%;height:300px;" name="detail">{$res->content}</script>
                </div>
            </div>
			
			<div style="height: 70px;"></div>

            <div class="page_bort">
                <input type="button" name="Submit" value="保存" class="fo_btn2 btn-right" onclick="check()">
                <input type="button" name="reset" value="取消" class="fo_btn1 btn-left" onclick="javascript :history.back(-1);">
            </div>
        </form>
    <div class="page_h20" ></div>
< /div>

{include file="../../include_path/footer.tpl"}
{include file="../../include_path/ueditor.tpl" sitename="ueditor插件"}
{literal}
<script>
var aa = $(".pd-20").height();
var bb = $("#form1").height() + 497;
if (aa < bb) {
    $(".page_h20").css("display", "block")
} else {
    $(".page_h20").css("display", "none")
    $(".row_cl").addClass("page_footer")
}
laydate.render({
    elem: '#startdate', //指定元素
    type: 'datetime'
});
laydate.render({
    elem: '#enddate',
    type: 'datetime'
});

$(function () {
    $('.skin-minimal input').iCheck({
        checkboxClass: 'icheckbox-blue',
        radioClass: 'iradio-blue',
        increaseArea: '20%'
    });

    // $list = $("#fileList"),
    //     $btn = $("#btn-star"), // 开始上传的id名称
    //     state = "pending",
    //     uploader;

    // var uploader = WebUploader.create({
    //     auto: true,
    //     swf: 'style/lib/webuploader/0.1.5/Uploader.swf',

    //     // 文件接收服务端。
    //     server: 'http://lib.h-ui.net/webuploader/0.1.5/server/fileupload.php',

    //     // 选择文件的按钮。可选。
    //     // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    //     pick: '#filePicker',

    //     // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
    //     resize: false,
    //     // 只允许选择图片文件。
    //     accept: {
    //         title: 'Images',
    //         extensions: 'gif,jpg,jpeg,bmp,png',
    //         mimeTypes: 'image/*'
    //     }
    // });
    // uploader.on('fileQueued', function (file) {
    //     var $li = $(
    //         '<div id="' + file.id + '" class="item">' +
    //         '<div class="pic-box"><img></div>' +
    //         '<div class="info">' + file.name + '</div>' +
    //         '<p class="state">等待上传...</p>' +
    //         '</div>'
    //         ),
    //         $img = $li.find('img');
    //     $list.append($li);

    //     // 创建缩略图
    //     // 如果为非图片文件，可以不用调用此方法。
    //     // thumbnailWidth x thumbnailHeight 为 100 x 100
    //     uploader.makeThumb(file, function (error, src) {
    //         if (error) {
    //             $img.replaceWith('<span>不能预览</span>');
    //             return;
    //         }

    //         $img.attr('src', src);
    //     }, thumbnailWidth, thumbnailHeight);
    // });
    // // 文件上传过程中创建进度条实时显示。
    // uploader.on('uploadProgress', function (file, percentage) {
    //     var $li = $('#' + file.id),
    //         $percent = $li.find('.progress-box .sr-only');

    //     // 避免重复创建
    //     if (!$percent.length) {
    //         $percent = $('<div class="progress-box"><span class="progress-bar radius"><span class="sr-only" style="width:0%"></span></span></div>').appendTo($li).find('.sr-only');
    //     }
    //     $li.find(".state").text("上传中");
    //     $percent.css('width', percentage * 100 + '%');
    // });

    // // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    // uploader.on('uploadSuccess', function (file) {
    //     $('#' + file.id).addClass('upload-state-success').find(".state").text("已上传");
    // });

    // // 文件上传失败，显示上传出错。
    // uploader.on('uploadError', function (file) {
    //     $('#' + file.id).addClass('upload-state-error').find(".state").text("上传出错");
    // });

    // // 完成上传完了，成功或者失败，先删除进度条。
    // uploader.on('uploadComplete', function (file) {
    //     $('#' + file.id).find('.progress-box').fadeOut();
    // });
    // uploader.on('all', function (type) {
    //     if (type === 'startUpload') {
    //         state = 'uploading';
    //     } else if (type === 'stopUpload') {
    //         state = 'paused';
    //     } else if (type === 'uploadFinished') {
    //         state = 'done';
    //     }

    //     if (state === 'uploading') {
    //         $btn.text('暂停上传');
    //     } else {
    //         $btn.text('开始上传');
    //     }
    // });

    // $btn.on('click', function () {
    //     if (state === 'uploading') {
    //         uploader.stop();
    //     } else {
    //         uploader.upload();
    //     }
    // });


    var ue = UE.getEditor('editor');
    var telltype = "{/literal}{$res->type}{literal}";
    if(telltype == 2){
        $("#settimes").hide();
    }
});

$("select[name=telltype]").change(function (){
    var val = $(this).children("option:selected").val();
    var settime = $("#settimes");
    if(val == 2){
      settime.hide();
    }else{
      settime.show();  
    }
})

function check() {
    $.ajax({
        cache: true,
        type: "POST",
        dataType: "json",
        url: 'index.php?module=systemtell&action=modify',
        data: $('#form1').serialize(),// 你的formid
        async: true,
        success: function (data) {
            layer.msg(data.status, {time: 2000});
            if (data.suc) {
                location.href = "index.php?module=systemtell";
            }
        }
    });
}
</script>
{/literal}
</body>
</html>