<?php /* Smarty version 2.6.31, created on 2019-12-20 15:42:22
         compiled from Index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
	<style>
		td a{
			width: 44%;
			margin: 2%!important;
			float: left;
		}
		.newBtn{width: auto!important;}
		.handle1,.handle2,.handle3,.handle4{
			display: flex;align-items: center;justify-content: center;
			margin: 0!important;border-radius: 2px;
		}
		.handle1,.handle4{
			width: 56px;height: 22px;
		}
		.handle2,.handle3{
			width: 88px;height: 22px;
		}
		.handle1,.handle2{
			margin-bottom: 6px!important;
		}
		.handle1,.handle3{
			margin-right: 8px!important;
		}
		.tab_three{
			width: 145px;
		}
		.iframe-table .text-l{
			height: auto;
			min-height: 90px;
			padding: 20px 0;
		}
		.text-l p{
			line-height: 14px;
			padding-left: 75px;
		}
		.text-l p:last-child{
			margin-bottom: 0;
		}
		.iframe-table th{
			min-width: 100px;
		}
		.tab_time{
			width: 200px;
		}
	</style>
'; ?>

<div class="iframe-container">
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <div class="iframe-content">
		<div class="page_bgcolor">
			<button class="btn newBtn radius" onclick="location.href='index.php?module=client&action=Add';" >
				<div style="height: 100%;display: flex;align-items: center;font-size: 14px;">
					<img src="images/icon1/add.png"/>&nbsp;添加角色
				</div>
			</button>
		</div>
		<div class="page_h16"></div>
		<div class="iframe-table">
			<table class="table-border tab_content">
				<thead>
				<tr class="text-c tab_tr">
					<th class="tab_num">序号</th>
					<th>角色</th>
					<th>绑定商户</th>
					<th class="tab_time">添加时间</th>
					<th class="tab_three">操作</th>
				</tr>
				</thead>
				<tbody>
				<?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
					<tr class="text-c tab_tr">
						<td class="tab_num"><?php echo $this->_foreach['f1']['iteration']; ?>
</td>
						<td width="100px"><?php echo $this->_tpl_vars['item']->name; ?>
</td>
						<td class="text-l">
							<?php $_from = $this->_tpl_vars['item']->name_list; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f2'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f2']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item1']):
        $this->_foreach['f2']['iteration']++;
?>
								<p><?php echo $this->_tpl_vars['item1']; ?>
</p>
							<?php endforeach; endif; unset($_from); ?>
						</td>
						<td class="tab_time"><?php echo $this->_tpl_vars['item']->add_date; ?>
</td>
						<td class="tab_three" style="padding-left: 4px;">
							<a class="handle1" href="index.php?module=client&action=See&id=<?php echo $this->_tpl_vars['item']->id; ?>
" title="查看">
								<img src="images/icon1/ck.png" style="margin-top: -2px;"/>&nbsp;查看
							</a>
							<a class="handle2" href="index.php?module=client&action=Modify&id=<?php echo $this->_tpl_vars['item']->id; ?>
" title="权限修改" >
								<img src="images/icon1/xg.png" style="margin-top: -2px;"/>&nbsp;权限修改
							</a>
							<a class="handle3" title="绑定商户" onclick="_bind('<?php echo $this->_tpl_vars['item']->id; ?>
')">
								<img src="images/icon1/bind_s.png" style="margin-top: -2px;"/>&nbsp;绑定商户
							</a>
							<a class="handle4" href="javascript:void(0);" onclick="confirm('确定要删除这个角色吗?',<?php echo $this->_tpl_vars['item']->id; ?>
,'index.php?module=client&action=Del&id=','删除')">
								<img src="images/icon1/del.png" style="margin-top: -2px;"/>&nbsp;删除
							</a>
						</td>
					</tr>
				<?php endforeach; endif; unset($_from); ?>
				</tbody>
			</table>
		</div>
		<div class="tbtab" style="text-align: center;display: flex;justify-content: center;"><?php echo $this->_tpl_vars['pages_show']; ?>
</div>
	</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
	<script type="text/javascript">
        function confirm (content,id,url,content1){
            $("body",parent.document).append(`
                <div class="maskNew">
                    <div class="maskNewContent">
                        <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                        <div class="maskTitle">提示</div>
                        <div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
                        <div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
                            ${content}
                        </div>
                        <div style="text-align:center;margin-top:30px">
                            <button class="closeMask" style="margin-right:20px" onclick=closeMask("${id}","${url}","${content1}") >确认</button>
                            <button class="closeMask" onclick=closeMask1() >取消</button>
                        </div>
                    </div>
                </div>
            `)
        };

        function _bind(id){
            $.ajax({
                cache: true,
                type: "GET",
                dataType: "json",
                url: \'index.php?module=client&action=Bangding\',
                data: {
                    id:id,
                },
                async: true,
                success: function (data) {
                    var list1 = data.list1
                    var list2 = data.list2
                    var res1 = \'\';
                    var res2 = \'\';
                    if(list1.length > 0){
                        for(var i=0;i<list1.length;i++){
							res1 += `<label class="checkbox">
											<input name="chooseUser" checked="checked" type="checkbox" value="${list1[i].id}">
											<i></i>
											${list1[i].name}
										</label>`;

                        }
                    }
                    if(list2.length > 0){
                        for(var i=0;i<list2.length;i++){
                            res2 += `<tr>
										<td class="bind">
											<label class="checkbox">
												<input name="user" type="checkbox" value="${list2[i].id}">
												<i></i>
												${list2[i].name}
											</label>
										</td>
										<td class="bind">${list2[i].tel}</td>
									</tr>`;
                        }
                    }
                    var str = `<div class="mask-modal">
									<div style="width: 920px;height: 706px;">
										<p class="title">绑定商户</p>
										<div class="search">
											<input class="ipt" type="text" id="name" value="" placeholder="请输入需要绑定的商户名称">
											<input class="btn" type="button" value="查询">
										</div>
										<div class="table-scroll">
											<table>
												<tr>
													<th class="bind">商户名称</th>
													<th class="bind">手机号</th>
												</tr>
												${res2}
											</table>
										</div>
										<p class="mTitle">已绑定商户</p>
										<div class="chooseUser">
											<div>${res1}</div>
										</div>
										<div class="bottom">
											<input class="btn-right" type="button" value="确认绑定">
											<input class="btn-left" type="button" value="取消">
										</div>
									</div>
								</div>`
                    $(\'body\',parent.document).append(str)

                    $(\'body\',parent.document).find(\'.mask-modal .btn\').on(\'click\',function(){
                        var name = $(\'body\',parent.document).find(\'.mask-modal #name\').val()
                        sousuo(id,name)
                    })

                    $(\'body\',parent.document).find(\'.mask-modal .btn-left\').on(\'click\',function(){
                        $(this).parents(\'.mask-modal\').remove()
                        $(\'body\',parent.document).find(\'.mask-modal .btn-left\').off()
                    })
                    // 以下为确认绑定按钮
                    $(\'body\',parent.document).find(\'.mask-modal .btn-right\').on(\'click\',function(){
                        var _check = $(this).parents(\'.mask-modal\').find(\'[name=user]:checked\')
                        var _check1 = $(this).parents(\'.mask-modal\').find(\'[name=chooseUser]:checked\')
						var _val = []
                        var _val1 = []
						for(var i=0;i<_check.length;i++){
                            _val.push($(_check).eq(i).val())
						}
                        for(var i=0;i<_check1.length;i++){
                            _val1.push($(_check1).eq(i).val())
                        }
                        $.ajax({
                            cache: true,
                            type: "GET",
                            dataType: "json",
                            url: \'index.php?module=client&action=Bangding&m=yanzheng\',
                            data: {
                                id:id,
                                list:_val,
                            },
                            async: true,
                            success: function (rew) {
                                if(rew.status == 1){
									tijiao(id,_val,_val1)
                                }else if(rew.status == 2){
                                    tishi(id,_val,_val1)
								}else{
                                    layer.msg(rew.msg, {time: 1000});
                                    $(this).parents(\'.mask-modal\').remove()
                                    $(\'body\',parent.document).find(\'.mask-modal .btn-right\').off()
                                }
                            }
                        })

                    })
                }
            });
        }
        // 搜索
        function sousuo(id,name) {
            $.ajax({
                cache: true,
                type: "GET",
                dataType: "json",
                url: \'index.php?module=client&action=Bangding&m=sousuo\',
                data: {
                    id:id,
                    name:name,
                },
                async: true,
                success: function (data) {
                    var list = data.list
                    var res = `<table>
                                    <tr>
                                        <th class="bind">商户名称</th>
                                        <th class="bind">手机号</th>
                                    </tr>`;
                    $(\'body\',parent.document).find(\'.mask-modal .table-scroll\').empty()

                    if(list.length > 0){
                        for(var i=0;i<list.length;i++){
                            res += `<tr>
										<td class="bind">
											<label class="checkbox">
												<input name="user" type="checkbox" value="${list[i].id}">
												<i></i>
												${list[i].name}
											</label>
										</td>
										<td class="bind">${list[i].tel}</td>
									</tr>`;
                        }
                    }
                    res += `</table>`;
                    $(\'body\',parent.document).find(\'.mask-modal .table-scroll\').append(res)
                }
            })
        }
        // 弹窗-警示语
        function tishi(id,_val,_val1){
            var str=`<div class="mask-modal">
						<div style="min-height: 222px;">
							<p style="width: 345px;margin: 0 auto;text-align: center;margin-top: 58px;font-size: 16px;margin-bottom: 24px;">商户已被绑定，继续执行绑定操作将修改商户绑定角色，是否确认操作？</p>
							<div style="display: flex;align-items: center;justify-content: center;">
								<input class="btn-left cancel" type="button" value="取消" style="float: none;">
								<input class="btn-right" type="button" value="确认" style="float: none;margin-right: 0;">
							</div>
						</div>
					</div>
					`
            $(\'body\',parent.document).append(str)
            $(\'body\',parent.document).find(\'.mask-modal .cancel\').on(\'click\',function(){
                $(this).parents(\'.mask-modal\').remove()
                $(\'body\',parent.document).find(\'.mask-modal .cancel\').off()
            })
            // 以下为确认绑定按钮
            $(\'body\',parent.document).find(\'.mask-modal [value="确认"]\').on(\'click\',function(){
                $(this).parents(\'.mask-modal\').remove()
                $(\'body\',parent.document).find(\'.mask-modal [value="确认"]\').off()

                tijiao(id,_val,_val1)
            })
        }
        // 确认绑定
        function tijiao(id,list,list1) {
            $.ajax({
                cache: true,
                type: "POST",
                dataType: "json",
                url: \'index.php?module=client&action=Bangding\',
                data: {
                    id:id,
                    list:list,
                    list1:list1,
                },
                async: true,
                success: function (data) {
                    layer.msg(data.status, {time: 2000});
                    $(\'body\',parent.document).find(\'.mask-modal\').remove()
                    $(\'body\',parent.document).find(\'.mask-modal .btn-right\').off()
                    if (data.suc) {
                        location.href = "index.php?module=client";
                    }

                }
            })
        }
	</script>
'; ?>

</body>
</html>