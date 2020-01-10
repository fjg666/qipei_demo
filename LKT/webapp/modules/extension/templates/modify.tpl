<!DOCTYPE html>
<html lang="en" class="app">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>公众平台管理系统</title>

    <script type="text/javascript" src="style/tgt/util.js"></script>
    <link rel="stylesheet" href="style/tgt/font-awesome.min.css" type="text/css"/>
    <link rel="stylesheet" href="style/tgt/webfont.css" type="text/css"/>
    <link rel="stylesheet" href="style/tgt/fontStyle.css" type="text/css"/>
    <link rel="stylesheet" href="style/tgt/iconfont.css" type="text/css"/>
    <link rel="stylesheet" href="style/tgt/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="style/tgt/common.css">
    <link rel="stylesheet" href="style/tgt/animate.min.css" type="text/css"/>
    <link rel="stylesheet" href="style/tgt/style.min.css" type="text/css"/>
    {include file="../../include_path/software_head.tpl" sitename="DIY头部"}
    {literal}
        <script>
            var require = {
                urlArgs: 'v=2018070213'
            };
            document.onkeydown = function (e) {
                if (!e) e = window.event;
                if ((e.keyCode || e.which) == 13) {
                    $("[name=Submit]").click();
                }
            }
            function check() {
                var data = [];
                $('.drag').each(function () {
                    var obj = $(this);
                    var type = obj.attr('type');
                    var left = obj.css('left'),
                        top = obj.css('top');
                    var d = {
                        left: left,
                        top: top,
                        type: obj.attr('type'),
                        width: obj.css('width'),
                        height: obj.css('height')
                    };
                    if (type == 'nickname' || type == 'title' || type == 'marketprice' || type == 'productprice') {
                        d.size = obj.attr('size');
                        d.color = obj.attr('color');
                    } else if (type == 'qr') {
                        d.size = obj.attr('size');
                    } else if (type == 'img') {
                        d.src = obj.attr('src');
                    }
                    var imageSize = {};
                    var $imgUrl = $("img[class=bg]")[0];
                    imageSize.height = $imgUrl.height+"px";
                    imageSize.width = $imgUrl.width+"px";
                    imageSize.naturalHeight = $imgUrl.naturalHeight+"px";
                    imageSize.naturalWidth = $imgUrl.naturalWidth+"px";
                    d.imageSize = imageSize;
                    data.push(d);
                });
                $(':input[name=data]').val(JSON.stringify(data));
                $.ajax({
                    cache: true,
                    type: "POST",
                    dataType: "json",
                    url: 'index.php?module=extension&action=modify',
                    data: $('#form1').serialize(), // 你的formid
                    async: true,
                    success: function (data) {
                        console.log(data)
                        layer.msg(data.status, {
                            time: 2000
                        });
                        if (data.suc) {
                            location.href = "index.php?module=extension";
                        }
                    }
                });
            }
        </script>

    {/literal}
</head>
<body>
{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
<script src="style/tgt/require.js"></script>
<script src="style/tgt/config.js"></script>
<script src="style/tgt/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="style/tgt/jquery.gcjs.js"></script>
<script type="text/javascript" src="style/tgt/jquery.form.js"></script>
<script type="text/javascript" src="style/tgt/tooltipbox.js"></script>
<script type="text/javascript" src="style/tgt/sceollFix.js"></script>
{literal}
    <style type="text/css">
        .red {
            float: left;
            color: red
        }
        .img-thumbnail {
            height: 100px;
        }
        #poster .bg {
            max-height: 100%;
        }
        .white {
            float: left;
            color: #fff
        }
        .tooltipbox {
            background: #fef8dd;
            border: 1px solid #c40808;
            position: absolute;
            left: 0;
            top: 0;
            text-align: center;
            height: 20px;
            color: #c40808;
            padding: 2px 5px 1px 5px;
            border-radius: 3px;
            z-index: 1000;
        }
        .red {
            float: left;
            color: red
        }
        .bg-light .nav-primary > ul > li > ul.nav > li > a {
            margin: 0 0 0 10px;
        }
        .btn-primary{
            color: #2890FF !important;
        }
        .btn-primary:hover{
            background-color: #1e95c9 !important;
        }
        .btn-danger{
            color: #2890FF !important;
        }
    </style>
{/literal}
<section class="vbox hidden-bsection">
    <section>
        <section class="hbox stretch">
            {*<script src="style/tgt/common.js"></script>*}
            <section>
                <section class="vbox">
                    <section class="scrollable padder">
                        <script language='javascript' src="style/tgt/designer.js"></script>
                        <script language='javascript' src="style/tgt/jquery.contextMenu.js"></script>
                        <link href="style/tgt/jquery.contextMenu.css" rel="stylesheet">
                        {literal}
                            <style type='text/css'>
                                #poster {
                                    width: 320px;
                                    height: 504px;
                                    border: 1px solid #ccc;
                                    position: relative
                                }
                                #poster .bg {
                                    position: absolute;
                                    width: 100%;
                                    z-index: 0
                                }
                                #poster .drag[type=img] img,
                                #poster .drag[type=thumb] img {
                                    width: 100%;
                                    height: 100%;
                                }
                                #poster .drag {
                                    position: absolute;
                                    width: 80px;
                                    height: 80px;
                                    border: 1px solid #000;
                                }
                                #poster .drag[type=nickname] {
                                    width: 80px;
                                    height: 40px;
                                    font-size: 16px;
                                    font-family: 黑体;
                                }
                                #poster .drag img {
                                    position: absolute;
                                    z-index: 0;
                                    width: 100%;
                                }
                                #poster .rRightDown,
                                .rLeftDown,
                                .rLeftUp,
                                .rRightUp,
                                .rRight,
                                .rLeft,
                                .rUp,
                                .rDown {
                                    position: absolute;
                                    width: 7px;
                                    height: 7px;
                                    z-index: 1;
                                    font-size: 0;
                                }
                                #poster .rRightDown,
                                .rLeftDown,
                                .rLeftUp,
                                .rRightUp,
                                .rRight,
                                .rLeft,
                                .rUp,
                                .rDown {
                                    background: #C00;
                                }
                                .rLeftDown,
                                .rRightUp {
                                    cursor: ne-resize;
                                }
                                .rRightDown,
                                .rLeftUp {
                                    cursor: nw-resize;
                                }
                                .rRight,
                                .rLeft {
                                    cursor: e-resize;
                                }
                                .rUp,
                                .rDown {
                                    cursor: n-resize;
                                }
                                .rLeftDown {
                                    left: -4px;
                                    bottom: -4px;
                                }
                                .rRightUp {
                                    right: -4px;
                                    top: -4px;
                                }
                                .rRightDown {
                                    right: -4px;
                                    bottom: -4px;
                                }
                                .rRightDown {
                                    background-color: #00F;
                                }
                                .rLeftUp {
                                    left: -4px;
                                    top: -4px;
                                }
                                .rRight {
                                    right: -4px;
                                    top: 50%;
                                    margin-top: -4px;
                                }
                                .rLeft {
                                    left: -4px;
                                    top: 50%;
                                    margin-top: -4px;
                                }
                                .rUp {
                                    top: -4px;
                                    left: 50%;
                                    margin-left: -4px;
                                }
                                .rDown {
                                    bottom: -4px;
                                    left: 50%;
                                    margin-left: -4px;
                                }
                                .context-menu-layer {
                                    z-index: 9999;
                                }
                                .context-menu-list {
                                    z-index: 9999;
                                }
                                .scrollable {
                                    background-color: #edf1f5;
                                }
                                section {
                                    background-color: #edf1f5 !important;
                                }
                                .back {
                                    border: 1px solid #2890ff !important;
                                    background-color: #fff;
                                    color: #2890ff;
                                }
                                .back:hover {
                                    color: #2890ff;
                                }
                                .submit:hover {
                                    color: #fff;
                                }
                                body {
                                    color: #000;
                                }
                                .ta_btn3 {
                                    background-color: #2890FF !important;
                                    color: white !important;
                                }
                                .ta_btn3:hover {
                                    background-color: #2481e5 !important;
                                }
                            </style>
                            <link rel="stylesheet" href="style/css/style.css"/>
                        {/literal}
                        {include file="../../include_path/nav.tpl" sitename="面包屑"}
                        <div class="main rightlist pd-20 page_absolute">
                            <form id="form1" method="post" class="form-horizontal form" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="{$res->id}"/>
                                <div class='panel '>
                                    <div class='panel-body'>
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 海报名称</label>
                                            <div class="col-sm-9 col-xs-12">
                                                <input type="text" name="title" class="form-control" value="{$res->name}"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 海报类型</label>
                                            <div class="col-sm-9 col-xs-12">
                                                <label class="radio-inline">
                                                    <input type="radio" {if $res->type ==1} checked="checked"{/if} name="type" value="1" /> 文章海报
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" {if $res->type ==2} checked="checked"{/if} name="type" value="2" /> 红包
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" {if $res->type ==3} checked="checked"{/if} name="type" value="3" /> 商品海报
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="type" value="4" {if $res->type ==4} checked="checked"{/if} /> 分销海报
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="type" value="5" {if $res->type ==5} checked="checked"{/if} /> 邀请海报
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="type" value="6" {if $res->type ==6} checked="checked" {/if} /> 竞拍海报
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style=' color:red'>*</span>生成二维码关键词</label>
                                            <div class="col-sm-9 col-xs-12">
                                                <input type="text" name="keyword" class="form-control" value="{$res->keyword}"/>
                                                <span class='help-block'>如果是商品海报 ，回复关键词是 关键词+商品ID</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否默认</label>
                                            <div class="col-sm-9 col-xs-12">
                                                {if $res->isdefault == 1}
                                                    <label class="radio-inline">
                                                        <input type="radio" name="isdefault" value="1" checked/> 是
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="isdefault" value="0"/> 否
                                                    </label>
                                                {else}
                                                    <label class="radio-inline">
                                                        <input type="radio" name="isdefault" value="1"/> 是
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="isdefault" value="0" checked/> 否
                                                    </label>
                                                {/if}
                                                <span class='help-block'>是否是海报类型的默认设置，一种海报只能一个默认设置</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 海报设计</label>
                                            <div class="col-sm-9 col-xs-12">
                                                <table style='width:100%;'>
                                                    <tr>
                                                        <td style='width:320px;' valign='top'>
                                                            <div id='poster'>
                                                                {if $res->bg != ''}
                                                                    <img src='{$res->bg}' class='bg'/>
                                                                {/if}
                                                                {if $data != ''}
                                                                    {foreach from=$data item=d key=key name=f1}
                                                                        <div class="drag" type="{$d->type}" index="{$key+1}" style="zindex:{$key+1};left:{$d->left};top:{$d->top};width:{$d->width};height:{$d->height}" src="{$d->src}" size="{$d->size}" color="{$d->color}">
                                                                            {if $d->type=='qr'}
                                                                                <img src="style/tgt/qr.jpg"/>
                                                                            {elseif $d->type=='head'}
                                                                                <img src="style/tgt/moren.png"/>
                                                                            {elseif $d->type=='thumb'}
                                                                                <img src="style/tgt/kdd.png"/>
                                                                            {elseif $d->type =='img'}
                                                                                <img src="{$d->src}"/>
                                                                            {elseif $d->type =='nickname'}
                                                                                <div class=text style="font-size:{$d->size};color:{$d->color}">
                                                                                    昵称
                                                                                </div>
                                                                            {elseif $d->type =='title'}
                                                                                <div class=text style="font-size:{$d->size};color:{$d->color}">
                                                                                    商品名称
                                                                                </div>
                                                                            {elseif $d->type =='marketprice'}
                                                                                <div class=text style="font-size:{$d->size};color:{$d->color}">
                                                                                    商品现价
                                                                                </div>
                                                                            {elseif $d->type =='productprice'}
                                                                                <div class=text style="font-size:{$d->size};color:{$d->color}">
                                                                                    商品原价
                                                                                </div>
                                                                            {/if}
                                                                            <div class="rRightDown"></div>
                                                                            <div class="rLeftDown"></div>
                                                                            <div class="rRightUp"></div>
                                                                            <div class="rLeftUp"></div>
                                                                            <div class="rRight"></div>
                                                                            <div class="rLeft"></div>
                                                                            <div class="rUp"></div>
                                                                            <div class="rDown"></div>
                                                                        </div>
                                                                    {/foreach}
                                                                {/if}
                                                            </div>
                                                        </td>
                                                        <td valign='top'>
                                                            <div class='panel panel-default'>
                                                                <div class='panel-body'>
                                                                    <div class="form-group" id="bgset">
                                                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">背景图片</label>
                                                                        <div class="col-sm-9 col-xs-12">
                                                                            {literal}
                                                                                <script type="text/javascript">
                                                                                    function showImageDialog(elm, opts, options) {
                                                                                        require(["util"], function (util) {
                                                                                            var btn = $(elm);
                                                                                            var ipt = btn.parent().prev();
                                                                                            var val = ipt.val();
                                                                                            var img = ipt.parent().next().children();
                                                                                            options = {
                                                                                                'global': false,
                                                                                                'class_extra': '',
                                                                                                'direct': true,
                                                                                                'multiple': false
                                                                                            };
                                                                                            util.image(val, function (url) {
                                                                                                if (url.url) {
                                                                                                    if (img.length > 0) {
                                                                                                        img.get(0).src = url.url;
                                                                                                    }
                                                                                                    ipt.val(url.attachment);
                                                                                                    ipt.attr("filename", url.filename);
                                                                                                    ipt.attr("url", url.url);
                                                                                                }
                                                                                                if (url.media_id) {
                                                                                                    if (img.length > 0) {
                                                                                                        img.get(0).src = "";
                                                                                                    }
                                                                                                    ipt.val(url.media_id);
                                                                                                }
                                                                                            }, null, options);
                                                                                        });
                                                                                    }
                                                                                    $(document).on('click', '.sxxxx', function () {
                                                                                        var btn = $(this);
                                                                                        var group = btn.parents('.upload-group');
                                                                                        var input = group.find('.file-input');
                                                                                        var preview = group.find('.upload-preview');
                                                                                        var preview_img = group.find('.upload-preview-img');
                                                                                        tt_select_file({
                                                                                            accept: group.attr('accept') || 'image/*',
                                                                                            start: function () {
                                                                                                btn.btnLoading(btn.text());
                                                                                            },
                                                                                            success: function (res) {
                                                                                                var ipt = btn.parent().prev();
                                                                                                var img = ipt.parent().next().children();
                                                                                                img.get(0).src = res.url;
                                                                                                ipt.val(res.url);
                                                                                                ipt.attr("filename", res.url);
                                                                                                ipt.attr("url", res.url);
                                                                                            },
                                                                                        });
                                                                                    });
                                                                                    function deleteImage(elm,m) {
                                                                                        require(["jquery"], function ($) {
                                                                                            $(elm).prev().attr("src", "style/tgt/nopic.jpg");
                                                                                            $(elm).parent().prev().find("input").val("");
                                                                                            if(m == 1){
                                                                                                $(".bg").remove();
                                                                                            }else{
                                                                                                $(".drag[type='img']").find("img").attr('src','style/tgt/kdd.png');
                                                                                            }
                                                                                        });
                                                                                    }
                                                                                </script>
                                                                            {/literal}
                                                                            <div class="input-group ">
                                                                                <input type="text" name="bg" value="{$res->bg}" class="form-control" autocomplete="off">
                                                                                <span class="input-group-btn">
                                                                                    <button class="btn btn-default sxxxx" type="button">选择图片</button>
                                                                                </span>
                                                                            </div>

                                                                            <div class="input-group " style="margin-top:.5em;">
                                                                                <img src="{$res->bg}" onerror="this.src='style/tgt/nopic.jpg'; this.title='图片未找到.'" class="img-responsive img-thumbnail" width="150"/>
                                                                                <em class="close" style="position:absolute; top: 0px; left: 150px;" title="删除这张图片" onclick="deleteImage(this,1)">×</em>
                                                                            </div>
                                                                            <span class='help-block'>背景图片尺寸: 640 * 1008</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-xs-12 col-sm-3 col-md-3 control-label">海报元素</label>
                                                                        <div class="col-sm-9 col-xs-12">
                                                                            <button class='btn btn-default btn-com' type='button' data-type='head' style="margin-bottom: 4px">头像</button>
                                                                            <button class='btn btn-default btn-com' type='button' data-type='nickname' style="margin-bottom: 4px">昵称</button>
                                                                            <button class='btn btn-default btn-com' type='button' data-type='qr' style="margin-bottom: 4px">二维码</button>
                                                                            <button class='btn btn-default btn-com' type='button' data-type='img' style="margin-bottom: 4px">图片</button>
                                                                            <span id="goodsparams">
                                                                                <button class='btn btn-default btn-com' type='button' data-type='title'>商品名称</button>
                                                                                <button class='btn btn-default btn-com' type='button' data-type='thumb'>商品图片</button>
                                                                                <button class='btn btn-default btn-com' type='button' data-type='marketprice'>商品现价</button>
                                                                                <button class='btn btn-default btn-com' type='button' data-type='productprice'>商品原价</button>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div id='qrset' style='display:none'>
                                                                        <div class="form-group">
                                                                            <label class="col-xs-12 col-sm-3 col-md-3 control-label">二维码尺寸</label>
                                                                            <div class="col-sm-9 col-xs-12">
                                                                                <select id='qrsize' class='form-control'>
                                                                                    <option value='1'>1</option>
                                                                                    <option value='2'>2</option>
                                                                                    <option value='3'>3</option>
                                                                                    <option value='4'>4</option>
                                                                                    <option value='5'>5</option>
                                                                                    <option value='6'>6</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div id='nameset' style='display:none'>
                                                                        <div class="form-group">
                                                                            <label class="col-xs-12 col-sm-3 col-md-3 control-label">昵称颜色</label>
                                                                            <div class="col-sm-9 col-xs-12 wid100">
                                                                                {literal}
                                                                                    <script type="text/javascript">
                                                                                        require(["jquery", "util"], function ($, util) {
                                                                                            $(function () {
                                                                                                $(".colorpicker").each(function () {
                                                                                                    var elm = this;
                                                                                                    util.colorpicker(elm, function (color) {
                                                                                                        $(elm).parent().prev().prev().val(color.toHexString());
                                                                                                        $(elm).parent().prev().css("background-color", color.toHexString());
                                                                                                    });
                                                                                                });
                                                                                                $(".colorclean").click(function () {
                                                                                                    $(this).parent().prev().prev().val("");
                                                                                                    $(this).parent().prev().css("background-color", "#FFF");
                                                                                                });
                                                                                            });
                                                                                        });
                                                                                    </script>
                                                                                {/literal}
                                                                                <div class="row row-fix">
                                                                                    <div class="col-xs-8 col-sm-8" style="padding-right:0;">
                                                                                        <div class="input-group">
                                                                                            <input class="form-control" type="text" name="color" placeholder="请选择颜色" value="{$res->color}">
                                                                                            <span class="input-group-addon" style="width:35px;border-left:none;background-color:"></span>
                                                                                            <span class="input-group-btn">

                                                                                                <button class="btn btn-default colorpicker" type="button">选择颜色 </button>
                                                                                                <button class="btn btn-default colorclean" type="button">清空</button>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-xs-12 col-sm-3 col-md-3 control-label">昵称大小</label>
                                                                            <div class="col-sm-4">
                                                                                <div class='input-group wid100'>
                                                                                    <input type="text" id="namesize" class="form-control namesize" placeholder="例如: 14,16"/>
                                                                                    <div class='input-group-addon' style="width: 37px;">px</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" id="imgset" style="display:none">
                                                                        <label class="col-xs-12 col-sm-3 col-md-3 control-label">图片设置</label>
                                                                        <div class="col-sm-9 col-xs-12">
                                                                            <div class="input-group " style="width: 80%;">
                                                                                <input type="text" name="img" value="{$res->image}" class="form-control" autocomplete="off">
                                                                                <span class="input-group-btn">
                                                                                    <button class="btn btn-default sxxxx" type="button">选择图片</button>
                                                                                </span>
                                                                            </div>
                                                                            <div class="input-group " style="margin-top:.5em;">
                                                                                <img src="{$res->image}" onerror="this.src='style/tgt/nopic.jpg'; this.title='图片未找到.'" class="img-responsive img-thumbnail" width="150"/>
                                                                                <em class="close" style="position:absolute; top: 0px; left: 150px;" title="删除这张图片" onclick="deleteImage(this,2)">×</em>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">生成等待文字</label>
                                            <div class="col-sm-9 col-xs-12">
                                                <textarea name="waittext" class="form-control">{$res->waittext}</textarea>
                                                <span class="help-block">例如：您的专属海报正在拼命生成中，请等待片刻...</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="page_bort">
                                        <div>
                                            <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                                            <div class="col-sm-9 col-xs-12 page_out">
                                                <input type="hidden" name="token" value="41f48483"/>
                                                <input type="hidden" name="data" value="{$res->data}"/>
                                                <input type="button" name="back" onclick='history.back()' value="返回" class="btn back ta_btn4"/>
                                                <input type="button" name="Submit" onclick="check()" value="提交" class=" btn submit ta_btn3"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body"></div>
                                </div>
                            </form>
                        </div>
                        {literal}
                            <script language='javascript'>
                                $.upload_file = function (args) {
                                    _pl_file_uploader.input.prop('multiple', args.multiple || false);
                                    _pl_file_uploader.input.attr('accept', args.accept || '*/*');
                                    _pl_file_uploader.url = args.url || _upload_url+'&group_id=0';
                                    _pl_file_uploader.dataType = args.dataType || 'json';
                                    _pl_file_uploader.dataType = _pl_file_uploader.dataType.toLowerCase();
                                    _pl_file_uploader.start = args.start || null;
                                    _pl_file_uploader.progress = args.progress || null;
                                    _pl_file_uploader.success = args.success || null;
                                    _pl_file_uploader.error = args.error || null;
                                    _pl_file_uploader.complete = args.complete || null;
                                    document.getElementById(_pl_file_uploader.id).click();
                                };
                                $.fn.extend({
                                    btnLoading: function (loadingText, showIcon) {
                                        loadingText = loadingText || "Loading";
                                        showIcon = showIcon || true;
                                        this[0].originalText = this.html();
                                        this.html(loadingText).addClass("disabled btn-loading");
                                        this.prop("disabled", true);
                                        return this;
                                    },
                                    btnReset: function () {
                                        this.html(this[0].originalText);
                                        this.removeClass("disabled btn-loading");
                                        this.prop("disabled", false);
                                        return this;
                                    },

                                    plupload: function (args) {
                                        var $$this = this;
                                        $$this.each(function () {
                                            var _this = this;
                                            var $this = $(this);
                                            if (_this.uploader) {
                                                return;
                                            }
                                            if ($this.attr("id"))
                                                var browse_button = $this.attr("id");
                                            else {
                                                var browse_button = $.randomString();
                                                $this.attr("id", browse_button);
                                            }
                                            _this.uploader = new plupload.Uploader({
                                                browse_button: browse_button,
                                                url: args.url || "",
                                            });
                                            _this.uploader.bind("FilesAdded", function (uploader, files) {
                                                uploader.start();
                                                if (args.beforeUpload && typeof args.beforeUpload == "function")
                                                    args.beforeUpload($this, _this);
                                                uploader.disableBrowse(true);
                                            });
                                            _this.uploader.bind("FileUploaded", function (uploader, file, responseObject) {
                                                if (responseObject.status == 200) {

                                                }
                                                var res = JSON.parse(responseObject.response);
                                                if (args.success && typeof args.success == "function")
                                                    args.success(res, _this, $this);
                                            });
                                            _this.uploader.bind("UploadComplete", function (uploader, files) {
                                                uploader.destroy();
                                                _this.uploader = false;
                                                setTimeout(function () {
                                                    $(_this).plupload(args);
                                                }, 1);
                                            });
                                            _this.uploader.init();

                                        });

                                    }

                                });
                                $('form').submit(function () {
                                    if ($(':input[name=title]').isEmpty()) {
                                        Tip.focus($(':input[name=title]'), '请输入海报名称!');
                                        return false;
                                    }
                                    if ($(':input[name=type]:checked').length <= 0) {
                                        Tip.focus($(':input[name=title]'), '请选择海报类型!');
                                        return false;
                                    }
                                    if ($(':input[name=keyword]').isEmpty()) {
                                        Tip.focus($(':input[name=keyword]'), '请输入回复关键词!');
                                        return false;
                                    }
                                    if ($(':radio[name=type]:checked').val() == '4') {
                                        if ($(':radio[name=paytype]:checked').val() == '1') {
                                            var recmoney = parseFloat($(':input[name=recmoney]').val());
                                            if (recmoney > 0) {
                                                if (recmoney < 1) {
                                                    Tip.select($(':input[name=recmoney]'), '微信企业付款需支付1元以上!', 'bottom');
                                                    return false;
                                                }
                                            }
                                            var submoney = parseFloat($(':input[name=submoney]').val());
                                            if (submoney > 0) {
                                                if (submoney < 1) {
                                                    Tip.select($(':input[name=submoney]'), '微信企业付款需支付1元以上!', 'bottom');
                                                    return false;
                                                }
                                            }
                                        }
                                    }
                                    var data = [];
                                    $('.drag').each(function () {
                                        var obj = $(this);
                                        var type = obj.attr('type');
                                        var left = obj.css('left'),
                                            top = obj.css('top');
                                        var d = {
                                            left: left,
                                            top: top,
                                            type: obj.attr('type'),
                                            width: obj.css('width'),
                                            height: obj.css('height')
                                        };
                                        if (type == 'nickname' || type == 'title' || type == 'marketprice' || type == 'productprice') {
                                            d.size = obj.attr('size');
                                            d.color = obj.attr('color');
                                        } else if (type == 'qr') {
                                            d.size = obj.attr('size');
                                        } else if (type == 'img') {
                                            d.src = obj.attr('src');
                                        }
                                        data.push(d);
                                    });
                                    $(':input[name=data]').val(JSON.stringify(data));
                                    return true;
                                });
                                function bindEvents(obj) {
                                    var index = obj.attr('index');
                                    var rs = new Resize(obj, {
                                        Max: true,
                                        mxContainer: "#poster"
                                    });
                                    rs.Set($(".rRightDown", obj), "right-down");
                                    rs.Set($(".rLeftDown", obj), "left-down");
                                    rs.Set($(".rRightUp", obj), "right-up");
                                    rs.Set($(".rLeftUp", obj), "left-up");
                                    rs.Set($(".rRight", obj), "right");
                                    rs.Set($(".rLeft", obj), "left");
                                    rs.Set($(".rUp", obj), "up");
                                    rs.Set($(".rDown", obj), "down");
                                    rs.Scale = true;
                                    var type = obj.attr('type');
                                    if (type == 'nickname' || type == 'img' || type == 'title' || type == 'marketprice' || type == 'productprice') {
                                        rs.Scale = false;
                                    }
                                    new Drag(obj, {
                                        Limit: true,
                                        mxContainer: "#poster"
                                    });
                                    $('.drag .remove').unbind('click').click(function () {
                                        $(this).parent().remove();
                                    })
                                    $.contextMenu({
                                        selector: '.drag[index=' + index + ']',
                                        callback: function (key, options) {
                                            var index = parseInt($(this).attr('zindex'));
                                            if (key == 'next') {
                                                var nextdiv = $(this).next('.drag');
                                                if (nextdiv.length > 0) {
                                                    nextdiv.insertBefore($(this));
                                                }
                                            } else if (key == 'prev') {
                                                var prevdiv = $(this).prev('.drag');
                                                if (prevdiv.length > 0) {
                                                    $(this).insertBefore(prevdiv);
                                                }
                                            } else if (key == 'last') {
                                                var len = $('.drag').length;
                                                if (index >= len - 1) {
                                                    return;
                                                }
                                                var last = $('#poster .drag:last');
                                                if (last.length > 0) {
                                                    $(this).insertAfter(last);
                                                }
                                            } else if (key == 'first') {
                                                var index = $(this).index();
                                                if (index <= 1) {
                                                    return;
                                                }
                                                var first = $('#poster .drag:first');
                                                if (first.length > 0) {
                                                    $(this).insertBefore(first);
                                                }
                                            } else if (key == 'delete') {
                                                $(this).remove();
                                            }
                                            var n = 1;
                                            $('.drag').each(function () {
                                                $(this).css("z-index", n);
                                                n++;
                                            })
                                        },
                                        items: {
                                            "next": {
                                                name: "调整到上层"
                                            },
                                            "prev": {
                                                name: "调整到下层"
                                            },
                                            "last": {
                                                name: "调整到最顶层"
                                            },
                                            "first": {
                                                name: "调整到最低层"
                                            },
                                            "delete": {
                                                name: "删除元素"
                                            }
                                        }
                                    });
                                    obj.unbind('click').click(function () {
                                        bind($(this));
                                    })
                                }
                                var imgsettimer = 0;
                                var nametimer = 0;
                                var bgtimer = 0;
                                function bindType(type) {
                                    $("#goodsparams").hide();
                                    $(".type4").hide();
                                    if (type == '4') {
                                        $(".type4").show();
                                    } else if (type == '3') {
                                        $("#goodsparams").show();
                                    }
                                }
                                function clearTimers() {
                                    clearInterval(imgsettimer);
                                    clearInterval(nametimer);
                                    clearInterval(bgtimer);
                                }
                                function getImgUrl(val) {
                                    return val;
                                }
                                function bind(obj) {
                                    var imgset = $('#imgset'),
                                        nameset = $("#nameset"),
                                        qrset = $('#qrset');
                                    imgset.hide(), nameset.hide(), qrset.hide();
                                    clearTimers();
                                    var type = obj.attr('type');
                                    if (type == 'img') {
                                        imgset.show();
                                        var src = obj.attr('src');
                                        var input = imgset.find('input');
                                        var img = imgset.find('img');
                                        if (typeof(src) != 'undefined' && src != '') {
                                            input.val(src);
                                            img.attr('src', getImgUrl(src));
                                        }
                                        imgsettimer = setInterval(function () {
                                            if (input.val() != src && input.val() != '') {
                                                var url = getImgUrl(input.val());
                                                obj.attr('src', input.val()).find('img').attr('src', url);
                                            }
                                        }, 10);
                                    } else if (type == 'nickname' || type == 'title' || type == 'marketprice' || type == 'productprice') {
                                        nameset.show();
                                        var color = obj.attr('color') || "#000";
                                        var size = obj.attr('size') || "16";
                                        var input = nameset.find('input:first');
                                        var namesize = nameset.find('#namesize');
                                        var picker = nameset.find('.sp-preview-inner');
                                        input.val(color);
                                        namesize.val(size.replace("px", ""));
                                        picker.css({
                                            'background-color': color,
                                            'font-size': size
                                        });
                                        nametimer = setInterval(function () {
                                            obj.attr('color', input.val()).find('.text').css('color', input.val());
                                            obj.attr('size', namesize.val() + "px").find('.text').css('font-size', namesize.val() + "px");
                                        }, 10);
                                    } else if (type == 'qr') {
                                        qrset.show();
                                        var size = obj.attr('size') || "3";
                                        var sel = qrset.find('#qrsize');
                                        sel.val(size);
                                        sel.unbind('change').change(function () {
                                            obj.attr('size', sel.val())
                                        });
                                    }
                                }
                                $(function () {
                                    $('.drag').each(function () {
                                        bindEvents($(this));
                                    })
                                    $(':radio[name=type]').click(function () {
                                        var type = $(this).val();
                                        bindType(type);
                                    })
                                    //改变背景
                                    $('#bgset').find('button:first').click(function () {
                                        var oldbg = $(':input[name=bg]').val();
                                        bgtimer = setInterval(function () {
                                            var bg = $(':input[name=bg]').val();
                                            if (oldbg != bg && bg != '') {
                                                bg = getImgUrl(bg);
                                                $('#poster .bg').remove();
                                                var bgh = $("<img src='" + bg + "' class='bg' />");
                                                var first = $('#poster .drag:first');
                                                if (first.length > 0) {
                                                    bgh.insertBefore(first);
                                                } else {
                                                    $('#poster').append(bgh);
                                                }
                                                oldbg = bg;
                                                clearInterval(bgtimer);
                                            }
                                        }, 1000);
                                    })
                                    $('.btn-com').click(function () {
                                        var imgset = $('#imgset'),
                                            nameset = $("#nameset"),
                                            qrset = $('#qrset');
                                        imgset.hide(), nameset.hide(), qrset.hide();
                                        clearTimers();
                                        var type = $(this).data('type');
                                        var img = "";
                                        if (type == 'qr') {
                                            img = '<img src="style/tgt/qr.jpg" />';
                                        } else if (type == 'head') {
                                            img = '<img src="style/tgt/moren.png" />';
                                        } else if (type == 'img' || type == 'thumb') {
                                            img = '<img src="style/tgt/kdd.png" />';
                                        } else if (type == 'nickname') {
                                            img = '<div class=text>昵称</div>';
                                        } else if (type == 'title') {
                                            img = '<div class=text>商品名称</div>';
                                        } else if (type == 'marketprice') {
                                            img = '<div class=text>商品现价</div>';
                                        } else if (type == 'productprice') {
                                            img = '<div class=text>商品原价</div>';
                                        }
                                        var index = $('#poster .drag').length + 1;
                                        var obj = $('<div class="drag" type="' + type + '" index="' + index + '" style="z-index:' + index + '">' +
                                            img +
                                            '<div class="rRightDown"> </div><div class="rLeftDown"> </div><div class="rRightUp"> </div><div class="rLeftUp"> </div><div class="rRight"> </div><div class="rLeft"> </div><div class="rUp"> </div><div class="rDown"></div></div>'
                                        );
                                        $('#poster').append(obj);
                                        bindEvents(obj);
                                    });
                                    $('.drag').click(function () {
                                        bind($(this));
                                    })
                                })
                                var currentCouponType = null;
                                function selectCoupon(type) {
                                    currentCouponType = type;
                                    $('#modal-module-menus-coupon').modal();
                                }
                                function select_coupon(o) {
                                    $(":input[name=" + currentCouponType + "couponid]").val(o.id);
                                    $("." + currentCouponType + "group").find('button').html("[" + o.id + "]" + o.couponname);
                                    $("#modal-module-menus-coupon .close").click();
                                }
                                require(['bootstrap'], function ($) {
                                    $('.btn').each(function () {
                                        if ($(this).closest('td').css('position') == 'relative') {
                                            return true;
                                        }
                                        $(this).hover(function () {
                                            $(this).tooltip('show');
                                        }, function () {
                                            $(this).tooltip('hide');
                                        });
                                    })
                                });
                                $('.js-clip').each(function () {
                                    util.clip(this, $(this).attr('data-url'));
                                });
                            </script>
                        {/literal}
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>

</html>
