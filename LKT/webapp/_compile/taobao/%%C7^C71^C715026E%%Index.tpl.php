<?php /* Smarty version 2.6.31, created on 2019-12-30 10:50:39
         compiled from Index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<style type="text/css">
    .tab_td td{
        height: auto;
        padding: 0;
    }
    .formInputDiv{
        display: flex;
        width: 334px;
        border: 1px solid #D5DBE8;
    }
    .formInputDiv ul{width: 334px;margin: 0;height: 171px;overflow-y: scroll;}
    .formInputDiv ul:not(:last-child){border-right: 1px solid #D5DBE8;}
    .formInputDiv li{height: 30px;line-height: 30px;cursor: pointer;font-size: 14px;color: #6A7076;user-select:none;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;padding: 0 12px;}
    .formInputDiv li:hover{color: #0880FF;}
    .formInputDiv .active{position: relative;background: #0880FF;color: #fff!important;}

    .selectDiv{position: relative;width: 334px;height: 36px;}
    .selectDiv>div{position: absolute;top:0;left: 0;width: 100%;height: 100%;display: flex;align-items: center;padding-left: 12px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;padding-right: 15px;}
    .selectDiv p{margin-bottom: 0;}
    .selectItem span{margin: 0 5px;}

    .yuans {width:20px;height:20px;border:1px solid rgba(40,144,255,1);border-radius:50%;display: flex;align-items: center;justify-content: center;color:rgba(40,144,255,1);font-size:16px;font-weight:400;}

    ul >li {
        color:#6A7076;
        font-size:14px;
        margin: 2px 0px;
    }
</style>
'; ?>

<div class="page-container page_absolute pd-20">
    <div style="clear:both;margin-top:0!important;background-color: #edf1f5;" class="btnDiv">
        <a class="btn btn1 radius" id="btn1" style="background-color:#38b4ed;color: #fff;height: 36px;" href="javascript:;" onclick="showMdel()">
            <div style="height: 100%;display: flex;align-items: center;">
                <img src="images/icon1/add.png"/>&nbsp;添加任务
            </div>
        </a>
    </div>
    <div class="page_h16"></div>
    <div class="tab_table">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th class="tab_num">任务ID</th>
                    <th>任务标题</th>
                    <th>任务状态</th>
                    <th>创建时间</th>
                    <th>执行时间</th>
                    <th class="tab_editor">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
                <tr class="text-c tab_td">
                    <td><?php echo $this->_tpl_vars['item']->id; ?>
</td>
                    <td><?php echo $this->_tpl_vars['item']->title; ?>
</td>
                    <td>
                        <?php if ($this->_tpl_vars['item']->status == 0): ?>
                            待抓取
                        <?php elseif ($this->_tpl_vars['item']->status == 1): ?>
                            <font style="color: green;">抓取中</font>
                        <?php elseif ($this->_tpl_vars['item']->status == 2): ?>
                            <font style="color: #ddd;">抓取成功</font>
                        <?php else: ?>
                            <font style="color: red;">抓取失败</font>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $this->_tpl_vars['item']->creattime; ?>
</td>
                    <td><?php echo $this->_tpl_vars['item']->add_date; ?>
</td>
                    <td class="tab_editor">
                        <?php if ($this->_tpl_vars['button'][0] == 1): ?>
                            <div class="tab_block">
                                <a href="index.php?module=taobao&action=See&id=<?php echo $this->_tpl_vars['item']->id; ?>
" title="查看详情" style="width: 88px;">
                                    <img src="images/icon1/ck.png"/>&nbsp;查看详情
                                </a>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; endif; unset($_from); ?>
            </tbody>
        </table>
    </div>
    <div class="tab_footer" style="position: fixed!important;"><?php echo $this->_tpl_vars['pages_show']; ?>
</div>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
    <script type="text/javascript">
        function showMdel(){
            $("body").append(`
                <div class="maskNew">
                    <div class="maskNewContent" style="width: 680px;height: 734px !important;top: 6%;border-radius: 4px;">

                        <div style="border-bottom: 2px solid #E9ECEF;height: 48px;line-height: 40px;">
                            <div style="font-size: 16px;margin-left: 19px;">添加任务</div>
                            <a href="javascript:void(0);" class="closeA" onclick=closeMask1() style="display: block;top:22px"><img src="images/icon1/gb.png"/></a>
                        </div>

                        <div style="height: 570px;overflow: auto;" >


                            <div style="width: 600px;margin: 0 auto;margin-top: 40px;">
                                <div style="height:44px;background:#F4F7F9;display:flex;justify-content: space-between;align-items: center;padding: 0px 10px;border-radius:2px;">
                                    <div style="font-size:14px;color:#414658;font-weight:bold;">操作流程</div>
                                    <div id="tops" style="display: none;" onclick="flow(1)">
                                        <img src="./images/taobaotop.png" />
                                    </div>
                                    <div id="bottoms" onclick="flow(2)">
                                        <img src="./images/taobaobottom.png"/>
                                    </div>
                                </div>
                                <div id="flows" style="height:76px;background:#F4F7F9;display: flex;padding: 0px 16px;border-radius: 2px;display: none;">

                                    <div style="display: flex;flex-direction: column;align-items: center;width:110px;">
                                        <div class="yuans">1</div>
                                        <i style="margin-top: 12px;font-style: inherit;font-weight:400;color:rgba(106,112,118,1);font-size:14px;">创建抓取任务</i>
                                    </div>

                                    <div style="margin: 0px 20px;padding-top: 14px;">
                                        <img style="width: 14px;height: 20px;" src="./images/taobao/x_right.png" />
                                    </div>

                                    <div style="display: flex;flex-direction: column;align-items: center;width:110px;">
                                        <div class="yuans">
                                            2
                                        </div>
                                        <i style="margin-top: 12px;font-style: inherit;font-weight:400;color:rgba(106,112,118,1);font-size:14px;">执行抓取任务</i>
                                    </div>

                                    <div style="margin: 0px 20px;padding-top: 14px;">
                                        <img style="width: 14px;height: 20px;" src="./images/taobao/x_right.png" />
                                    </div>

                                    <div style="display: flex;flex-direction: column;align-items: center;width:110px;">
                                        <div class="yuans">
                                            3
                                        </div>
                                        <i style="margin-top: 12px;font-style: inherit;font-weight:400;color:rgba(106,112,118,1);font-size:14px;">查看抓取结果</i>
                                    </div>
                                    <div style="margin: 0px 20px;padding-top: 14px;">
                                        <img style="width: 14px;height: 20px;" src="./images/taobao/x_right.png" />
                                    </div>

                                    <div style="display: flex;flex-direction: column;align-items: center;width:76px;">
                                        <div class="yuans">
                                            4
                                        </div>
                                        <i style="margin-top: 12px;font-style: inherit;font-weight:400;color:rgba(106,112,118,1);font-size:14px;">商品上架</i>
                                    </div>
                                    <div style="margin: 0px 20px;padding-top: 14px;">
                                        <img style="width: 14px;height: 20px;" src="./images/taobao/x_right.png" />
                                    </div>

                                    <div style="display: flex;flex-direction: column;align-items: center;width:55px;">
                                        <div class="yuans">
                                            5
                                        </div>
                                        <i style="margin-top: 12px;font-style: inherit;font-weight:400;color:rgba(106,112,118,1);font-size:14px;">入库</i>
                                    </div>
                                </div>
                            </div>


                            <div class="formListSD" style="margin-bottom: 14px;margin-top: 40px;">
                                <div class="formTextSD" style=\'height: 36px;font-size: 14px;\'><span class="must">*</span><span>任务名称：</span></div>
                                <div class="formInputSD" style=\'display: block;\'>
                                    <div class=\'selectDiv\'>
                                        <input name=\'title\' id=\'title\' type=\'text\' class="select" style=\'height: 36px;width: 334px;\' placeholder="请输入任务名称">
                                    </div>
                                </div>
                            </div>
                            <div class="formListSD" style="margin-bottom: 14px;">
                                <div class="formTextSD" style=\'height: 36px;font-size: 14px;\'><span class="must">*</span><span>商品类别：</span></div>
                                <div class="formInputSD" style=\'display: block;\'>
                                    <div class=\'selectDiv\' onclick="select_class()">
                                        <select name="product_class" id="product_class" class="select" readonly="readonly" style=\'height: 36px;width: 334px;\'>
                                            <option selected="selected" value="0">请选择商品类别</option>
                                        </select>
                                        <div id="div_text" style="font-size: 14px;">

                                        </div>
                                    </div>
                                    <div id=\'selectData\' class=\'formInputDiv\' style=\'display: none;\'>
                                        <ul id="selectData_1">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="formListSD" style="margin-bottom: 14px;">
                                <div class="formTextSD" style="font-size: 14px;"><span class="must">*</span><span>商品品牌：</span></div>
                                <div class="formInputSD" onclick="select_pinpai()">
                                    <select name="brand_class" class="select" id="brand_class" style="height: 36px;width: 334px;">
                                        <option selected="selected" value="0">请选择商品品牌</option>
                                    </select>
                                </div>
                            </div>

                            <div id="num">
                                <div class="formTextSD" style="font-size: 14px;float: left;height: 36px;line-height: 36px;"><span class="must">*</span><span>宝贝链接：</span></div>
                                <div class="formListSD" id="num_1" style="margin-bottom: 14px;">
                                    <div class="formInputSD" >
                                        <input type="text" value="" name="url[]" class="link"  style="width: 454px;" placeholder="请复制要抓取的宝贝链接">
                                    </div>
                                    <div class="btn " onclick="del(1)" style="border: 0px solid #fff;line-height: 26px;padding-left: 10px;padding-right: 0px;"><img src="./images/iIcon/jian.png" style="width: 100%;margin-right:0"></div>
                                    <div class="btn addBtn" onclick="add(1)" style="border: 0px solid #fff;line-height: 26px;padding-left: 8px;"><img src="./images/iIcon/jia.png"  style="width: 100%;margin-right:0"></div>
                                </div>
                            </div>

                            <div style="width: 600px;height:184px;margin: 0 auto;margin-top: 40px;border-radius:2px;background:rgba(244,247,249,1);">
                                <div style="height:42px;font-weight:bold;color:rgba(106,112,118,1);font-size:14px;padding:0px 11px;display: flex;align-items: center;">
                                    温馨提示：
                                </div>
                                <ul style="padding: 0px 20px;">
                                    <li><span style="font-size:16px;color:#2890FF;font-weight:400;margin-right: 6px;">①</span>宝贝链接必须复制淘宝商品详情地址，填写错误地址及格式则无法创建任务。</li>
                                    <li><span style="font-size:16px;color:#2890FF;font-weight:400;margin-right: 6px;">②</span>任务创建成功后，须先排队再执行，整个过程将在3-5分种内自动完成，请耐心等待！</li>
                                    <li><span style="font-size:16px;color:#2890FF;font-weight:400;margin-right: 6px;">③</span>任务执行成功后，可在查看详情中查看执行结果。</li>
                                    <li><span style="font-size:16px;color:#2890FF;font-weight:400;margin-right: 6px;">④</span>抓取成功的商品将在商品列表中显示，默认状态为待上架。</li>
                                    <li><span style="font-size:16px;color:#2890FF;font-weight:400;margin-right: 6px;">⑤</span>商品上架成功后，将会自动按库存入库。</li>
                                <ul>
                            </div>
						</div>

                        <div style="text-align:right;height: 69px;border-top: 1px solid #E9ECEF;line-height: 69px;margin-top: 30px;">
                            <button class="closeMask" onclick=closeMask1() style="margin-right:10px;border: 1px solid #008DEF;border-radius: 2px;background: #fff;color: #008DEF;">取消</button>
                            <button onclick=check() class="closeMask"  style="margin-right:40px;border: 1px solid #008DEF;border-radius: 2px;background: #008DEF;color: #fff;" >添加</button>
                        </div>
                    </div>
                </div>
            `)
            $("#parentmask",parent.document).css(\'display\',\'block\');
            $(".Hui-article-box",parent.document).css(\'z-index\',\'99999999\');
        }
        // 点击分类框
        var selectFlag = true  //判断点击分类框请求有没有完成,没完成继续点击不会再次请求
        var choose_class = true  //判断选择分类请求有没有完成,没完成继续点击不会再次请求
        function select_class(){
            var class_str = $(\'.selectDiv option\').val()
            var brand_str = $("#brand_class option:selected").val();
            if($(\'#selectData\').css(\'display\')==\'none\'){
                $(\'#selectData\').css(\'display\',\'flex\')

                if(selectFlag&&choose_class){
                    selectFlag=false
                    $.ajax({
                        type: "GET",
                        url: \'index.php?module=product&action=Ajax\',
                        data: {
                            \'class_str\':class_str,
                            \'brand_str\':brand_str
                        },
                        success: function (msg) {
                            // $(\'#brand_class\').empty()
                            $(\'#selectData_1\').empty()
                            obj = JSON.parse(msg)
                            var brand_list = obj.brand_list
                            var class_list = obj.class_list
                            var rew = \'\';
                            if(class_list.length != 0){
                                var num = class_list.length-1;
                                display(class_list[num])
                            }

                            for(var i=0;i<brand_list.length;i++){
                                if(brand_list[i].status == true){
                                    rew += `<option selected value="${brand_list[i].brand_id}">${brand_list[i].brand_name}</option>`;
                                }else{
                                    rew += `<option value="${brand_list[i].brand_id}">${brand_list[i].brand_name}</option>`;
                                }
                            }
                            // $(\'#brand_class\').append(rew)
                        },
                        complete(XHR, TS){
                            // 无论请求成功还是失败,都要把判断条件改回去
                            selectFlag=true
                        }
                    });
                }
            }else{
                $(\'#selectData\').css(\'display\',\'none\')
            }
        }
        // 选择分类
        function class_level(obj,level,cid,type){
            var text = obj.innerHTML
            var text_num = $(\'.selectDiv>div>p\').length

            $(\'.selectDiv option\').text(\'\').attr(\'value\',cid)

            $(obj).addClass(\'active\').siblings().removeClass(\'active\')
            var brand_str = $("#brand_class option:selected").val();
            // 给当前元素添加class，清除同级别class
            // 获取ul标签数量
            var num = $("#selectData ul").length;
            if(selectFlag&&choose_class){
                choose_class=false
                $.ajax({
                    type: "POST",
                    url: \'index.php?module=product&action=Ajax\',
                    data: {
                        "cid":cid,
                        "brand_str":brand_str,
                    },
                    success: function (msg) {
                        $(\'#brand_class\').empty()
                        $(\'#selectData_1\').empty()
                        res = JSON.parse(msg)
                        var class_list = res.class_list
                        var brand_list = res.brand_list
                        var rew = \'\';
                        var html = $(\'.selectDiv>div\').html().replace(/^\\s*|\\s*$/g,"");// 去除字符串内两头的空格

                        if(type == \'\'){
                            if(text_num - 2 == level){
                                var text_num1 = text_num - 1;
                                var parent=document.getElementById("div_text");
                                var son0=document.getElementById("p"+text_num);
                                var son1=document.getElementById("p"+text_num1);
                                parent.removeChild(son0);
                                parent.removeChild(son1);
                                if(class_list.length == 0){ // 该分类没有下级
                                    if(html==\'\'){
                                        str=`<p class=\'selectItem\' id=\'p1\' tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'>${text}</p><p class=\'selectItem del_sel\' id=\'p2\' onclick=\'del_sel(this)\'></p>`
                                    }else{
                                        $(\'.del_sel\').remove()
                                        str=`<p class=\'selectItem\' id="p${text_num1}" tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'><span>&gt;</span>${text}</p><p class=\'selectItem del_sel\' id=\'p${text_num1+1}\' onclick=\'del_sel(this)\'></p>`
                                    }
                                    $(\'#selectData\').css(\'display\',\'none\')
                                }else{
                                    display(class_list[0])
                                    if(html==\'\'){
                                        str=`<p class=\'selectItem\' id=\'p1\' tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'>${text}</p><p class=\'selectItem del_sel\' id=\'p2\' onclick=\'del_sel(this)\'><span>&gt;</span>请选择</p>`
                                    }else{
                                        $(\'.del_sel\').remove()
                                        str=`<p class=\'selectItem\' id="p${text_num1}" tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'><span>&gt;</span>${text}</p><p class=\'selectItem del_sel\' id="p${text_num1+1}" onclick=\'del_sel(this)\'><span>&gt;</span>请选择</p>`
                                    }
                                }
                            }else{
                                if(class_list.length == 0){ // 该分类没有下级
                                    if(html==\'\'){
                                        str=`<p class=\'selectItem\' id=\'p1\' tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'>${text}</p><p class=\'selectItem del_sel\' id=\'p2\' onclick=\'del_sel(this)\'></p>`
                                    }else{
                                        $(\'.del_sel\').remove()
                                        str=`<p class=\'selectItem\' id="p${text_num}" tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'><span>&gt;</span>${text}</p><p class=\'selectItem del_sel\' id=\'p${text_num+1}\' onclick=\'del_sel(this)\'></p>`
                                    }
                                    $(\'#selectData\').css(\'display\',\'none\')
                                }else{
                                    display(class_list[0])
                                    if(html==\'\'){
                                        str=`<p class=\'selectItem\' id=\'p1\' tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'>${text}</p><p class=\'selectItem del_sel\' id=\'p2\' onclick=\'del_sel(this)\'><span>&gt;</span>请选择</p>`
                                    }else{
                                        $(\'.del_sel\').remove()
                                        str=`<p class=\'selectItem\' id="p${text_num}" tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'><span>&gt;</span>${text}</p><p class=\'selectItem del_sel\' id="p${text_num+1}" onclick=\'del_sel(this)\'><span>&gt;</span>请选择</p>`
                                    }
                                }
                            }
                            $(\'.selectDiv>div\').append(str)
                        }else{
                            display(class_list[0])
                        }

                        for(var i=0;i<brand_list.length;i++){
                            if(brand_list[i].status == true){
                                rew += `<option selected value="${brand_list[i].brand_id}">${brand_list[i].brand_name}</option>`;
                            }else{
                                rew += `<option value="${brand_list[i].brand_id}">${brand_list[i].brand_name}</option>`;
                            }
                        }
                        $(\'#brand_class\').append(rew)
                    },
                    complete(XHR, TS){
                        // 无论请求成功还是失败,都要把判断条件改回去
                        choose_class=true
                    }
                });
            }
        }
        // 显示分类
        function display(class_list) {
            var res = \'\';
            for(var i=0;i<class_list.length;i++){
                if(class_list[i].status == true){
                    res += `<li class=\'active\' value=\'${class_list[i].cid}\' onclick="class_level(this,${class_list[i].level},${class_list[i].cid},\'\')">${class_list[i].pname}</li>`;
                    continue
                }
                res += `<li value=\'${class_list[i].cid}\' onclick="class_level(this,${class_list[i].level},${class_list[i].cid},\'\')">${class_list[i].pname}</li>`;
            }
            $(\'#selectData_1\').append(res)
        }
        // 删除选中的类别
        function del_sel(me,level,cid){
            if(cid){
                if(level == 0){
                    var cid1 = 0;
                    class_level(me,level,cid1,\'type\')
                }else{
                    var cid1 = $(\'#p\'+level).eq(0).attr(\'tyid\');
                    class_level(me,level-1,cid1,\'type\')
                }
                $(me).nextAll().remove()
                $(me).remove()
                if($(\'.selectDiv>div\').html()==\'\'){
                    $(\'.selectDiv option\').text(\'请选择商品类别\').attr(\'value\',0)
                }else{
                    if(cid1 == 0){
                        $(\'.selectDiv option\').text(\'请选择商品类别\').attr(\'value\',cid1)
                    }else{
                        $(\'.selectDiv option\').text(\'\').attr(\'value\',cid1)
                        $(\'.selectDiv>div\').append(`<p class=\'selectItem del_sel\' onclick=\'del_sel(this)\'><span>&gt;</span>请选择</p>`)
                    }
                }
                if(level){
                    event.stopPropagation()
                }
            }
        }

        function select_pinpai(){
            var class_str = $("[name=product_class]").val();
            console.log(class_str);
            if(class_str == \'\' || class_str <= 0){
                layer.msg("请先选择商品类别！", {
                    time: 2000
                });
            }
        }

        function add(num) {
            num++;
            var rew = \'\';
            rew = `<div class=\'formListSD\' id=\'num_${num}\' style="margin-left: 130px;margin-bottom: 14px;">` +

                `<div class=\'formInputSD\'>`+
                `<input type=\'text\' value=\'\' name=\'url[]\' class="link" style=\'width: 454px;\' placeholder="请复制要抓取的宝贝链接">` +
                `</div>` +
                `<div class="btn " onclick="del(${num})" style="border: 0px solid #fff;line-height: 26px;padding-left: 10px;padding-right: 0px;"><img src="./images/iIcon/jian.png" style="width: 100%;margin-right:0"></div>`+
                `<div class="btn addBtn" onclick="add(${num})" style="border: 0px solid #fff;line-height: 26px;padding-left: 8px;"><img src="./images/iIcon/jia.png"  style="width: 100%;margin-right:0"></div>`+
                `</div>`;
            $(\'.addBtn\').css(\'display\',\'none\')
            $("#num").append(rew);
        }
        function del(i) {
            if ($(\'.addBtn\').length > 1) {
                $(\'#num_\' + i).remove();
                $(\'#num1\').next().find(\'.hint\').remove()
                $(\'.addBtn\').eq($(\'.addBtn\').length-1).css(\'display\',\'block\')
            }
        }

        function closeMask1() {
            $(".maskNew").remove();
            $("#parentmask",parent.document).css(\'display\',\'none\');
            $(".Hui-article-box",parent.document).css(\'z-index\',\'0\');
        }

        document.onkeydown = function (e) {
            if (!e) e = window.event;
            if ((e.keyCode || e.which) == 13) {
                $("[name=Submit]").click();
            }
        }
        
        function check() {
            var title=$(\'.maskNewContent\').find(\'#title\').val()
            var product_class=$(\'.maskNewContent\').find(\'#product_class\').val()
            var brand_class=$(\'.maskNewContent\').find(\'#brand_class\').val()
            var link_num=$(\'.maskNewContent\').find(\'.addBtn\').length

            if ($(\'#title\').val() == \'\') {
                layer.msg("请填写任务标题！");
                return;
            }

            if ($(\'#product_class\').val() == 0) {
                layer.msg("请选择商品分类！");
                return;
            }

            if ($(\'#brand_class\').val() == 0) {
                layer.msg("请选择商品品牌！");
                return;
            }

            var link=[]
            for (var i=1;i<=link_num;i++) {
                console.log($(\'.maskNewContent\').find(\'#num_\'+i+ \' .link\').val());
                if($(\'.maskNewContent\').find(\'#num_\'+i+ \' .link\').val() == \'\'){
                    layer.msg("请填写想要抓取的淘宝商品链接！");
                    return;
                }
                link.push($(\'.maskNewContent\').find(\'#num_\'+i+ \' .link\').val())
            }

            $.ajax({
                cache: true,
                type: "POST",
                dataType:"json",
                url:\'index.php?module=taobao\',
                data:{
                    title:title,
                    cid:product_class,
                    brand_id:brand_class,
                    link:link,
                },
                async: true,
                success: function(data) {
                    layer.msg(data.msg,{time:2000},function() {
                        // 关闭弹窗
                        if(data.suc){
                            location.reload();
                            $("#parentmask",parent.document).css(\'display\',\'none\');
                            $(".Hui-article-box",parent.document).css(\'z-index\',\'0\');
                        }
                    });
                }
            });
        }

        function flow(type){
            if(type === 2){
                $(\'#flows\').css(\'display\',\'flex\')
                $(\'#tops\').show()
                $(\'#bottoms\').hide()
            } else {
                $(\'#flows\').css(\'display\',\'none\')
                $(\'#tops\').hide()
                $(\'#bottoms\').show()
            }
        } 
    </script>
'; ?>

</body>
</html>