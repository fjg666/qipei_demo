<?php /* Smarty version 2.6.31, created on 2020-01-02 14:07:50
         compiled from Product_see.tpl */ ?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>修改产品</title>

    <link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css" />
    <link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_head.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <?php echo '
        <style type="text/css">
            form[name=form1]{padding: 0!important;}
            form[name=form1] input{margin-right: 0;}
            .set_center{
                background:#FF7F50;
                opacity: 0.9;
            }
            .attr_table td select {
                width: 40px !important;
            }
            .upload-preview .upload-preview-img {
                max-width: 100%;
                max-height: 100%;
                margin: auto auto;
                position: absolute;
                width: 100%;
                height: 100%;
            }
            p{margin-bottom: 0;}
            .texterror{
                width:35px;
                height:35px;
                margin-right: 0px!important;
            }
            .formDivSD{
                pointer-events: none;
                margin-bottom: 0px !important;
            }
            .formTitleSD{
                font-weight:bold;
                color:#414658;
                border-bottom: 2px solid #E9ECEF;
            }
            .formListSD{
                color:#414658;
            }
            .formTextSD{
                color:#888f9e;
            }

            .formContentSD{
                padding: 30px 60px 30px 60px;
            }
            .formTextSD{
                margin-right: 8px;
            }
            input[type=number]::-webkit-input-placeholder { /* WebKit browsers */
                color: #97A0B4;
            }
            .form_address{
                margin-right: 0px !important;
            }
        </style>
    '; ?>


</head>

<body class="body_bgcolor iframe-container">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_img.tpl", 'smarty_include_vars' => array('sitename' => 'DIY_IMG')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<nav class="nav-title">
    <span class="c-gray en"></span>
    插件管理
    <span class="c-gray en">&gt;</span>
    <a style="margin-top: 10px;color: #0a0a0a;text-decoration:none;"  href="javascript:history.back(-1)">商品审核 </a>
    <span class="c-gray en">&gt;</span>
    商品审核记录
</nav>

<div class="iframe-content" id="page" >
    <form class='form-scroll' name="form1" id="form1" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
">
        <input type="hidden" name="mch_id" class="mch_id" value="<?php echo $this->_tpl_vars['mch_id']; ?>
">
        <div class="formDivSD">
            <div class="formTitleSD">基本信息</div>
            <div class="formContentSD">
                <div class="formListSD">
                    <div class="formTextSD"><span class="must">*</span><span>商品标题：</span></div>
                    <div class="formInputSD"><?php echo $this->_tpl_vars['product_title']; ?>
</div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span>副标题：</span></div>
                    <div class="formInputSD"><?php echo $this->_tpl_vars['subtitle']; ?>
</div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="must">*</span><span>关键词：</span></div>
                    <div class="formInputSD"><?php echo $this->_tpl_vars['keyword']; ?>
</div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="must">*</span><span>重量：</span></div>
                    <div class="formInputSD"><?php echo $this->_tpl_vars['weight']; ?>
</div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="must">*</span><span>商品条形码：</span></div>
                    <div class="formInputSD"><?php echo $this->_tpl_vars['scan']; ?>
</div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="must">*</span><span>商品类别：</span></div>
                    <div class="formInputSD"><?php echo $this->_tpl_vars['product_class_name']; ?>
</div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="must">*</span><span>商品品牌：</span></div>
                    <div class="formInputSD">
                        <?php echo $this->_tpl_vars['brand_class_name']; ?>

                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="must">*</span><span>商品展示图：</span></div>
                    <div class="formInputSD upload-group multiple">
                        <div id="sortList" class="upload-preview-list uppre_auto">
                            <?php if ($this->_tpl_vars['imgurls']): ?>
                                <?php $_from = $this->_tpl_vars['imgurls']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f4'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f4']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item4']):
        $this->_foreach['f4']['iteration']++;
?>
                                    <div class="upload-preview form_new_img">
                                        <img src="<?php echo $this->_tpl_vars['item4']->product_url; ?>
" class="upload-preview-img">
                                        <div class="form_new_words <?php if ($this->_tpl_vars['item4']->is_center): ?>set_center<?php endif; ?>"><?php if ($this->_tpl_vars['item4']->is_center): ?>主图<?php else: ?>设为主图<?php endif; ?></div>
                                        <input type="hidden" name="imgurls[]" class="file-item-input" value="<?php echo $this->_tpl_vars['item4']->product_url; ?>
">
                                    </div>
                                <?php endforeach; endif; unset($_from); ?>
                            <?php else: ?>
                                <div class="upload-preview form_new_img" style="display: none;">
                                    <img src="images/iIcon/sha.png" class="form_new_sha file-item-delete-pp" />
                                    <img src="images/icon1/add_g_t.png" class="upload-preview-img">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="formSpaceSD"></div>
        </div>

        <div class="formDivSD">
            <div class="formTitleSD">商品属性</div>
            <div class="formContentSD">
                <?php echo '
                    <!-- 有规格 -->
                    <div >
                        <div class="arrt_bgcolor arrt_fiv">
                            <div v-if="attr_group_list && attr_group_list.length>0">
                                <table class="attr-table attr_table">
                                    <thead>
                                    <tr>
                                        <th v-for="(attr_group,i) in attr_group_list" v-if="attr_group.attr_list && attr_group.attr_list.length>0">
                                            {{attr_group.attr_group_name}}
                                        </th>
                                        <th>成本价</th>
                                        <th>原价</th>
                                        <th>售价</th>
                                        <th>库存</th>
                                        <th>单位</th>
                                        <th>上传图片</th>
                                    </tr>
                                    </thead>
                                    <tr v-for="(item,index) in checked_attr_list" class="arrt_tr">
                                        <input type="hidden"  v-bind:name="\'attr[\'+index+\'][cid]\'" :value="item.cid">
                                        <td v-for="(attr,attr_index) in item.attr_list">
                                            <input type="hidden"  v-bind:name="\'attr[\'+index+\'][attr_list][\'+attr_index+\'][attr_id]\'" v-bind:value="attr.attr_id">

                                            <input type="hidden" v-bind:name="\'attr[\'+index+\'][attr_list][\'+attr_index+\'][attr_name]\'" v-bind:value="attr.attr_name">

                                            <input type="hidden" v-bind:name="\'attr[\'+index+\'][attr_list][\'+attr_index+\'][attr_group_name]\'" v-bind:value="attr.attr_group_name">
                                            <span>{{attr.attr_name}}</span>
                                        </td>
                                        <td>
                                            {{item.costprice}}
                                        </td>
                                        <td>
                                            {{item.yprice}}
                                        </td>
                                        <td>
                                            {{item.price}}
                                        </td>
                                        <td>
                                            {{item.num}}
                                        </td>
                                        <td>
                                            {{item.unit}}
                                        </td>
                                        <td>
                                            <div  class="upload-group form_group form_flex">
                                                <div class="form_attr_img ">
                                                    <img :src="item.img" class="upload-preview-img form_att select-file">
                                                </div>
                                                <div class="input-group" style="display: none;">
                                                    {{item.img}}
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                '; ?>

            </div>
            <div class="formSpaceSD"></div>
        </div>

        <div class="formDivSD">
            <div class="formTitleSD">商品设置</div>
            <div class="formContentSD">
                <div class="form_li form_num formListSD">
                    <div class="form_new_l"><span>*</span>库存预警：</div>
                    <div class="form_new_r"><span class="form_li_one">当前库存量小于<?php echo $this->_tpl_vars['min_inventory']; ?>
</span><span class="form_li_one">时，商品库存报警</span></div>
                </div>

                <div class="form_li">
                    <div class="form_new_l"><span>*</span>运费设置：</div>
                    <div class="form_new_r">
                        <?php echo $this->_tpl_vars['freight_name']; ?>

                    </div>
                </div>

                <div class="form_li formListSD">
                    <div class="form_new_l"><span></span>排序号：</div>
                    <div class="formInputSD"><?php echo $this->_tpl_vars['sort']; ?>
</div>
                </div>
                <div class="form_li formListSD">
                    <div class="form_new_l"><span></span>显示标签：</div>
                    <div class="form_new_r"><?php echo $this->_tpl_vars['sp_type']; ?>

                    </div>
                </div>
                <div class="form_li">
                    <div class="form_new_l"><span>*</span>支持活动类型：</div>
                    <div class="form_new_r">
                        <div class="ra1">
                            <input name="active" onchange="active_select(this)" type="radio" <?php if ($this->_tpl_vars['active'] == 1): ?>checked="checked"<?php endif; ?> style="display: none;" id="active-1" class="inputC1" value="1">
                            <label for="active-1">正价</label>
                        </div>
                        <?php echo $this->_tpl_vars['Plugin_arr']['res1']; ?>

                    </div>
                </div>
                <?php echo $this->_tpl_vars['Plugin_arr']['res2']; ?>

                <div class="form_li formListSD" id="show_adr" <?php if ($this->_tpl_vars['active'] != 1): ?>style="display: none"<?php endif; ?>>
                    <div class="form_new_l"><span></span>前端显示位置：</div>
                    <div class="form_new_r"><?php echo $this->_tpl_vars['show_adr']; ?>
<span>（如果不选，默认显示在全部商品里）</span></div>
                </div>
                <div class="form_li">
                    <div class="form_new_l"><span></span>是否支持线下核销：</div>
                    <div class="form_new_r form_yes">
                        <div class="ra1">
                            <input name="is_hexiao" type="radio" <?php if ($this->_tpl_vars['is_hexiao'] == 1): ?>checked="checked"<?php endif; ?> style="display: none;" id="is_hexiao-1" class="inputC1" value="1">
                            <label for="is_hexiao-1">是</label>
                        </div>
                        <div class="ra1">
                            <input name="is_hexiao" type="radio" <?php if ($this->_tpl_vars['is_hexiao'] == 0): ?>checked="checked"<?php endif; ?> style="display: none;" id="is_hexiao-2" class="inputC1" value="0">
                            <label for="is_hexiao-2">否</label>
                        </div>
                    </div>
                </div>
                <div class="form_address" id="xd_hx" <?php if ($this->_tpl_vars['is_hexiao'] == 0): ?>style="display: none;"<?php endif; ?>>
                    <span>核销地址：<?php echo $this->_tpl_vars['hxaddress']; ?>
</span>
                </div>
            </div>
            <div class="formSpaceSD"></div>
        </div>

        <div class="formDivSD">
            <div class="formTitleSD">详细内容</div>
            <div class="formContentSD">
                <div class="formListSD">
                    <div class="formTextSD form_word"><span></span>商品详情：</div>
                    <div class="formInputSD">
                        <?php echo $this->_tpl_vars['content']; ?>

                    </div>
                </div>
            </div>
        </div>
		<div style='height: 70px;'></div>
        <div class="page_bort">
            <button type="button" onclick="javascript:history.back(-1);" class="bottomBtn backBtnSD btn-right" style="float: right;">返回</button>
        </div>
    </form>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/ueditor.tpl", 'smarty_include_vars' => array('sitename' => "ueditor插件")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array('sitename' => "公共底部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_footer.tpl", 'smarty_include_vars' => array('sitename' => "DIY底部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<script>
    var map = new Map();
    var page = new Vue({
        el: "#page",
        data: {
            sub_cat_list: [],
            attr_group_list: JSON.parse(\''; ?>
<?php echo $this->_tpl_vars['attr_group_list']; ?>
<?php echo '\', true), //可选规格数据
            attr_group_count: JSON.parse(\''; ?>
<?php echo $this->_tpl_vars['attr_group_list']; ?>
<?php echo '\', true).length,
            checked_attr_list: JSON.parse(\''; ?>
<?php echo $this->_tpl_vars['checked_attr_list']; ?>
<?php echo '\', true), //已选规格数据
            old_checked_attr_list: [],
            goods_card_list: [],
            card_list: [],
            goods_cat_list: [{
                "cat_id": null,
                "cat_name": null
            }],
            select_i: \'\',
            cbj:\'\',
            yj:\'\',
            sj:\'\',
            kucun:\'\'
        },
        methods: {
            change: function(item, index) {
                this.checked_attr_list[index] = item;
            }
        }
    });

    document.onkeydown = function(e) {
        if(!e) e = window.event;
        if((e.keyCode || e.which) == 13) {
            $("[name=Submit]").click();
        }
    }

</script>
'; ?>

</body>

</html>