{include file="../../include_path/header.tpl" sitename="DIY头部"}
{literal}
<script type="text/javascript">
</script>
{/literal}
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="page-container page_absolute pd-20">
    <form name="form1" id="form1" class="form form-horizontal" method="post"   enctype="multipart/form-data" >
        <input type="hidden" value="" name="sheng" id="sheng">
        <input type="hidden" value="" name="shi" id="shi">
        <input type="hidden" value="" name="xian" id="xian">
        <div id="tab-system" class="HuiTab">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>发货人：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <input type="text" name="name" value="" class="input-text">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>联系电话：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <input type="text" name="tel" value="" class="input-text">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>详细地址：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <select id="Select1" name="Select1" onchange="selectCity();">
                        <option value="" selected="true">省/直辖市</option>
                    </select>
                    <select id="Select2" name="Select2" onchange="selectCountry()">
                        <option value="" selected="true">请选择</option>
                    </select>
                    <select id="Select3" name="Select3" >
                        <option value="" selected="true">请选择</option>
                    </select>
                    <input type="text" name="address" value="" class="input-text" style="width: auto;">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>邮政编码：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <input type="text" name="code" value="" class="input-text">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>是否设为默认：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <div class="radio-box">
                        <input name="is_default" id="type_1" type="radio" value="1" checked="checked" />
                        <label for="sex-0">是</label>
                    </div>
                    <div class="radio-box">
                        <input name="is_default" id="type_2" type="radio" value="0" />
                        <label for="sex-1">否</label>
                    </div>
                </div>
            </div>

        </div>
        <div class="page_bort">
            <input type="button" name="Submit" value="保存" class="fo_btn2" onclick="check()">
            <input type="button" name="reset" value="取消" class="fo_btn1" onclick="javascript :history.back(-1);">
        </div>
    </form>
</div>
{include file="../../include_path/footer.tpl"}

{literal}
    <script type="text/javascript">
        document.onkeydown = function (e) {
            if (!e) e = window.event;
            if ((e.keyCode || e.which) == 13) {
                $("[name=Submit]").click();
            }
        }
        $(function(){
            Init();
        })
        function check() {
            $("#sheng").val($("#Select1 option:selected").text());
            $("#shi").val($("#Select2 option:selected").text());
            $("#xian").val($("#Select3 option:selected").text());
            $.ajax({
                cache: true,
                type: "POST",
                dataType:"json",
                url:'index.php?module=sale&action=add',
                data:$('#form1').serialize(),// 你的formid
                async: true,
                success: function(data) {
                    layer.msg(data.status,{time:2000});
                    if(data.suc){
                        location.href="index.php?module=sale";
                    }
                }
            });
        }
    function Init(){
      var   dropElement1=document.getElementById("Select1"); 
      var   dropElement2=document.getElementById("Select2"); 
      var   dropElement3=document.getElementById("Select3");   
      RemoveDropDownList(dropElement1);
      RemoveDropDownList(dropElement2);
      RemoveDropDownList(dropElement3);
      var country;
      var province;
      var city;
      var url = "index.php?module=invoice&action=ajax&GroupID=0";
        $.ajax({
            url:url,
            success: function(text) {
                var strs= new Array(); 
                strs=text.split("|"); 
                for(var i=0; i<strs.length-1;i++)
                {
                    var opp= new Array(); 
                    opp=String(strs[i]).split(","); 
                    var   eOption=document.createElement("option");   
                    eOption.value=opp[1];
                    eOption.text=opp[0];
                    dropElement1.add(eOption);
                }
                if ($("#Select2").val().length > 0) {
                    selectCity();
                }
            }
        });
    }

    function selectCity(){
      var   dropElement1=document.getElementById("Select1"); 
      var   dropElement2=document.getElementById("Select2"); 
      var   dropElement3=document.getElementById("Select3"); 
      var   name=dropElement1.value;

      RemoveDropDownList(dropElement2);
      RemoveDropDownList(dropElement3);

      if(name!=""){

        var url = "index.php?module=invoice&action=ajax&GroupID="+name;
        $.ajax({
            url:url,
            success: function(text) {
                var strs= new Array(); 
                strs=text.split("|"); 
                for(var i=0; i<strs.length-1;   i++){
                    var opp= new Array(); 
                    opp = String(strs[i]).split(","); 

                    var eOption=document.createElement("option");   
                    eOption.value=opp[1];
                    eOption.text=opp[0];
                    dropElement2.add(eOption);
                }
                if ($("#Select3").val().length > 0) {
                    selectCountry();
                }
            }
        });
      }
    } 

    function selectCountry(){
      var   dropElement1=document.getElementById("Select1"); 
      var   dropElement2=document.getElementById("Select2"); 
      var   dropElement3=document.getElementById("Select3"); 
      var   name=dropElement2.value;

      RemoveDropDownList(dropElement3);

      if(name!=""){

        var url = "index.php?module=invoice&action=ajax&GroupID="+name;
        $.ajax({
            url:url,
            success: function(text) {
                var strs= new Array(); 
                strs=text.split("|"); 
                for(var i=0; i<strs.length-1;i++){
                    var opp= new Array(); 
                    opp=String(strs[i]).split(","); 
                    var   eOption=document.createElement("option");   
                    eOption.value=opp[1];
                    eOption.text=opp[0];
                    dropElement3.add(eOption);
                }
            }
        });
      }
    }


    function RemoveDropDownList(obj){   
        if(obj){
            var   len=obj.options.length;   
            if(len>0){  
                for(var i=len;i>=1;i--){   
                    obj.remove(i);   
                }
            }
        }
    } 
    </script>
{/literal}
</body>
</html>