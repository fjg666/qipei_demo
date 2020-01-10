{include file="../../include_path/header.tpl" sitename="DIY头部"}

<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}

<div class="pd-20 page_absolute">
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data">
        <div class="row cl">
            <label class="form-label col-4"><span class="c-red">*</span>协议类型：</label>
            <div class="formControls col-8 ">
                <div class="radio-box">
                    <input name="type" id="type0" type="radio" value="0" checked="checked"/>
                    <label for="sex-0">注册</label>
                </div>
                <div class="radio-box">
                    <input name="type" id="type1" type="radio" value="1" />
                    <label for="sex-1">店铺</label>
                </div>
            </div>
            <div class="col-4"></div>
        </div>

        <div class="row cl">
            <label class="form-label col-2">用户协议：</label>
            <div class="formControls col-10">
                <script id="editor" type="text/plain" style="width:100%;height:400px;" name="content"></script>
            </div>
        </div>
        <div class="page_bort">
            <input type="button" name="Submit" value="保存" class="fo_btn2" onclick="check()">
            <input type="button" name="reset" value="取消" class="fo_btn1" onclick="javascript :history.back(-1);">
        </div>
    </form>
    <div class="page_h20"></div>
</div>
{include file="../../include_path/footer.tpl"}
{include file="../../include_path/ueditor.tpl" sitename="ueditor插件"}

{literal}
    <script type="text/javascript">
        $(function(){
            var ue = UE.getEditor('editor');
            var aa=$(".pd-20").height();
            var bb=$("#form1").height()+531;
            if(aa<bb){
                $(".page_h20").css("display","block")
            }else{
                $(".page_h20").css("display","none")
                $(".row_cl").addClass("page_footer")
            }

        });
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
                dataType: "json",
                url: 'index.php?module=system&action=Agreement_add',
                data: $('#form1').serialize(),// 你的formid
                async: true,
                success: function (data) {
                    layer.msg(data.status, {time: 2000});
                    if (data.suc) {
                        setTimeout(function () {
                            location.href = "index.php?module=system&action=Agreement";
                        }, 2000)
                    }
                }
            });
        }
    </script>
{/literal}
</body>
</html>