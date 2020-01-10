{include file="../../include_path/header.tpl" sitename="DIY头部"}
{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
{literal}
    <style>
        .formTitleSD{
            font-weight:bold;
            font-size: 16px;
            border-bottom: 2px solid #E9ECEF;
        }
        .btn{
            height: 36px;
        }

        .select-attr{
            width: 260px;
        }
        .select-attr>ul{
            display: flex;
            height: 24px;
            line-height: 24px;
            font-size: 12px;
            margin-bottom: 0;
        }
        .select-attr>ul li{
            cursor: pointer;
            padding: 0 3px;
            color: #97A0B4;
        }
        .select-attr>ul li.active{
            color: #292B2C;
        }
        .attr-ul{height: 120px;overflow-y: scroll;}
		
		::-webkit-scrollbar-button {
			height: 0;
		}
		
        .attr-ul li{cursor: pointer;padding-left: 10px;line-height: 25px;}

        .form_new_r .ra1{display: block;}
        .upload-preview {
            position: absolute;
            top: 0;
            margin: 0;
            z-index: 50;
            border: none;
            width: 122px;
            height: 160px;
            line-height: 14px;
        }
        .upload-preview .upload-preview-img {
            width: 91px;
            height: 75px;
        }
		
		.w_304{
			width: 304px!important;
		}
    </style>
{/literal}
<body class='iframe-container'>
{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
<nav class="nav-title">
	<span>商品管理</span>
	<span class='pointer' onclick="javascript :history.back(-1);"><span class="arrows">&gt;</span>品牌管理</span>
	<span><span class="arrows">&gt;</span>添加</span>
</nav>
<div class="iframe-content" style="background-color: #fff;">

{*<div class="iframe-content form-scroll">*}
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data" style="padding: 0px;height: 100%;">
        <table class="table table-bg table-hover " style="width: 100%;height:100px;border-radius: 30px;">
            <div class="formDivSD">
                <div class="formTitleSD" >新增品牌</div>

                {*<div class="formTitleSD page_title" style='z-index: 99;'>新增品牌</div>*}
                <div class="formContentSD">
                    <div class="formListSD">
                        <div class="formTextSD"><span class="c-red">*</span><span>品牌名称：</span></div>
                        <div class="formInputSD">
                            <input class="w_304" type="text" name="brand_name" value="" datatype="*6-18" placeholder="请输入品牌名称"/>
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextBigSD"><span class="must">*</span><span>品牌logo：</span></div>
                        <div class="formInputSD upload-group multiple">
                            <div id="sortList" class="upload-preview-list uppre_auto">
                                <div class="upload-preview form_new_img" style="display: none;">
                                    <img src="images/iIcon/sha.png" class="form_new_sha file-item-delete-pp" />
                                    <img src="images/icon1/add_g_t.png" class="upload-preview-img" style='width: 100%;height: 100%;'>
                                    <input type="hidden" name="image" class="file-item-input" value="">
                                </div>
                            </div>

                            <div  class="select-file form_new_file from_i">
                                <div>
                                    <img  src="images/iIcon/sahc.png" data-toggle="tooltip" data-placement="bottom" title="" class="btn-secondary select-file" />
                                    <span class="form_new_span">上传图片</span>
                                </div>
                            </div>
                            <span class="addText" style="max-width: 350px;">（建议上传120*120px的图片）</span>
                        </div>
                    </div>
                    <div class="formListSD" >
                        <div class="formTextSD" style='height: 36px;'><span class="c-red">*</span><span>所属分类：</span></div>
                        <div class="formInputSD" style='flex-direction: column;'>
                            <div style='position: relative;'>
                                <input type="hidden" name="categories_str" id="categories_str" value=""/>
                                <select disabled class="form-control link-list-select1 w_304" name="categories" id="select_attr" style="border: 1px solid #D5DBE8;display: flex;justify-content: center;background: #fff; cursor: unset;">
                                    <option selected="true" value="0">请选择所属分类</option>
                                </select>
                                <div onclick="selectDiv_block()" style='position: absolute;left:0;top: 0;width: 100%;height: 100%;'></div>
                            </div>
                            <div class='select-div' style='display: none;'>
                                <div class='w_304' style='display: flex;padding-top: 5px;'>
                                    <input id='search_attr' type="text" style='flex: 1; height: 25px!important; font-size: 12px; padding-left: 5px;'>
                                    <a href="javascript:;" onclick="attr_search()">搜索</a>
                                </div>
                                <div class='select-attr w_304'>
                                    <ul></ul>
                                </div>
                                <ul class='attr-ul form_new_r' style='display: block;'>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="formListSD" >
                        <div class="formTextSD"><span class="c-red">*</span><span>所属国家：</span></div>
                        <div class="formInputSD">
                            <select class='w_304' style="border: 1px solid #D5DBE8;display: flex;justify-content: center;" class="form-control link-list-select1 " name="producer" id="select_c" >
                                <option selected="true" value="0">请选择所属国家</option>
                                {foreach from=$list item=item name=f1}
                                    <option value="{$item->id}">{$item->zh_name}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"><span class="c-red"></span><span>备注：</span></div>
                        <div class="formInputSD">
                            <textarea class='w_304' rows="3" cols="60" name="remarks" style="border-color: #D5DBE8;"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </table>
        <div style="height: 40px;"></div>
        <div class="row cl page_bort" style="position: fixed; bottom: 0; left: 10px; right: 10px; display: block; margin: 0; width: auto;background: #fff;z-index: 999;">
            <div style="float:right;height: 67px;">
                <input class="btn btn-primary radius ta_btn3 btn-right" type="button" onclick="check()" value="&nbsp;&nbsp;保存&nbsp;&nbsp;">
                <input class="btn btn-primary radius ta_btn4 btn-left" type="button" value="&nbsp;&nbsp;返回&nbsp;&nbsp;" onclick="javascript:history.back(-1);" style="background-color: white!important;color:#2890FF;">
            </div>
        </div>
        <div class="page_h10"></div>
    </form>
</div>
<script>
    {literal}
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
            url: 'index.php?module=brand_class&action=Add',
            data: $('#form1').serialize(), // 你的formid
            async: true,
            success: function(data) {
                layer.msg(data.status,{time:2000});
                if(data.suc){
                    location.href="index.php?module=brand_class";
                }
            }
        });
    }

    // 显示分类选择框
    function selectDiv_block(){
        if($('.select-div').css('display')=='none'){
            $('.select-div').css('display','block')
            $('.select-attr>ul').empty()
            $('.attr-ul').empty()
            $.ajax({
                type: "GET",
                url: 'index.php?module=brand_class&action=Ajax',
                data: "",
                success: function (msg) {
                    obj = JSON.parse(msg);
                    var zm = obj.zm;
                    var class_list = obj.class_list;
                    var res = '';
                    var rew = '';
                    for(var i=0;i<zm.length;i++){
                        if(i==0){
                            res+=`<li class='active'>${zm[i]}</li>`;
                            continue
                        }
                        res+=`<li>${zm[i]}</li>`;
                    }
                    for(var i=0;i<class_list.length;i++){
                        rew+=`<li class="ra1" value='${class_list[i].cid}'>
                            <input type="checkbox" id="sex-${i}" value='${class_list[i].cid}' ${class_list[i].status?'checked':''} class="inputC">
                            <label for="sex-${i}" style='width: 95%!important;'>${class_list[i].pname}</label>
                        </li>`;
                    }

                    $('.select-attr>ul').append(res)
                    $('.attr-ul').append(rew)
                }
            });
        }else{
            $('.select-div').css('display','none')
        }
    }

    // 搜索所属分类
    function attr_search(){
        var str = $("#categories_str").val();

        // 搜索的数据
        $('.select-attr>ul').empty()
        $('.attr-ul').empty()
        // 点击的这个首字母
        $.ajax({
            type: "GET",
            url: 'index.php?module=brand_class&action=Ajax&name='+$('#search_attr').val()+'&str='+str,
            data: "",
            success: function (msg) {
                obj = JSON.parse(msg);
                var zm = obj.zm;
                var class_list = obj.class_list;
                var res = '';
                var rew = '';
                for(var i=0;i<zm.length;i++){
                    if(zm[i] == class_list[0].zm){
                        res+=`<li class='active'>${zm[i]}</li>`;
                        continue
                    }
                    res+=`<li>${zm[i]}</li>`;
                }
                for(var i=0;i<class_list.length;i++){
                    rew+=`<li class="ra1" value='${class_list[i].cid}'>
                        <input type="checkbox" id="sex-${i}" value='${class_list[i].cid}' ${class_list[i].status?'checked':''} class="inputC">
                        <label for="sex-${i}" style='width: 95%!important;'>${class_list[i].pname}</label>
                    </li>`;
                }
                $('.select-attr>ul').append(res)
                $('.attr-ul').append(rew)
            }
        });
    }

    // 点击首字母查询
    $('.select-attr').on('click','li',function(){
        $('#search_attr').val('');
        $(this).addClass('active').siblings().removeClass('active');
        var str = $("#categories_str").val();

        $('.attr-ul').empty()
        // 点击的这个首字母
        $.ajax({
            type: "GET",
            url: 'index.php?module=brand_class&action=Ajax&can='+$(this).text()+'&str='+str,
            data: "",
            success: function (msg) {
                obj = JSON.parse(msg);
                var zm = obj.zm
                var class_list = obj.class_list
                var rew = '';
                for(var i=0;i<class_list.length;i++){
                    rew+=`<li class="ra1" value='${class_list[i].cid}'>
                            <input type="checkbox" id="sex-${i}" value='${class_list[i].cid}' ${class_list[i].status?'checked':''} class="inputC">
                            <label for="sex-${i}" style='width: 95%!important;'>${class_list[i].pname}</label>
                        </li>`;
                }

                $('.attr-ul').append(rew)
            }
        });
    })

    // 点击选中分类
    $('.attr-ul').on('change','input',function(){
        var text=$(this).next().text()
        var val=$(this).val()
        var select_text=$('#select_attr option').text()
        var select_val=$('#select_attr option').val()
        if($(this).is(':checked')){
            if(select_val==0){
                select_text=text
                select_val=val
            }else{
                select_text+=','+text
                select_val+=','+val
            }
        }else{
            select_text=select_text.replace(','+text,'').replace(text+',','').replace(text,'请选择所属分类')
            select_val=select_val.replace(','+val,'').replace(val+',','').replace(val,0)
        }
        $('#select_attr option').text(select_text).val(select_val)
        $("#categories_str").val(select_val)
    })
</script>
{/literal}
</body>
</html>