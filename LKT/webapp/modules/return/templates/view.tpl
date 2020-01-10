<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>

    <link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css"/>
    <link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css"/>
    <link href="style/lib/icheck/icheck.css" rel="stylesheet" type="text/css"/>
    <link href="style/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css"/>
    <link href="style/lib/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css"/>
    <link href="style/css/style.css" rel="stylesheet" type="text/css"/>
    <title>退货详情</title>
    {literal}
        <style type="text/css">
            table th {
                border: none;
                font-weight: normal !important;
                color: #888f9e;
                font-size: 14px;
            }

            .table th {
                padding: 15px 20px;
            }

            table {
                background-color: #fff;
                border-bottom-left-radius: 10px;
                border-bottom-right-radius: 10px;
            }

            .ulTitle {
                height: 50px;
                line-height: 50px;
                text-align: left;
                padding-left: 20px;
                font-size: 16px;
                color: #414658;
                font-weight: 600;
                font-family: "微软雅黑";
                margin-bottom: 0px;
                margin-top: 20px;
                border-bottom: 2px solid #eee;
                background: #fff;
                border-top-left-radius: 10px;
                border-top-right-radius: 10px;
            }

            .taber_border {
                border: 0 !important;
            }

            .page_nav {
                height: 56px !important;
                line-height: 56px !important;
            }
            .record_box:nth-child(even){
                background: #e0e0e0;
            }
        </style>
    {/literal}
</head>
<body>
<nav class="breadcrumb page_nav">
    <i class="Hui-iconfont">&#xe62d;</i>
    {foreach from=$menu item=item key=k name=f1}
        {if $smarty.foreach.f1.first}
            <span class="c-gray en"></span>
            {$item->title}
        {else}
            <span class="c-gray en">&gt;</span>
            {if $smarty.foreach.f1.total == 3 && ($smarty.foreach.f1.total-1) == $k}
                {$item->title}
            {else}
                <a style="margin-top: 10px;" onclick="location.href='{$item->url}';">{$item->title} </a>
            {/if}
        {/if}
    {/foreach}
</nav>
<div class="pd-20 page_absolute form-scroll">
    <div class="Huiform">
        <div class="page_title">退货详情</div>
        <table class="table table-bg taber_border">
            <tbody>
            <tr>
                <th width="100" class="text-r"> 用户名：</th>
                <td>
                    <span>{$list[0]->user_id}</span>
                </td>
            </tr>
            <tr>
                <th class="text-r"> 产品ID：</th>
                <td>
                    <span>{$list[0]->p_id}</span>
                </td>
            </tr>
            <tr>
                <th class="text-r"> 产品名称：</th>
                <td>
                    <span>{$list[0]->p_name}</span>
                </td>
            </tr>
            <tr>
                <th class="text-r"> 产品价格：</th>
                <td>
                    <span>{$list[0]->p_price}</span>
                </td>
            </tr>
            <tr>
                <th class="text-r"> 数量：</th>
                <td>
                    <span>{$list[0]->num}</span>
                </td>
            </tr>
            <tr>
                <th class="text-r"> 单位：</th>
                <td>
                    <span>{$list[0]->unit}</span>
                </td>
            </tr>
            <tr>
                <th class="text-r"> 订单号：</th>
                <td>
                    <span>{$list[0]->r_sNo}</span>
                </td>
            </tr>
            <tr>
                <th class="text-r"> 添加时间：</th>
                <td>
                    <span>{$list[0]->add_time}</span>
                </td>
            </tr>
            <tr>
                <th class="text-r"> 发货时间：</th>
                <td>
                    <span>{$list[0]->deliver_time}</span>
                </td>
            </tr>

            <tr>
                <th class="text-r"> 退货原因：</th>
                <td>
                    <span>{$list[0]->content}</span>
                </td>
            </tr>

            <tr>
                <th class="text-r"> 描述图片：</th>
                <td>
                    {foreach from=$imgs item=item name=f1}
                        <img style="width: 50px;height: 50px;" onclick="pimg(this)" src="{$item}">
                    {/foreach}
                </td>
            </tr>

            {if !empty($rdata)}
                <tr>
                    {if $list[0]->r_status == '4'}
                        <th class="text-r"> 发件人：</th>
                    {else}
                        <th class="text-r"> 收货人：</th>
                    {/if}

                    <td>
                        <span>{$rdata.name}</span>
                    </td>
                </tr>
                <tr>
                    <th class="text-r"> 联系方式：</th>
                    <td>
                        <span>{$rdata.tel}</span>
                    </td>
                </tr>
                <tr>
                    <th class="text-r"> 快递名称：</th>
                    <td>
                        <span>{$rdata.express}</span>
                    </td>
                </tr>
                <tr>
                    <th class="text-r"> 快递单号：</th>
                    <td>
                        <span>{$rdata.express_num}</span>
                    </td>
                </tr>
            {/if}
            </tbody>
        </table>
        <div>
            <div style="width: 100%;padding: 15px 20px;    border-bottom: 1px #dedede solid;">售后记录</div>
            {foreach from = $record item=item name=f1}
               <div  style="display: flex;    flex-wrap: wrap;" class="record_box">
                   <div style="    display: flex;flex-direction: column;width: 50%;line-height: 30px;">
                       <div style="    display: flex;    padding: 5px 20px;    border-bottom: 1px #c3c3c3 dashed;">
                           <div> 申请日期：</div>
                           <div>{$item->re_time}</div>
                       </div>
                       <div style="    display: flex;    padding: 5px 20px;    border-bottom: 1px #c3c3c3 dashed;">
                           <div> 申请金额：</div>
                           <div>￥{$item->money}</div>
                       </div>
                   </div>
                   <div style="    display: flex;flex-direction: column;width: 50%;line-height: 30px;">
                       <div style="    display: flex;    padding: 5px 20px;    border-bottom: 1px #c3c3c3 dashed;">
                           <div> 申请类型：</div>
                           <div>
                               {if $item->re_type==1}
                                   退货退款
                               {elseif $item->re_type==3}
                                   换货
                               {else}
                                   仅退款
                               {/if}
                           </div>
                       </div>
                       <div style="    display: flex;    padding: 5px 20px;    border-bottom: 1px #c3c3c3 dashed;">
                           <div> 审批结果：</div>
                           <div>拒绝</div>
                       </div>
                   </div>
                   <div style="    padding: 5px 20px;width: 100%;    border-bottom: 1px #dedede solid;">
                       <div > 拒绝原因：</div>
                       <div style="    padding: 10px 0 5px 0;">{$item->content}</div>
                   </div>
               </div>
            {/foreach}
        </div>
    </div>
    <div style="height: 60px;"></div>
    <div class="bottomBtnWrap page_bort">
        <button type="button" onclick="javascript:history.back(-1);" class="bottomBtn backBtnSD btn-right"
                style='float: right;'>返回
        </button>
    </div>
</div>
<div id="outerdiv"
     style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;">
    <div id="innerdiv" style="position:absolute;"><img id="bigimg" src=""/></div>
</div>
<script type="text/javascript" src="style/js/jquery.js"></script>

<script type="text/javascript" src="style/lib/jquery/1.9.1/jquery.min.js"></script>

{literal}
    <script type="text/javascript">
        function pimg(obj) {
            var _this = $(obj);//将当前的pimg元素作为_this传入函数
            imgShow("#outerdiv", "#innerdiv", "#bigimg", _this);
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
    </script>
{/literal}

</body>
</html>