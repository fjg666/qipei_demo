<?php /* Smarty version 2.6.31, created on 2019-12-30 19:34:24
         compiled from ./templateEditModel.tpl */ ?>
<div id="modal-edit" class="modal felxx" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 9999;">
  <div class="modal-dialog" style="z-index: 10000;height:100%;max-width: 920px;box-shadow:0 0px 0px 0px rgba(0, 0, 0, 0);display:flex;">
    <div id="print_html">
      <!-- <div class="modal-content radius box-modal" style="height:642px;" id="print_content">
        <div class="modal-header item-head">
          <h3 class="modal-title item-title" style="width: 100%;text-align: center;">商品/宝贝发货单</h3>
          <a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
        </div>
        <div style="width:919px;height:50px;background:rgba(240,242,244,1);">
          订单编号： LKT0023904934058358034
        </div>
        <div class="modal-body">

            <form name="form1" id="form1" class="form form-horizontal" method="post"   enctype="multipart/form-data" >

                <div class="row">
                  <label class=" col-xs-4 col-sm-2">买家：</label>
                  <span><input placeholder="买家昵称" class="col-sm-2 input-text radius"></span>
                  <span><input placeholder="买家账号" class="col-sm-2 input-text radius"></span>
                  <span><input placeholder="买家姓名" class="col-sm-2 input-text radius"></span>
                  <span><input placeholder="买家手机" class="col-sm-2 input-text radius"></span>
                </div>

                <div class="row">
                  <label class=" col-xs-2 col-sm-2">地址：</label>
                  <div class="col-xs-2 col-sm-2">
                    <span>
                      <select size="1" name="demo1">
                        <option value="" selected>湖南省</option>
                        <option value="1">菜单一</option>
                        <option value="2">菜单二</option>
                        <option value="3">菜单三</option>
                      </select>
                    </span>
                  </div>
                  <div class="col-xs-2 col-sm-2">
                    <span>
                      <select size="1" name="demo1">
                        <option value="" selected>长沙市</option>
                        <option value="1">菜单一</option>
                        <option value="2">菜单二</option>
                        <option value="3">菜单三</option>
                      </select>
                    </span>
                  </div>
                  <div class="col-xs-2 col-sm-2">
                    <span>
                      <select size="1" name="demo1">
                        <option value="" selected>岳麓区</option>
                        <option value="1">菜单一</option>
                        <option value="2">菜单二</option>
                        <option value="3">菜单三</option>
                      </select>
                    </span>
                  </div>
                  <div class="col-xs-4 col-sm-4">
                    <span>
                      <input placeholder="绿地中央广场5栋3408" class="input-text radius">
                    </span>
                  </div>
                </div>
            </form>
        </div>
        <div style="width:919px;height:6px;background:rgba(240,242,244,1);"></div>
        <div style="margin: 20px 40px;">
          <table class="table table-border table-bg table-bordered">
            <thead>
              <tr>
                <th>序号</th>
                <th>商品图片</th>
                <th>商品名称</th>
                <th>商品编码</th>
                <th>规格</th>
                <th>单价</th>
                <th>数量</th>
                <th>金额</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>01</td>
                <td>
                  <img src="http://ww2.sinaimg.cn/bmiddle/6af89bc8gw1f8ns3hre9rg203m02p3yl.gif" style="width:40px;height:40px"/>
                </td>
                <td>adidas 阿迪达斯 NEO板鞋 2018夏季新款运动帆布鞋</td>
                <td>sm1243635</td>
                <td>XL,白色</td>
                <td>￥50.00</td>
                <td>2</td>
                <td>￥100.00</td>
              </tr>
            </tbody>
          </table>

          <div style="display:flex;justify-content: space-between;">
            <div style="display:flex">
              <div>买家留言：</div>
              <div style="width: 520px;height: 72px;margin-left: 14px;">
                <input type="text" placeholder="写个贺卡" class="textarea radius" style="height: 72px;">
              </div>
            </div>
            <div style="width: 200px;">
              <div style="display: flex;justify-content: space-between;">商品总数：<span>6件</span></div>
              <div style="display: flex;justify-content: space-between;">商品总额：<span>￥300.00</span></div>
            </div>
          </div>
        </div>
        <div style="width:919px;height:6px;background:rgba(240,242,244,1);"></div>
        <div>
          <form name="form1" id="form1" class="form form-horizontal" method="post"   enctype="multipart/form-data" >
            <div class="row">
              <label class="col-xs-4 col-sm-2">卖家：</label>
              <div class="col-xs-10 col-sm-10">
                <span><input type="text" placeholder="买家昵称"/></span>
                <span><input type="text" placeholder="买家账号"/></span>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer" style="display:flex;">
          <span>谢谢您一如既往的支持小店，小店会继续努力！</span>
          <span>打印时间： 2019-7-23 09：42：21</span>
        </div>
      </div> -->
    </div>
  </div>
</div>
<?php echo '
<script type="text/javascript">
    // 打开模态框
    function editprint(){    
      $("#modal-edit").modal("show")
    }
</script>
'; ?>