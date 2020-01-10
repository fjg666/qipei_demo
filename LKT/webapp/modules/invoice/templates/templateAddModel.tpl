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
                      <select id="selectid" class="select" size="1" name="tempname">
                        <option value="" selected>请选择模板名称</option>
                        <option value="1">菜单一</option>
                        <option value="2">菜单二</option>
                        <option value="3">菜单三</option>
                      </select>
                    </div>
                    <div class="col-xs-1 col-sm-1 model-line"></div>
                    <div class="col-xs-4 col-sm-5 card-right">
                      <div class="right-effect">

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
{literal}
<script type="text/javascript">
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
    // 保存
    function addcheck(){

    }
</script>
{/literal}