{include file="../../include_path/header.tpl" sitename="DIY头部"}{include file="../../include_path/software_head.tpl" sitename="DIY头部"}<body class="body_bgcolor">{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}{include file="../../include_path/nav.tpl" sitename="面包屑"}<div class="panel-body pd-20">    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data">        <div class="row cl">            <label class="form-label col-4"><span class="c-red">*</span>图片：</label>            <div class="col-sm-6">                <div class="upload-group">                    <div class="input-group">                        <input class="form-control file-input" name="pic_url" value="">                        <span class="input-group-btn">                            <a class="btn btn-secondary upload-file" href="javascript:" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="上传文件">                                <span class="iconfont icon-cloudupload"></span>                            </a>                        </span>                        <span class="input-group-btn">                            <a class="btn btn-secondary select-file" href="javascript:" data-toggle="tooltip"                               data-placement="bottom" title="" data-original-title="从文件库选择">                                <span class="iconfont icon-viewmodule"></span>                            </a>                        </span>                        <span class="input-group-btn">                            <a class="btn btn-secondary delete-file" href="javascript:" data-toggle="tooltip"                               data-placement="bottom" title="" data-original-title="删除文件">                                <span class="iconfont icon-close"></span>                            </a>                        </span>                    </div>                    <div class="upload-preview text-center upload-preview" style="height: 49px;">                        <span class="upload-preview-tip">750×360</span>                        <img class="upload-preview-img" src="">                    </div>                </div>            </div>        </div>        <div class="row cl">            <label class="form-label col-4"><span class="c-red">*</span>跳转类型：</label>            <div class="col-sm-2">                <select name="open_type" class="select" id="select" style="height: 31px;vertical-align: middle;" onClick="show();" >                    <option  value="0">请选择跳转类型</option>                    {foreach from=$list item=item name=f1}                        <option  value="{$item->url}">{$item->name}</option>                    {/foreach}                </select>            </div>            <text style="color: red;" id="activity_type"></text>        </div>        <div class="row cl" id="parameter1" style="display: none;">            <label class="form-label col-4"><span class="c-red">*</span>参数：</label>            <div class="col-sm-6">                <input class="form-control" type="text" name="parameter" id="parameter" value="" onchange="canshu()">            </div>        </div>        <div class="row cl" >            <label class="form-label col-4"><span class="c-red">*</span>路径：</label>            <div class="col-sm-6">                <input class="form-control" type="text" name="url" id="url" value="" readonly="readonly" style="background-color: #eeeeee !important">            </div>        </div>    </form>    <div class="page_bort" style="z-index: 999;">        <input type="button" name="Submit" value="保存" class="fo_btn2" onclick="check()">        <input type="button" name="reset" value="取消" class="fo_btn1" onclick="javascript :history.back(-1);">    </div></div>{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}{literal}    <script>        var url = '';        var parameter = '';        var parameter_status = '';        function show() {            var obj = $('#select option:selected').val(); // 跳转类型            if(obj != 0){                $.ajax({                    cache: true,                    type: "GET",                    dataType: "json",                    url: 'index.php?module=banner&action=Add&m=open_type&obj='+obj,                    data: $('#form1').serialize(),// 你的formid                    async: true,                    success: function (data) {                        var canshu = document.getElementById("parameter").value;                        var url1 = '';                        url = data.url;                        parameter = data.parameter;                        parameter_status = data.parameter_status;                        if(parameter_status){                            if(canshu != ''){                                url1 = data.url + '?' + data.parameter + '=' + canshu;                            }else{                                url1 = data.url + '?' + data.parameter + '=';                            }                            document.getElementById('parameter1').style.display = ""; // 参数显示                        }else{                            url1 = data.url;                            document.getElementById('parameter1').style.display = "none"; // 参数隐藏                        }                        $("#url").val(url1)                    }                });            }else{                $("#url").val('')            }        }        function canshu() {            var canshu = document.getElementById("parameter").value;            var url2 = url + '?' + parameter + '=' + canshu;            $("#url").val(url2)        }        function check() {            var obj = $('#select option:selected').val(); // 跳转类型            if(obj == 0){                layer.msg('请选择跳转类型',{time:2000})                return false            }else{                var canshu = document.getElementById("parameter").value;                if(!canshu && obj != '/pages/tabBar/home'){                     layer.msg('请填参数',{time:2000})                     return false                }            }            $.ajax({                cache: true,                type: "POST",                dataType: "json",                url: 'index.php?module=banner&action=Add',                data: $('#form1').serialize(),// 你的formid                async: true,                success: function (data) {                    layer.msg(data.status, {time: 2000});                    if (data.suc) {                        location.href = 'index.php?module=banner';                    }                }            });        }    </script>{/literal}</body></html>