<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-08-26 13:32:27
 * @LastEditTime: 2019-08-27 17:06:48
 * @LastEditors: Please set LastEditors
 -->
{include file="../../include_path/header.tpl" sitename="DIY头部"}
{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}

{literal}
<link href="style/css/model.dd.css" rel="stylesheet" type="text/css">
<style type="text/css">
td a {
    width: 28%;
    float: left;
    margin: 2% !important;
}
.stopCss:hover {
    cursor: not-allowed;
}
.stopCss {
    width: 88px;
    height: 20px;
    border: 1px solid #e9ecef;
    color: #d8dbe8 !important;
    font-size: 12px;
    border-radius: 2px;
    line-height: 20px;
    display: inline-block;
    margin-left: -2%;
    margin-bottom
}

    .model-line{
        height:447px;
        width:1px;
        border-left: 1px solid #E9ECEF;
    }
    .card-left {

    }
    .card-right {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 447px;
        flex-direction: column;
    }
    .right-effect {
        width:377px;
        height:300px;
        box-shadow:0px 0px 16px 0px rgba(0, 0, 0, 0.1);
    }
    .right-text {
        margin-top:22px;
        font-size:14px;
        font-weight:400;
        color:rgba(151,160,180,1);
    }
    button.btn.item-btn1 {
        width: 112px;
        height: 36px;
        border: 1px solid rgba(40,144,255,1);
        border-radius: 2px;
        color: rgba(40,144,255,1);
    }

    button.btn.btn-primary.item-btn2 {
        width: 112px;
        height: 36px;
        background: rgba(40,144,255,1);
        border-radius: 2px;
    }

    .form1_div{
        display: flex;
    }
    .form1_div label{
        max-width: 130px;
    }
</style>
{/literal}
<body style="background: #edf1f5;">

{include file="../../include_path/nav.tpl" sitename="面包屑"}

<div class="pd-20 page_absolute">
    <div class="text-c">
        <form name="form1" action="index.php" method="get">
            <input type="hidden" name="module" value="invoice"/>
            <input type="hidden" name="action" value="template"/>
            <input type="hidden" id="type" value="1"/>
            <input type="hidden" id="id" value="">

            <input type="text" name="name" value="{$name}" placeholder="请输入模版名称" class="input-text" style="width: 200px;">
            <input name="" id="btn9" class="btn " type="submit" value="查询">
        </form>
    </div>
    <div class="page_h16"></div>
    <div style="clear:both;background-color: #edf1f5;">
        <button class="btn newBtn radius" onclick="add_template()">
            <div style="height: 100%;display: flex;align-items: center;font-size: 14px;">
                <img src="images/icon1/add.png"/>&nbsp;添加模版
            </div>
        </button>
        <button class="btn newBtn radius" onclick="add_tpl()" style="width: 130px;">
            <div style="height: 100%;display: flex;align-items: center;font-size: 14px;">
                <img src="images/icon1/add.png"/>&nbsp;添加公共模版
            </div>
        </button>
    </div>
    <div class="page_h16"></div>
    <div class="tab_table table-scroll">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th>模版名称</th>
                    <th>模版类型</th>
                    <th>模版图片</th>
                    <th>模版尺寸</th>
                    <th>创建时间</th>
                    <th class="tab_five">操作</th>
                </tr>
            </thead>
            <tbody id="tbody">
            {foreach from=$tpl item=item name=f1}
                <tr class="text-c tab_td" id="li_{$item->id}">
                    <td class="tab_num">{$item->name}</td>
                    <td>{if $item->type==1}发货单模版{else}快递单模版{/if}</td>
                    <td class="tab_imgurl">
                        {if $item->image != ''}
                            <image class="pimg" src="{$item->image}"/>
                        {else}
                            <span>暂无图片</span>
                        {/if}
                    </td>
                    <td>宽{$item->width}mm*高{$item->height}mm</td>
                    <td>{$item->add_date}</td>
                    <td class="tab_five">
                        <!-- <a title="编辑" onclick="imgShow('#outerdiv', '#innerdiv', '#bigimg', $('.pimg'))">
                           <img src="images/icon1/xg.png"/>&nbsp;编辑
                        </a> -->
                        <a onclick="confirm({$item->id})" >
                           <img src="images/icon1/del.png"/>&nbsp;删除
                        </a>
                    </td>
                </tr>
                </form>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div class="tb-tab" style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
</div>
<div id="outerdiv"
     style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:9999;width:100%;height:100%;display:none;">
    <div id="innerdiv" style="position:absolute;"><img id="bigimg" src=""/></div>
</div>
<div class="maskNew" id="del_tpl" style="display: none;">
    <div class="maskNewContent">
        <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
        <div class="maskTitle">删除</div>
        <div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
        <div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
            确定要删除此模版吗？
        </div>
        <div style="text-align:center;margin-top:30px">
            <button class="closeMask" style="margin-right:20px" onclick=del()>确认</button>
            <button class="closeMask" onclick=closeMask1() >取消</button>
        </div>
    </div>
</div>

<div id="modal-demo" class="modal felxx" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 9999;">
  <div class="modal-dialog" style="z-index: 10000;height:100%;max-width: 920px;box-shadow:0 0px 0px 0px rgba(0, 0, 0, 0);display:flex;">
      <div class="modal-content radius box-modal" style="height:642px;">

        <div class="modal-header item-head">
          <h3 class="modal-title item-title">添加模板</h3>
          <a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
        </div>

        <div class="modal-body">

            <form name="form1" id="form1" class="form form-horizontal" method="post"   enctype="multipart/form-data" >
                <div class="row">
                <label class=" col-xs-4 col-sm-2">模板名称：</label>
                <div class="col-xs-4 col-sm-4 card-left">
                    <select id="add_id" class="select" size="1" name="tempname">
                    {foreach from=$all_tpl item=item name=f1}
                    <option class="add_option" value="{$item->id}" title="{$item->image}" selected>{$item->name}</option>
                    {/foreach}
                    </select>
                </div>
                <div class="col-xs-1 col-sm-1 model-line"></div>
                <div class="col-xs-4 col-sm-5 card-right">
                    <div class="right-effect">

                        <img id="add_img" src="{$item->image}" style="width: 100%;height: 300px;">

                    </div>
                    <div class="right-text">(模板图片预览效果)</div>
                </div>
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <button class="btn item-btn1" data-dismiss="modal" aria-hidden="true">取消</button>
            <button class="btn btn-primary item-btn2" onclick="addcheck()">保存</button>
        </div>

      </div>
  </div>
</div>

<div id="modal-public" class="modal felxx" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 9999;">
  <div class="modal-dialog" style="z-index: 10000;height:100%;max-width: 920px;box-shadow:0 0px 0px 0px rgba(0, 0, 0, 0);display:flex;">
      <div class="modal-content radius box-modal" style="height:642px;">

        <div class="modal-header item-head">
          <h3 class="modal-title item-title">添加公共模板</h3>
          <a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
        </div>

        <div class="modal-body">

            <form name="form1" id="form1" class="form form-horizontal" method="post"   enctype="multipart/form-data" >
                <div class="form1_div">
                   <div style='width: 400px'>
                       <div class='row'>
                            <label class=" col-xs-4 col-sm-2">模板名称：</label>
                            <div class="col-xs-4 col-sm-4 card-left">
                                <input type="text" id="tplname" class="select input_190">
                            </div>
                       </div>
                       <div class='row'>
                            <label class=" col-xs-4 col-sm-2">区别名称：</label>
                            <div class="col-xs-4 col-sm-4 card-left">
                                <input type="text" id="e_name" class="select input_190" placeholder="请填写英文">
                            </div>
                       </div>
                       <div class='row'>
                            <label class=" col-xs-4 col-sm-2">模板宽度：</label>
                            <div class="col-xs-4 col-sm-4 card-left">
                                <input type="text" id="width" class="select input_190" placeholder="默认单位（mm）">
                            </div>
                       </div>
                       <div class='row'>
                            <label class=" col-xs-4 col-sm-2">模板高度：</label>
                            <div class="col-xs-4 col-sm-4 card-left">
                                <input type="text" id="height" class="select input_190" placeholder="默认单位（mm）">
                            </div>
                       </div>
                   </div>
                   <!--  <label class=" col-xs-4 col-sm-2">英文名称：</label>
                    <div class="col-xs-4 col-sm-4 card-left">
                        <input type="text" id="e_tplname" class="select">
                    </div> -->
                    <div class="model-line"></div>
                    <div class='row'  style='flex: 1;margin: 0'>
                        <label class=" col-xs-4 col-sm-2"></label>
                        <div class="col-xs-4 col-sm-5 card-right" >
                        <div class="right-effect">

                            <!-- <img id="add_img" src="{$item->image}" style="width: 100%;height: 300px;"> -->

                            <div class="formInputSD upload-group multiple" style="display: inline-flex;width: 100%;height: 300px;">
                                <div style="display: flex;width: 100%;height: 300px;">
                                    <div id="sortList" class="upload-preview-list" {if $imgUrl}style="width: 100%;height: 300px;"{/if}>
                                        <div class="upload-preview form_new_img" {if !$imgUrl}style="display: none;"{else}style="width: 100%;height: 300px;"{/if}>
                                            <img src="images/iIcon/sha.png" class="form_new_sha file-item-delete-pp" />
                                            <img src="{$imgUrl}" class="upload-preview-img">
                                            <input type="hidden" name="imgurls[]" class="file-item-input" value="{$imgUrl}">
                                        </div>
                                    </div>
                                    <div data-max='5' class="select-file form_new_file from_i" {if $imgUrl}style="display: none;"{/if}>
                                      <div>
                                        <img data-max='5' src="images/iIcon/sahc.png" data-toggle="tooltip" data-placement="bottom" title="" class="btn-secondary select-file" />
                                        <span class="form_new_span">上传图片</span>
                                      </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="right-text">(模板图片预览效果)</div>
                    </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <button class="btn item-btn1" data-dismiss="modal" aria-hidden="true">取消</button>
            <button class="btn btn-primary item-btn2" onclick="addtpl()">保存</button>
        </div>

      </div>
  </div>
</div>

{include file="../../include_path/ueditor.tpl" sitename="ueditor插件"}
{include file="../../include_path/footer.tpl"}
{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
{include file="./templateEditModel.tpl"}
{include file="./templatePassModel.tpl"}
    {literal}
    <script type="text/javascript">
        var candel = true;
        function empty(){
            $("#name").val('');
        }
        $(function () {

            var ue = UE.getEditor('editor');
            $("input[name='imgurls[]']").on("change",function(e){
                var val = $(this).val();
                if (val.length > 0) {
                  $('.form_new_file').css('display','none');
                }
            });
            $('.file-item-delete-pp').on('click',function(){
                $('.form_new_file').css('display','flex');
            })

            $(".pimg").click(function () {
                var _this = $(this);//将当前的pimg元素作为_this传入函数
                imgShow("#outerdiv", "#innerdiv", "#bigimg", _this);
            });
            
            // 根据框架可视高度,减去现有元素高度,得出表格高度
            var Vheight = $(window).height()-56-56-16-36-16-($('.tb-tab').text()?70:0)
            $('.table-scroll').css('height',Vheight+'px')

            $("#add_id").on("change",function(){
                    var srcimg = $(this).children('option:selected')
                    if(srcimg.length === 1){
                        srcimg = srcimg[0].title
                        $("#add_img").attr({ src: srcimg})
                    }
                }
            )
        });

        function addtpl(){
            var tplname = $("#tplname").val();
            var e_name = $("#e_name").val();
            var width = $("#width").val();
            var height = $("#height").val();
            var imgs = $("input[name='imgurls[]']").val();
            if (tplname.length == 0) {
                layer.msg('请编辑模版名称！');
                return false;
            }
            if (e_name.length == 0) {
                layer.msg('请填写区别名称！');
                return false;
            }
            if (width.length == 0) {
                layer.msg('请填写模版宽度！');
                return false;
            }
            if (height.length == 0) {
                layer.msg('请填写模版高度！');
                return false;
            }
            if (imgs.length == 0) {
                layer.msg('请上传模版预览图！');
                return false;
            }
            $.ajax({
                url: 'index.php?module=invoice&action=template&m=addtpl',
                type: "post",
                data: {tplname:tplname,imgs:imgs,e_name:e_name,width:width,height:height},
                success: function (res) {
                    layer.msg(res.msg);
                    $("#modal-public").modal("hide");
                    return;
                },
            });
        }

        function imgShow(outerdiv, innerdiv, bigimg, _this) {
            var src = _this.attr("src");//获取当前点击的pimg元素中的src属性
            $(bigimg).attr("src", src);//设置#bigimg元素的src属性

            /*获取当前点击图片的真实大小，并显示弹出层及大图*/
            $("<img/>").attr("src", src).load(function () {
                var windowW = $(window).width();//获取当前窗口宽度
                var windowH = $(window).height();//获取当前窗口高度
                var realWidth = this.width;//获取图片真实宽度
                var realHeight = this.height;//获取图片真实高度
                var imgWidth, imgHeight;
                var scale = 0.8;//缩放尺寸，当图片真实宽度和高度大于窗口宽度和高度时进行缩放

                if (realHeight > windowH * scale) {//判断图片高度
                    imgHeight = windowH * scale;//如大于窗口高度，图片高度进行缩放
                    imgWidth = imgHeight / realHeight * realWidth;//等比例缩放宽度
                    if (imgWidth > windowW * scale) {//如宽度扔大于窗口宽度
                        imgWidth = windowW * scale;//再对宽度进行缩放
                    }
                } else if (realWidth > windowW * scale) {//如图片高度合适，判断图片宽度
                    imgWidth = windowW * scale;//如大于窗口宽度，图片宽度进行缩放
                    imgHeight = imgWidth / realWidth * realHeight;//等比例缩放高度
                } else {//如果图片真实高度和宽度都符合要求，高宽不变
                    imgWidth = realWidth;
                    imgHeight = realHeight;
                }
                $(bigimg).css("width", imgWidth);//以最终的宽度对图片缩放

                var w = (windowW - imgWidth) / 2;//计算图片与窗口左边距
                var h = (windowH - imgHeight) / 2;//计算图片与窗口上边距
                $(innerdiv).css({"top": h, "left": w});//设置#innerdiv的top和left属性
                $(outerdiv).fadeIn("fast");//淡入显示#outerdiv及.pimg
            });

            $(outerdiv).click(function () {//再次点击淡出消失弹出层
                $(this).fadeOut("fast");
            });
        }

        // 保存
        function addcheck(){
            candel = false;
            var id = $("#add_id").val();
            $("#del_tpl").css('display','none');
            $.ajax({
                url: 'index.php?module=invoice&action=template&m=add&id=' + id,
                type: "post",
                data: {},
                success: function (res) {
                    layer.msg(res.msg);
                    if (res.code == 1) {
                        location.replace(location.href);
                    }
                    candel = true;
                },
            });
        }
        /*删除*/
        function del() {
            candel = false;
            var id = $("#id").val();
            $("#del_tpl").css('display','none');
            $.ajax({
                url: 'index.php?module=invoice&action=template&m=del&id=' + id,
                type: "post",
                data: {},
                success: function (res) {
                    layer.msg(res.msg);
                    if (res.code == 1) {
                        $("#li_"+id).css('display','none');
                    }
                    candel = true;
                },
            });
        }

        function confirm(id) {
            if (candel) {
                $("#del_tpl").css('display','block');
                $("#id").val(id);
            }else{
                layer.msg('请勿频繁操作！');
            }
        }
        function closeMask1(){
            $("#del_tpl").css('display','none');
        }
        // 添加模板弹窗
        function add_template(){
            addprint()
        }
        // 编辑订单弹窗
        function editshow(){
            editprint()
        }

        function add_tpl(){
            $("#modal-public").modal("show");
        }

        $('#selectid').mouseleave(function (e) {
          var o = e.relatedTarget || e.toElement;//获取select标签对象,移动到option上谷歌貌似option在mouseleave函数上是与select绑定在一起的不会触发mouseleave事件,ie下是null，firefox等为undefined 
          if (!o) return; //增加移动到的对象判断，o为null或者undefined时(即移动到option时)return,不执行下面的方法
          //执行你的代码
          console.log('移出触发')
        });

        // 打开模态框
        function addprint(){    
          $("#modal-demo").modal("show")
        }
    </script>
{/literal}
</body>
</html>