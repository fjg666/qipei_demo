<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class StatusAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/brand_class.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $brand_id = $request->getParameter("brand_id"); // 分类id

        $sql = "select  MAX(sort) as sort from lkt_brand_class where recycle = 0 and store_id = '$store_id' ";
        $rr = $db->select($sql);
        $sort = $rr[0]->sort;
        $sort= $sort +1 ;

        $sql = "update lkt_brand_class set sort = '$sort' where recycle = 0 and store_id = '$store_id' and brand_id = '$brand_id'";
        $r = $db->update($sql);
        if($r > 0){
            $JurisdictionAction->admin_record($store_id,$admin_name,'置顶品牌ID为'.$brand_id.'成功',7);

            $Log_content = __METHOD__ . '->' . __LINE__ . ' 置顶品牌ID为'.$brand_id.'成功';
            $lktlog->customerLog($Log_content);

            $db->commit();
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,'置顶品牌ID为'.$brand_id.'失败',7);

            $Log_content = __METHOD__ . '->' . __LINE__ . ' 置顶品牌ID为'.$brand_id.'失败';
            $lktlog->customerLog($Log_content);

            $db->rollback();
        }
        echo $r;
        exit;
        return;


    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>