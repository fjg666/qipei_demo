{include file="../../include_path/header.tpl" sitename="DIY头部"}
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
    <form name="form1" id="form1"  class="form form-horizontal" method="post" enctype="multipart/form-data" >
        <div class="row cl">
            <label class="form-label col-4"><span class="c-red">*</span>类型：</label>
            <div class="formControls col-8 skin-minimal">
                <select name="type" class="select"  id="type" style="width: 390px;" onClick="show()">
                    <option value="">请选择类型</option>
                    {$select1}
                </select>
            </div>
            <div class="col-4"></div>
        </div>
        <div class="row cl"  >
            <label class="form-label col-4"><span class="c-red">*</span>类别：</label>
            <div class="formControls col-8 skin-minimal">
                <select name="type1" class="select"  id="type1" style="width: 390px;" onClick="show1()">
                    <option value="">请选择类别</option>
                </select>
            </div>
            <div class="col-4"></div>
        </div>
        <div class="row cl" id="role">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>短信模板：</label>
            <div class="formControls col-xs-8 col-sm-4"> <span class="select-box" style="width:150px;">
                <select class="select" id="tid" name="tid" size="1" onchange="one()" style="height: auto!important;">
                    <option value="">请选择短信模板</option>
                </select>
            </span></div>
        </div>
        <div class="row cl" id="content" style="display:none;">
            <label class="form-label col-4"><span class="c-red">*</span>内容：</label>
            <div class="formControls col-8 skin-minimal" id="content1">

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
// 选择类型
function show(){
    var type = $("#type").val();
    $.ajax({
        cache: true,
        type: "GET",
        dataType:"json",
        url:'index.php?module=message&action=Add',
        data:{
            type: type,
        },
        async: true,
        success: function(data) {
            var select2 = data.select2;
            var select3 = data.list;
            var res = '<option value="">请选择类型</option>';
            var res1 = '';
            for (var i in select2){
                if(select2[i]['status']){
                    res += `<option selected="selected" value="${select2[i]['value']}">${select2[i]['text']}</option>`
                }else{
                    res += `<option value="${select2[i]['value']}">${select2[i]['text']}</option>`
                }
            }
            for (var i in select3){
                if(select3[i]['status']){
                    res1 += `<option selected="selected" value="${select3[i]['id']}">${select3[i]['name']}</option>`
                }else{
                    res1 += `<option value="${select3[i]['id']}">${select3[i]['name']}</option>`
                }
            }
            $("#type1").empty();
            $("#type1").append(res);
            $("#tid").empty();
            $("#tid").append(res1);
        }
    });
}
// 选择类别
function show1(){
    var type = $("#type").val();
    var type1 = $("#type1").val();
    $.ajax({
        cache: true,
        type: "GET",
        dataType:"json",
        url:'index.php?module=message&action=Add',
        data:{
            type: type,
            type1: type1,
        },
        async: true,
        success: function(data) {
            var select3 = data.list;
            var res1 = '';
            for (var i in select3){
                if(select3[i]['status']){
                    res1 += `<option selected="selected" value="${select3[i]['id']}">${select3[i]['name']}</option>`
                }else{
                    res1 += `<option value="${select3[i]['id']}">${select3[i]['name']}</option>`
                }
            }
            $("#tid").empty();
            $("#tid").append(res1);
        }
    });
}

function one() {
    var dropElement = document.getElementById("tid");
    var v = dropElement.value;
    if (v != 0) {
        document.getElementById('content').style.display = ""; // 发送内容

        $.ajax({
            type: "GET",
            url: 'index.php?module=message&action=Add&tid=' + v,
            data: "",
            success: function (msg) {
                $("#content1").empty();

                obj = JSON.parse(msg);
                $("#content1").append(obj);
            }
        });
    }else{
        $("#content1").empty();
        document.getElementById('content').style.display = "none"; // 发送内容
    }
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
        url:'index.php?module=message&action=Add',
        data:$('#form1').serialize(),// 你的formid
        async: true,
        success: function(data) {
            layer.msg(data.status,{time:2000});
            if(data.suc){
                location.href="index.php?module=message";
            }
        }
    });
}
</script>
{/literal}
</body>
</html>