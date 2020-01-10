<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class AddAction extends Action {
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/12  16:07
     * @version 1.0
     */
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_id = $this->getContext()->getStorage()->read('admin_id'); // 管理员id
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $id = $request->getParameter('id'); // 商品属性id
        $pid = $request->getParameter('pid'); // 商品id
        $sql0 = "select a.product_number,a.product_title,a.product_class,a.brand_id,a.subtitle,a.label,c.total_num,c.num,c.attribute from lkt_configure as c,lkt_product_list as a where c.pid = a.id and a.store_id = '$store_id' and c.id = '$id' and c.pid = '$pid'";
        $r0 = $db->select($sql0);
        if($r0){
            $total_num = $r0[0]->total_num;
            $num = $r0[0]->num;
        }
        echo json_encode(array('total_num'=>$total_num,'num'=>$num));
        exit;
        return View :: INPUT;
    }
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/12  16:07
     * @version 1.0
     */
    public function execute(){
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/stock.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        // 接收数据
        $admin_id = $this->getContext()->getStorage()->read('admin_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $id = addslashes(trim($request->getParameter('id'))); // 商品属性id
        $pid = addslashes(trim($request->getParameter('pid'))); // 商品id
        $total_num = addslashes(trim($request->getParameter('total_num'))); // 总库存
        $num = addslashes(trim($request->getParameter('num'))); // 剩余库存
        $add_num = addslashes(trim($request->getParameter('add_num'))); // 增加库存

        if (floor($add_num) != $add_num){
            echo json_encode(array('status' =>'增加库存请填写整数！' ));exit;
        }else{
            if($add_num <= 0){
                echo json_encode(array('status' =>'增加库存请填写正整数！' ));exit;
            }
            $total_num = $total_num + $add_num; // 总库存
            $x_num = $add_num + $num; // 剩余库存
        }

        $sql0 = "select num,min_inventory from lkt_product_list where store_id = '$store_id' and id = '$pid'";
        $r0 = $db->select($sql0);
        $z_num = $r0[0]->num + $add_num;
        $min_inventory = $r0[0]->min_inventory;

        $sql4 = "update lkt_product_list set num='$z_num' where store_id = '$store_id' and id = '$pid'";
        $r4 = $db->update($sql4);
        if($r4 == -1){
            $JurisdictionAction->admin_record($store_id,$admin_name,'增加商品规格ID为'.$id.'的库存失败',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 增加商品规格ID为'.$id.'的库存失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('status' =>'未知原因，增加失败！' ));exit;
        }

        $sql1 = "update lkt_configure set total_num = '$total_num',num = '$x_num' where id = '$id' and pid = '$pid'";
        $r1 = $db->update($sql1);

        $sql2 = "insert into lkt_stock(store_id,product_id,attribute_id,total_num,flowing_num,type,add_date) values('$store_id','$pid','$id','$total_num','$add_num',0,CURRENT_TIMESTAMP)";
        $r2 = $db->insert($sql2,'last_insert_id');
        if($r1 != -1 && $r2 > 0){
            if($min_inventory >= $x_num){
                $sql3 = "insert into lkt_stock(store_id,product_id,attribute_id,total_num,flowing_num,type,add_date) values('$store_id','$pid','$id','$total_num','$add_num',2,CURRENT_TIMESTAMP)";
                $r3 = $db->insert($sql3);
            }

            $JurisdictionAction->admin_record($store_id,$admin_name,'增加商品规格ID为'.$id.'的库存'.$add_num,2);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 增加商品规格ID为'.$id.'的库存'.$add_num;
            $lktlog->customerLog($Log_content);
            $db->commit();

            echo json_encode(array('status' =>'增加成功！' ,'suc'=>'1'));exit;
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,'增加商品规格ID为'.$id.'的库存失败',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 增加商品规格ID为'.$id.'的库存失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('status' =>'未知原因，增加失败！' ));exit;
        }
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>