<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class delAction extends Action {
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/12  14:35
     * @version 1.0
     */
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/product.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号

        // 接收信息
        $id = $request->getParameter('id'); // 产品id

        $num = 0;
        $id = rtrim($id, ','); // 去掉最后一个逗号
        $id = explode(',',$id); // 变成数组

        foreach ($id as $k => $v){
            $res = Tools::del_banner($db,$store_id,$v,'productId');
            if($res == false){
                echo json_encode(array('status' =>'2','info' =>'此商品已被使用，请取消绑定后再做删除操作！' ));exit;
            }
        }
        foreach ($id as $k => $v){
            $rew = $this->chaxun($v);

            if($rew == 2){
                $JurisdictionAction->admin_record($store_id,$admin_name,'商品ID为'.$v.'有参与插件活动，无法删除',3);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 商品ID为'.$v.'有参与插件活动，无法删除';
                $lktlog->customerLog($Log_content);
                $db->rollback();

                echo json_encode(array('status' => '2','info'=>'该商品有参与插件活动，无法删除！'));
                return;
            }else if($rew == 3){
                $JurisdictionAction->admin_record($store_id,$admin_name,'商品ID为'.$v.'有未完成的订单，无法删除',3);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 商品ID为'.$v.'有未完成的订单，无法删除';
                $lktlog->customerLog($Log_content);
                $db->rollback();

                echo json_encode(array('status' => '2','info'=>'该商品有未完成的订单，无法删除！'));
                return;
            }else{
                // 删除购物车里的数据
                $sql = "delete from lkt_cart where Goods_id = '$v'";
                $db->delete($sql);
                // 删除我的足迹数据
                $sql = "delete from lkt_user_footprint where Goods_id = '$v'";
                $db->delete($sql);
                // 删除我的收藏里的数据
                $sql = "delete from lkt_user_collection where Goods_id = '$v'";
                $db->delete($sql);
                // 根据产品id，删除产品信息
                $sql = "update lkt_product_list set recycle = 1,status = 1 where id = '$v'";
                $db->update($sql);
                // 根据产品id，删除产品属性信息
                $sql = "update lkt_configure set recycle = 1 where pid = '$v'";
                $db->update($sql);

                $sql = "update lkt_product_img set recycle = 1 where product_id = '$v'";
                $db->update($sql);

                $JurisdictionAction->admin_record($store_id,$admin_name,' 删除商品ID为 '.$v.' 的信息',3);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除商品ID为 '.$v.' 的信息';
                $lktlog->customerLog($Log_content);
            }
        }
        $db->commit();

        $res = array('status' => '1','info'=>'成功！');
        echo json_encode($res);
        return;
    }

    public function execute(){
        return $this->getDefaultView();
    }


    public function getRequestMethods(){
        return Request :: NONE;
    }

    public function chaxun($id){
        $db = DBAction::getInstance();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $sql0 = "select product_class,status,brand_id,mch_id from lkt_product_list as a where a.store_id = '$store_id' and a.recycle = 0 and a.mch_status = 2 and a.id = '$id'";
        $r0 = $db->select($sql0);
        if($r0[0]->status == 2){ // 当为上架状态
            // 砍价
            $sql00 = "SELECT * FROM `lkt_bargain_goods`  where store_id = '$store_id' and status = 1 and is_delete = 0 and goods_id = '$id' ";
            $r00 = $db->select($sql00);
            if($r00){
                return 2;
            }

            // 拼团
            $sql01 = "SELECT g_status from lkt_group_product where store_id = '$store_id' and product_id = '$id' and is_delete = 0 and (g_status = 2 or g_status = 1)";
            $r01 = $db->select($sql01);
            if($r01){
                return 2;
            }

            // 竞拍
            $sql02 = "(select attribute from lkt_auction_product where store_id = '$store_id' and status in (0,1) ) union (select attribute from lkt_auction_product where store_id = '$store_id' and status = 2 and is_buy = 0)";
            $r02 = $db->select($sql02);
            $arr = array();//正在进行活动中的商品id数组
            if($r02){
                foreach ($r02 as $k => $v) {
                    $attr = $v->attribute;//序列化的字符串
                    $attr = unserialize($attr);
                    $arr[$k] = array_keys($attr)[0];//商品id数组
                }
                if(in_array($id, $arr)){
                    return 2;
                }
            }

            // 优惠券
            $sql03 = "select type,product_class_id,product_id from lkt_coupon_activity where store_id = '$store_id' and recycle = 0 and status in (0,1,2)";
            $r03 = $db->select($sql03);
            if($r03){
                foreach ($r03 as $key => $val){
                    if($val->type == 2){
                        $product_list = unserialize($val->product_id);
                        $product_list = explode(',',$product_list);
                        if(in_array($id,$product_list)){
                            return 2;
                        }
                    }
                }
            }

            // 满减
            $sql05 = "select pro_id from lkt_subtraction_config where store_id = '$store_id' ";
            $r05 = $db->select($sql05);
            if($r05){
                $pro_id = explode(',',$r05[0]->pro_id);
                if(in_array($id,$pro_id)){
                    return 2;
                }
            }

            $sql1 = "select a.* from lkt_product_list as a left join lkt_order_details as b on a.id = b.p_id where a.store_id = '$store_id' and a.recycle = 0 and a.mch_status = 2 and r_status in (0,1,2) and a.id = '$id'";
            $r1 = $db->select($sql1);
            if($r1){
                return 3;
            }
            //会员赠送商品
            $sql_06 = "select is_product from lkt_user_rule where store_id = $store_id";
            $res_06 = $db->select($sql_06);
            if($res_06){
                $is_product = $res_06[0]->is_product;//0-未开通 1-开通
                if($is_product == 1){
                    $sql06 = "select id from lkt_user_grade where store_id = $store_id and pro_id = $id";
                    $res06 = $db->select($sql06);
                    if($res06){
                        return 2;
                    }
                }
            }

            return 1;
        }else{
            return 1;
        }
        return;
    }
}

?>