<html>

	<head>
		<title>分销用户列表</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	</head>

	<body>
		<table border="1px">
			<tr>
				<th colspan="8" style="height: 100px;font-size: 20px;">分销用户列表</th>
			</tr>
			<tr>
				<th colspan="8">导出时间:{$now_data}</th>
			</tr>

            <tr class="text-c">
                <th style="width: 150px;text-align: center;">序</th>
                <th style="width: 150px;text-align: center;">推荐人</th>
                <th style="width: 150px;text-align: center;">粉丝</th>
                <th style="width: 150px;text-align: center;">手机号码</th>
                <th style="width: 150px;text-align: center;">分销级别</th>
                <th style="width: 150px;text-align: center;">打款佣金</th>
                <th style="width: 150px;text-align: center;">下级分销商</th>
                <th style="width: 150px;text-align: center;">时间</th>
            </tr>

                {foreach from=$re item=item name=f1}
                <tr class="text-c" style="font-size: 15px;">
                    <td style="font-size: 15px;">{$item->user_id}</td>
                    <td style="font-size: 15px;">
                    	{if $item->hdimg != '' && $item->user_name}
                    	{$item->user_name}
                    	{else}
                    	总店
                    	{/if} 
                    </td>
                    <td style="font-size: 15px;">{$item->r_name}</td>
                    <td style="font-size: 15px;">{$item->mobile}</td>
                    <td style="font-size: 15px;">{$item->s_dengjiname}</td>
                    <td style="font-size: 15px;">打款佣金:{$item->dkyj}</td>
                    <td style="font-size: 15px;">总计：{$item->cont}<br/>
                        {if $re01.c_cengji>=1}一级：{$item->cont01[0]}<br/>{/if} 
                        {if $re01.c_cengji>=2}二级：{$item->cont01[1]}<br/>{/if}
                        {if $re01.c_cengji>=3}三级：{$item->cont01[2]}<br/>{/if} 
                        {if $re01.c_cengji>=4}四级：{$item->cont01[3]}<br/>{/if}
                        {if $re01.c_cengji>=5}五级：{$item->cont01[4]}<br/>{/if} 
                    </td>
                    <td style="font-size: 15px;">
                        注册时间：{$item->Register_data}</br>代理时间：{$item->add_date}
                    </td>

                </tr>
                {/foreach}		
		</table>
	</body>

</html>