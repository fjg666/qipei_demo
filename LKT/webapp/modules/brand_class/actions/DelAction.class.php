<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class DelAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/brand_class.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $brand_id = intval($request->getParameter('cid')); // 品牌id

        $sql = "select * from lkt_brand_class where store_id = '$store_id' and brand_id = '$brand_id'";
        $r = $db->select($sql);
        $brand_pic = ServerPath::getimgpath($r[0]->brand_pic,$store_id);
        @unlink ($brand_pic);

        $sql = "select id from lkt_product_list where store_id = '$store_id' and recycle = 0 and brand_id = '$brand_id'";
        $r = $db->select($sql);
        if($r){
            $JurisdictionAction->admin_record($store_id,$admin_name,' 删除商品品牌ID为 '.$brand_id.' 失败',3);

            echo json_encode(array('status' =>'2','info'=>'品牌正在使用，删除失败！' ));exit;
        }
        // 根据分类id,删除这条数据
        $sql = "update lkt_brand_class set recycle = 1 where brand_id = '$brand_id'";
        $res = $db->update($sql);

		if($res > 0){
            $JurisdictionAction->admin_record($store_id,$admin_name,' 删除商品品牌ID为 '.$brand_id.' 的信息',3);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除品牌ID为'.$brand_id.'成功';
            $lktlog->customerLog($Log_content);

            $db->commit();
            echo json_encode(array('status' =>'1' ));exit;
		}else{
            $JurisdictionAction->admin_record($store_id,$admin_name,' 删除商品品牌ID为 '.$brand_id.' 失败',3);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除品牌ID为'.$brand_id.'失败';
            $lktlog->customerLog($Log_content);

            $db->rollback();
            echo json_encode(array('status' =>'0'));exit;
		};
    }

    public function execute(){
        return $this->getDefaultView();
    }

    public function getRequestMethods(){
        return Request :: NONE;
    }
}
?>