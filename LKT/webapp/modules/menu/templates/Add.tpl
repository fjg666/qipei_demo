{include file="../../include_path/header.tpl" sitename="DIY头部"}

{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
{literal}
<style type="text/css">
.formTitleSD{
    font-weight: Bold;
    font-size: 16px;
    border-bottom: 2px solid #E9ECEF;
    height: 58px;
}
.form_new_r .ra1 label{
    width: 90px !important;
}
.inputC1:checked + label::before{
    width: 14px;
    height: 14px;
    top: 11px;
    left: 0px;
}
.ra1{
    margin-right: 10px;
}
</style>
{/literal}
<body style=" background: #edf1f5;">
{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute form-scroll">
	<div class="page_title">添加菜单</div>
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data" style="padding: 0px;">
        <input type="hidden" name="val" class="val" value="{$cid}">
        <input type="hidden" name="level" class="level" value="{$level}">
        <div class="formDivSD">
            <div class="formContentSD">
                <div class="formListSD" style="margin: 2px 0px 12px;">
                    <div class="formTextSD"><span>菜单名称：</span></div>
                    <div class="formInputSD">
                        <input type="text" class="input-text" value="" placeholder="" id="" name="title" style="width: 380px;">
                    </div>
                </div>
                <div class="formListSD" style="margin: 2px 0px 12px;">
                    <div class="formTextSD"><span>归类：</span></div>
                    <div class="formInputSD" >
                        <select name="select_1" class="select" onchange="one()" id="select_1" style="width: 100px;">
                            <option selected="true" value="0">一级菜单</option>
                            {$list}
                        </select>
                        <select name="select_2" class="select" onchange="two()" id="select_2" style="width: 100px;">
                            <option selected="true" value="0">二级菜单</option>
                            {$list1}
                        </select>
                        <select name="select_3" class="select" onchange="three()" id="select_3" style="width: 100px;">
                            <option selected="true" value="0">三级菜单</option>
                            {$list2}
                        </select>
                    </div>
                </div>
                <div class="formListSD"  id="url" style="display:none;margin: 2px 0px 12px;">
                    <div class="formTextSD"><span>路径：</span></div>
                    <div class="formInputSD">
                        <input type="text" class="input-text" value="" placeholder="" id="" name="url">
                    </div>
                </div>
                <div class="formListSD" id="tubiao" style="margin: 2px 0px 12px;">
                    <div class="formTextSD"><span>图标：</span></div>
                    <div class="formInputSD">
                        <div class="upload-group">
                            <div class="input-group">
                                <input class="form-control file-input" name="image" value="" style="width: 430px;">
                                <span class="input-group-btn">
                                    <a class="btn btn-secondary upload-file" href="javascript:" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="上传文件">
                                        <span class="iconfont icon-cloudupload"></span>
                                    </a>
                                </span>
                                <span class="input-group-btn">
                                    <a class="btn btn-secondary delete-file" href="javascript:" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="删除文件">
                                        <span class="iconfont icon-close"></span>
                                    </a>
                                </span>
                            </div>
                            <div class="upload-preview text-center upload-preview">
                                <span class="upload-preview-tip">19×19</span>
                                <img class="upload-preview-img" src="" style="width:100px;height:100px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="formListSD" id="tubiao1" style="margin: 2px 0px 12px;">
                    <div class="formTextSD"><span>图标：</span></div>
                    <div class="formInputSD">
                        <div class="upload-group">
                            <div class="input-group">
                                <input class="form-control file-input" name="image1" value="" style="width: 430px;">
                                <span class="input-group-btn">
                                    <a class="btn btn-secondary upload-file" href="javascript:" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="上传文件">
                                        <span class="iconfont icon-cloudupload"></span>
                                    </a>
                                </span>
                                <span class="input-group-btn">
                                    <a class="btn btn-secondary delete-file" href="javascript:" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="删除文件">
                                        <span class="iconfont icon-close"></span>
                                    </a>
                                </span>
                            </div>
                            <div class="upload-preview text-center upload-preview">
                                <span class="upload-preview-tip">19×19</span>
                                <img class="upload-preview-img" src="" style="width:100px;height:100px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="formListSD" style="margin: 2px 0px 12px;">
                    <div class="formTextSD"><span>类型：</span></div>
                    <select name="type" class="select_type"  id="type" style="width: 200px;">
                        <option value="">请选择商品分类</option>
                        {$type}
                    </select>
                </div>
                <div class="formListSD" style="margin: 2px 0px 12px;">
                    <div class="formTextSD"><span>排序：</span></div>
                    <div class="formInputSD">
                        <input type="text" class="input-text" value="100" placeholder="" id="" name="sort">
                    </div>
                </div>
            </div>
        </div>
		<div style="height: 70px;"></div>
        <div class="page_h10 page_bort">
            <input type="button" name="Submit" value="保存" class="fo_btn2 btn-right" onclick="check()">
            <input type="button" name="reset" value="取消" class="fo_btn1 btn-left" onclick="javascript :history.back(-1);">
        </div>
    </form>
    <div class="page_h20"></div>
</div>

{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}

{literal}
<script>
$("select.select").change(function () {
    var s_id = $(this).val();
    if (s_id == 0) {
        document.getElementById('tubiao').style.display = '';
        document.getElementById('tubiao1').style.display = '';
        document.getElementById('url').style.display = 'none';

    } else {
        document.getElementById('tubiao').style.display = 'none';
        document.getElementById('tubiao1').style.display = 'none';
        document.getElementById('url').style.display = '';
    }
});

function one() {
    var dropElement1 = document.getElementById("select_1");
    var dropElement2 = document.getElementById("select_2");
    var dropElement3 = document.getElementById("select_3");
    var v = dropElement1.value;

    RemoveDropDownList(dropElement2);
    RemoveDropDownList(dropElement3);

    if (v != 0) {
        $('.val').val(v);
        $('.level').val(1);
        $.ajax({
            type: "POST",
            url: 'index.php?module=menu&action=Ajax&v=' + v,
            data: "",
            success: function (msg) {
                obj = JSON.parse(msg);
                $("#select_2").append(obj);
            }
        });
    } else {
        $('.val').val('');
        $('.level').val('');
    }
}

function two() {
    var dropElement1 = document.getElementById("select_1");
    var dropElement2 = document.getElementById("select_2");
    var dropElement3 = document.getElementById("select_3");
    var v = dropElement2.value;
    RemoveDropDownList(dropElement3);
    if (v != 0) {
        $('.val').val(v);
        $('.level').val(2);
        $.ajax({
            type: "POST",
            url: 'index.php?module=menu&action=Ajax&v=' + v,
            data: "",
            success: function (msg) {
                obj = JSON.parse(msg);
                $("#select_3").append(obj);
            }
        });
    } else {
        var dropElement1 = document.getElementById("select_1");
        var v1 = dropElement1.value;
        $('.val').val(v1);
        $('.level').val(1);
    }
}

function three() {
    var dropElement3 = document.getElementById("select_3");
    var v = dropElement3.value;
    if (v != 0) {
        $('.val').val(v);
        $('.level').val(3);
    } else {
        var dropElement2 = document.getElementById("select_2");
        var v1 = dropElement2.value;
        $('.val').val(v1);
        $('.level').val(2);
    }

}

function RemoveDropDownList(obj) {
    if (obj) {
        var len = obj.options.length;
        if (len > 0) {
            //alert(len);
            for (var i = len; i >= 1; i--) {
                obj.remove(i);
            }
        }
    }
}

document.onkeydown = function (e) {
    if (!e) e = window.event;
    if ((e.keyCode || e.which) == 13) {
        $("[name=Submit]").click();
    }
}
function check() {
    var gyscompany = $('input[name=gyscompany').val();
    var is_hexiao = $('#is_hexiao').val();
    if(is_hexiao == 1 && gyscompany == ''){
        layer.msg('请填写供应商信息!');
        return false;
    }
    $.ajax({
        cache: true,
        type: "POST",
        dataType:"json",
        url:'index.php?module=menu&action=Add',
        data:$('#form1').serialize(),// 你的formid
        async: true,
        success: function(data) {
            layer.msg(data.status,{time:2000});
            if(data.suc){
                location.href="index.php?module=menu";
            }
        }
    });
}
</script>
{/literal}
</body>
</html>