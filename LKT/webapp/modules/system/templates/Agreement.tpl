{include file="../../include_path/header.tpl" sitename="DIY头部"}
{literal}
    <style>
        td a{
            width: 29%;
            margin: 1.5%!important;
            float: left;
        }
        .btn1{
            width: 80px;
            height: 36px;
            line-height: 36px;
            display: flex;
            justify-content: center;
            align-items: center;
            float: left;
            color: #6a7076;
            background-color: #fff;
        }
        .btn1:hover{
            text-decoration: none;
        }
        .swivch a:hover{
            text-decoration: none;
            background-color: #2481e5!important;
            color: #fff!important;
        }
    </style>
{/literal}

<body class="body_bgcolor">

{include file="../../include_path/nav.tpl" sitename="面包屑"}

<div class=" pd-20 page_absolute">
    <div class="swivch swivch_bot page_bgcolor">
        {if $button[0] == 1}
            <a href="index.php?module=system&action=Config" class="btn1 ">基础配置</a>
        {/if}
        {if $button[1] == 1}
            <a href="index.php?module=system&action=Agreement" class="btn1 swivch_active" >协议配置</a>
        {/if}
        {if $button[2] == 1}
            <a href="index.php?module=system&action=Aboutus" class="btn1" >关于我们</a>
        {/if}
        <div style="clear: both;"></div>
    </div>
    <div class="page_h16"></div>

    <div style="clear:both;" class="page_bgcolor">
        <a class="btn newBtn radius" href="index.php?module=system&action=Agreement_add"><img src="images/icon1/add.png"/>添加</a>
    </div>
    <div class="page_h16"></div>
    <div class="tab_table table-scroll">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th class="tab_num">序号</th>
                    <th >标题</th>
                    <th class="tab_time">发布时间</th>
                    <th class="tab_editor">操作</th>
                </tr>
            </thead>
            <tbody>
            {foreach from=$list item=item name=f1}
                <tr class="text-c tab_td">
                    <td class="tab_num">{$item->id}</td>
                    <td>{$item->name}</td>
                    <td class="tab_time">{$item->modify_date}</td>
                    <td class="tab_editor">
                        {if $button[4] == 1}
                            <a style="text-decoration:none" class="ml-5" href="index.php?module=system&action=Agreement_modify&id={$item->id}" title="编辑" >
                                <img src="images/icon1/xg.png"/>&nbsp;编辑
                            </a>
                        {/if}
                        {if $button[5] == 1}
                            <a title="删除" href="javascript:;" onclick="confirm('确定要删除这篇协议吗?',{$item->id},'index.php?module=system&action=Agreement_del&id=','删除')" class="ml-5" style="text-decoration:none">
                                <img src="images/icon1/del.png"/>&nbsp;删除
                            </a>
                        {/if}
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
</div>
</div>
<div id="outerdiv"
     style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;">
    <div id="innerdiv" style="position:absolute;"><img id="bigimg" src=""/></div>
</div>
{include file="../../include_path/footer.tpl"}
{literal}
    <script type="text/javascript">
        $(function(){
            var ue = UE.getEditor('editor');
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });

            // 根据框架可视高度,减去现有元素高度,得出表格高度
            var Vheight = $(window).height()-56-42-16-36-16
            $('.table-scroll').css('height',Vheight+'px')
        });
        $(function(){
            var ue = UE.getEditor('editor1');
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });

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
        function confirm (content,id,url,content1){
            $("body",parent.document).append(`
                <div class="maskNew">
                    <div class="maskNewContent" style="padding-top:0px;">
                        <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                        <div class="maskTitle">删除</div>
                        <div style="font-size: 16px;text-align: center;padding:60px 0;">
                            ${content}
                        </div>
                        <div style="text-align:center;">
                            <button class="closeMask" style="margin-right:20px" onclick=closeMask('${id}','${url}','${content1}')>确认</button>
                            <button class="closeMask" onclick=closeMask1() >取消</button>
                        </div>
                    </div>
                </div>
            `)
        }
        function check() {
            console.log(88888)
            $.ajax({
                cache: true,
                type: "POST",
                dataType: "json",
                url: 'index.php?module=system&action=Config',
                data: $('#form1').serialize(),// 你的formid
                async: true,
                success: function (data) {
                    layer.msg(data.status, {time: 2000});
                    if (data.suc) {
                        setTimeout(function () {
                            location.href = "index.php?module=system&action=config";
                        }, 2000)
                    }
                }
            });
        }
        $(function () {
            $(".pimg").click(function () {
                var _this = $(this);//将当前的pimg元素作为_this传入函数
                imgShow("#outerdiv", "#innerdiv", "#bigimg", _this);
            });
        });

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
    </script>
{/literal}
</body>
</html>