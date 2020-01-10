{include file="../../include_path/header.tpl" sitename="DIY头部"}
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
    <form name="form1" id="form1"  class="form form-horizontal" method="post" enctype="multipart/form-data" style="text-align: center;padding: 0;">
        <input type="hidden" name="id" value="{$id}" />
        <div class="page_title" style="text-align: left;font-size: 30px;">{$title}</div>
        <div class="row cl" style="padding: 10px;">
            <label class="form-label col-5">分享总金额：</label>
            <div class="formControls col-2">
                <input type="text" class="input-text" value="{$total_amount}" name="total_amount">
            </div>
            <label class="form-label col-2" style="text-align:left;">元</label>
        </div>
        <div class="row cl" style="padding: 10px;">
            <label class="form-label col-5"><span class="c-red"></span>红包个数：</label>
            <div class="formControls col-2">
                <input type="text" class="input-text" value="{$total_num}" name="total_num">
            </div>
            <label class="form-label col-2" style="text-align:left;">个</label>
        </div>
        <div class="row cl" style="padding: 10px;">
            <label class="form-label col-5"><span class="c-red"></span>祝福语句：</label>
            <div class="formControls col-2">
                <input type="text" class="input-text" value="{$wishing}" name="wishing">
            </div>
            <label class="form-label col-2" style="text-align:left;">如：恭喜发财</label>
        </div>
        <div class="page_bort">
            <input type="button" name="Submit" value="保存" class="fo_btn2" onclick="check()">
            <input type="button" name="reset" value="取消" class="fo_btn1" onclick="javascript :history.back(-1);">
        </div>
    </form>
</div>

{literal}
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
                url:'index.php?module=Article&action=amount',
                data:$('#form1').serialize(),// 你的formid
                async: true,
                success: function(data) {
                    console.log(data)
                    layer.msg(data.status,{time:2000});
                    if(data.suc){
                        location.href="index.php?module=Article";
                    }
                }
            });
        }
    </script>
{/literal}
</body>
</html>