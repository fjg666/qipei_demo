<?php/** * [Laike System] Copyright (c) 2018 laiketui.com * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details. */require_once(MO_LIB_DIR . '/DBAction.class.php');require_once(MO_LIB_DIR . '/ServerPath.class.php');require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');class DelAction extends Action {    /**     * <p>Copyright (c) 2018-2019</p>     * <p>Company: www.laiketui.com</p>     * @author 段宏波     * @date 2018/12/12  18:54     * @version 1.0     */    public function getDefaultView() {        $db = DBAction::getInstance();        $request = $this->getContext()->getRequest();        $store_id = $this->getContext()->getStorage()->read('store_id');        $admin_name = $this->getContext()->getStorage()->read('admin_name');        $store_type = $this->getContext()->getStorage()->read('store_type');        $JurisdictionAction = new JurisdictionAction();        $lktlog = new LaiKeLogUtils("common/banner.log");        // 接收信息        $id = intval($request->getParameter('id')); // 轮播图id        // 1.开启事务        $db->begin();        $sql = "select * from lkt_banner where store_id = '$store_id' and id = '$id'";        $r = $db->select($sql);        $image = ServerPath::getimgpath($r[0]->image,$store_id);        @unlink ($image);        // 根据轮播图id，删除轮播图信息        $sql = "delete from lkt_banner where store_id = '$store_id' and id = '$id'";        $res=$db->delete($sql);        if($res > 0){            $JurisdictionAction->admin_record($store_id,$admin_name,'删除轮播图id为'.$id,3);            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除轮播图ID为'.$id.'成功,类型为 '.$store_type;            $lktlog->customerLog($Log_content);            $db->commit();        }else{            $JurisdictionAction->admin_record($store_id,$admin_name,'删除轮播图id为'.$id.'失败',3);            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除轮播图ID为'.$id.'失败,类型为 '.$store_type;            $lktlog->customerLog($Log_content);            $db->rollback();        }        echo json_encode(array('status' =>$res));exit;        return;    }    public function execute(){        return $this->getDefaultView();    }    public function getRequestMethods(){        return Request :: NONE;    }}?>