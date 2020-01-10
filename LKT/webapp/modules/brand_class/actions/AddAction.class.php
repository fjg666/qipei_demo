<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class AddAction extends Action {

	public function getDefaultView() {
		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 项目id

        // 查询国家
        $sql0 = "select id,zh_name from lkt_ds_country where is_show = 1";
        $r0 = $db->select($sql0);

        $request->setAttribute("list",$r0);
		return View :: INPUT;
	}

	public function execute(){
		$db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/brand_class.log");

        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        // 1.开启事务
        $db->begin();
        // 获取分类名称和排序号
        $brand_name = addslashes(trim($request->getParameter('brand_name'))); // 品牌名称
        $image = addslashes(trim($request->getParameter('image'))); // 品牌图片
        $categories = addslashes(trim($request->getParameter('categories_str'))); // 所属分类
        $producer = addslashes(trim($request->getParameter('producer'))); // 产地
        $remarks = addslashes(trim($request->getParameter('remarks'))); // 备注
        if (!empty($image)) {
            $image = preg_replace('/.*\//', '', $image);
        } else {
            echo json_encode(array('status' => '品牌logo不能为空！'));
            exit;
        }

        if($brand_name == ''){
            echo json_encode(array('status' =>'品牌名称不能为空！' ));exit;
        }
		//检查分类名称是否重复
        $sql = "select * from lkt_brand_class where store_id = '$store_id' and brand_name = '$brand_name' and recycle = 0 ";
        $r = $db->select($sql);
		// 如果有数据 并且 数据条数大于0
        if ($r && count($r) > 0) {
        	echo json_encode(array('status' =>'商品品牌名称('.$brand_name.') 已经存在，请选用其他名称！' ));exit;
        }
        if($categories == '' || $categories == 0){
            echo json_encode(array('status' =>'所属分类不能为空！' ));exit;
        }else{
            $categories = trim($categories,',');
            $categories = ','.$categories.',';
        }
        if($producer == 0){
            echo json_encode(array('status' => '请选择所属国家！'));
            exit;
        }

		//添加分类
        $sql = "insert into lkt_brand_class(store_id,brand_name,brand_pic,producer,remarks,brand_time,sort,categories) "
            ."values('$store_id','$brand_name','$image','$producer','$remarks',CURRENT_TIMESTAMP,100,'$categories')";
		$r = $db->insert($sql);
		if($r == -1) {
            $JurisdictionAction->admin_record($store_id,$admin_name,'添加商品品牌'.$brand_name.'失败',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加商品品牌失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('status' =>'未知原因，添加产品品牌失败！' ));exit;
		} else {
            $JurisdictionAction->admin_record($store_id,$admin_name,'添加商品品牌'.$brand_name,1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加商品品牌成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

            echo json_encode(array('status' =>'添加产品品牌成功！','suc'=>"1" ));exit;
		}
		return;
	}

	public function getRequestMethods(){
		return Request :: POST;
	}
}

?>