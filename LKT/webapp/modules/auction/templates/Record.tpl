{include file="../../include_path/header.tpl" sitename="DIY头部"}
    {literal}
        <style type="text/css">
            
            td a {
                width: 28%;
                float: left;
                margin: 2% !important;
            }
        </style>
    {/literal}
</head>
<body>
<nav class="breadcrumb page_bgcolor">
      <span class="c-gray en"></span>
      <span  style='color: #414658;'>插件管理</span>
      <span  class="c-gray en">&gt;</span>
      <span  style='color: #414658;cursor: pointer;' onclick="window.history.go(-1);">竞拍</span>
      <span  class="c-gray en">&gt;</span>
      <span  style='color: #414658;'>竞拍详情</span>
</nav>
{*<div class="pd-20">*}
<div class="pd-20 page_absolute">

    <div class="switch_a" style="height: 92px;background-color: rgba(88, 146, 240, 0.05);line-height: 90px;border:1px dashed #F00;display: flex;">
        <i class="Hui-iconfont Hui-iconfont-shenhe-weitongguo" style="font-size: 50px;color:#FF0000;margin-left: 30px;"></i>&nbsp;&nbsp;
        <span style="font-size: 20px;">
            {if $status == 0}
                未开始
            {elseif $status == 1}
                竞拍中    
            {elseif $status == 2 && $is_buy === '0'}
                竞拍成功，得主未付款
            {elseif $status == 2 && $is_buy == 1}
                竞拍成功，得主已付款
            {elseif $status == 3 }
                {if $pepole < $low_pepole}
                    已流拍，竞拍人数未达到开拍人数
                {else}
                    {if $count <= 0}
                        已流拍，活动时间未出价
                    {else}
                        已流拍，未在规定时间内付款
                    {/if}
                {/if}
            {/if}
        </span>
   </div>
    <div class="page_h16"></div>
    <div class="text-c">
        <form name="form1"  method="get">
            <input type="hidden" name="module" value="auction"/>
            <input type="hidden" name="action" value="Record">
            <input type="hidden" name="id" value="{$id}">
            <input type="hidden" name="pagesize" value="{$pagesize}" id="pagesize" />
            <input type="text" name="user_name" size='8' value="{$user_name}" id="" placeholder="请输入会员名称" style="width:200px" class="input-text">
            <input name="" id="" class="btn btn-success" type="submit" value="查询">
        </form>
    </div>
    <div class="page_h16"></div>
    <div class="mt-20">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th>
                        <input type="checkbox" class="inputC input_agreement_protocol" id="{$item->id}" name="id[]" value="">
                        <label for="i1"></label>
                    </th>
                    <th style="width:15%;">序号</th>
                    <th>竞拍会员</th>
                    <th>会员头像</th>
                    <th>出价金额</th>
                    <th>状态</th>
                    <th>出价时间</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$list item=item key = k}
                    <tr class="text-c tab_td">
                        <td>
                            <input type="checkbox" class="inputC input_agreement_protocol" id="{$item->id}" name="id[]" value="{$item->id}">
                            <label for="{$item->id}"></label>
                        </td>
                        <td style="width: 15%">{$k+1+$item->offset}</td>
                        <td>{$item->user_name}</td>
                        <td><img src="{$item->headimgurl}" alt="" width="60px" height="60px"></td>
                        <td>￥{$item->user_price}</td>
                        <td>
                            {if  $item->r_id == $first_id}
                                领先
                            {else}
                                出局
                            {/if}
                        </td>
                        <td>
                            {$item->add_time}
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
    <div style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
</div>
{include file="../../include_path/footer.tpl"}
<link href="style/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="style/js/jquery.js"></script>

<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>

</body>
</html>