<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ModifyAction extends Action {

    public function getDefaultView() {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        // 接收分类id
        $brand_id = intval($request->getParameter("cid")); // 品牌id
        $class_list = array();
        $class_name = '';
        $categories = '';
        // 根据分类id,查询产品分类表
        $sql = "select * from lkt_brand_class where store_id = '$store_id' and brand_id = '$brand_id'";
        $r = $db->select($sql);
        if($r){
            $brand_name = $r[0]->brand_name; // 品牌名称
            $brand_pic = $r[0]->brand_pic; // 品牌图片
            $producer = $r[0]->producer; // 产地
            $remarks = $r[0]->remarks; // 备注
            $categories = $r[0]->categories; // 所属分类
            if($brand_pic){
                $brand_pic = ServerPath::getimgpath($brand_pic,$store_id); // 品牌图片
            }else{
                $brand_pic = '';
            }
            $categories = trim($categories,',');
            $res = explode(',',$categories);
            $res1 = array();
            foreach ($res as $k => $v){
                $sql0 = "select pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = 0 and cid = '$v'";
                $r0 = $db->select($sql0);
                if($r0){
                    $class_list[] = $r0[0]->pname ;
                    $res1[] = $v;
                }
            }
            $class_name = implode(',',$class_list);
            $categories = implode(',',$res1);
        }
        // 查询国家
        $sql0 = "select id,zh_name from lkt_ds_country where is_show = 1";
        $r0 = $db->select($sql0);

        $request->setAttribute("brand_id",$brand_id);
        $request->setAttribute("brand_name",$brand_name);
        $request->setAttribute('brand_pic', $brand_pic);
        $request->setAttribute('producer', $producer);
        $request->setAttribute('remarks', $remarks);
        $request->setAttribute('categories', $categories);
        $request->setAttribute('list', $r0);
        $request->setAttribute('class_name', $class_name);

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

        $brand_id = intval($request->getParameter('cid')); // 品牌id
        $brand_name = addslashes(trim($request->getParameter('brand_name'))); // 品牌名称
        $image = addslashes(trim($request->getParameter('image'))); // 品牌新图片
        $oldpic = addslashes(trim($request->getParameter('oldpic'))); // 品牌原图片
        $categories = addslashes(trim($request->getParameter('categories_str'))); // 所属分类
        $producer = addslashes(trim($request->getParameter('producer'))); // 产地
        $remarks = addslashes(trim($request->getParameter('remarks'))); // 备注

        if (!empty($image)) {
            if($image){
                $image = preg_replace('/.*\//','',$image);
            }else{
                $image = $oldpic;
            }
        } else {
            echo json_encode(array('status' => '品牌logo不能为空！'));
            exit;
        }

        if($brand_name == ''){
            echo json_encode(array('status' =>'品牌名称不能为空！' ));exit;
        }
        //检查分类名是否重复
        $sql = "select brand_name from lkt_brand_class where store_id = '$store_id' and brand_name = '$brand_name' and recycle = 0 and brand_id != '$brand_id' ";
        $r = $db->select($sql);
        if ($r) {
            echo json_encode(array('status' =>'商品品牌名称('.$brand_name.') 已经存在，请选用其他名称修改！' ));exit;

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
        //更新分类列表
        $sql = "update lkt_brand_class " .
            "set brand_name = '$brand_name',brand_pic = '$image',producer = '$producer',remarks = '$remarks',categories = '$categories'"
            ." where store_id = '$store_id' and brand_id = '$brand_id'";
        $r = $db->update($sql);

        if($r == -1) {
            $JurisdictionAction->admin_record($store_id,$admin_name,' 修改商品品牌ID为 '.$brand_id.' 失败',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改商品品牌ID为 '.$brand_id.' 失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();
            echo json_encode(array('status' =>'未知原因，修改产品品牌失败！' ));exit;
        } else {
            $JurisdictionAction->admin_record($store_id,$admin_name,' 修改商品品牌ID为 '.$brand_id.' 的信息',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改商品品牌ID为 '.$brand_id.' 成功';
            $lktlog->customerLog($Log_content);
            $db->commit();
            echo json_encode(array('status' =>'修改产品品牌成功！','suc'=>'1' ));exit;
        }
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>