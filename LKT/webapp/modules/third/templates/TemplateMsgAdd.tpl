{include file="../../include_path/header.tpl" sitename="公共头部"}
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute" >
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data" style="padding: 10px 0;">
        <div class="row cl page_padd">
            <label class="form-label col-4"><span class="c-red">*</span>模板消息中文名称：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="" placeholder="" name="c_name">
            </div>
        </div>
        <div class="row cl page_padd">
            <label class="form-label col-4"><span class="c-red">*</span>模板消息对应字段：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="" placeholder="" name="e_name">
            </div>
        </div>

        <div class="row cl page_padd">
            <label class="form-label col-4">微信模板库id：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="" placeholder="" name="stock_id">
            </div>
        </div>

        <div class="row cl page_padd">
            <label class="form-label col-4">模板关键词列表：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="" placeholder="" name="stock_key">
            </div>
            <span style="color: red;">(以英文,分隔)</span>
        </div>
        <div style="height: 10px;"></div>
        <div class="page_bort">
            <input type="button" name="Submit" value="保存" class="fo_btn2" onclick="check()">
            <input type="button" name="reset" value="取消" class="fo_btn1" onclick="javascript :history.back(-1);">
        </div>
        <div style="height: 10px;"></div>
    </form>
      <div class="page_h20"></div>
</div>
{include file="../../include_path/footer.tpl"}
{literal}
    <script>
    	var aa=$(".pd-20").height();
		if(aa<583){
			$(".page_h20").css("display","block")
		}else{
			$(".page_bort").addClass("page_footer")
			$(".page_h20").css("display","none")
		}
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
                url:'index.php?module=third&action=TemplateMsgAdd',
                data:$('#form1').serialize(),// 你的formid
                async: true,
                success: function(data) {
                   if(data.suc == 1){
                        layer.msg(data.msg);
                        setTimeout(function(){
                            location.href='index.php?module=third&action=TemplateMsg';
                        },2000);
                    }else{
                        layer.msg(data.msg);
                    }
                }
            });
        }
    </script>
{/literal}
</body>
</html>