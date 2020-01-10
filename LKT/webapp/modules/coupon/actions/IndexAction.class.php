<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class IndexAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');

        $name = addslashes(trim($request->getParameter('name'))); // 优惠券名称
        $activity_type = addslashes(trim($request->getParameter('activity_type'))); // 活动类型
        $status = addslashes(trim($request->getParameter('status'))); // 是否过期

        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=coupon&action=Config');
        $button[1] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=coupon&action=Add');
        $button[2] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=coupon&action=Coupon');
        $button[3] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=coupon&action=Modify');
        $button[4] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=coupon&action=Del');

        $pagesize = $request -> getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize:'10';
        // 每页显示多少条数据
        $page = $request -> getParameter('page');

        // 页码
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }

        $coupon_type_list = array();
        $sql0 = "select coupon_type from lkt_coupon_config where store_id = '$store_id'";
        $r0 = $db->select($sql0);
        if($r0){
            $coupon_type = explode(",", $r0[0]->coupon_type); // 优惠券类型
            foreach ($coupon_type as $k => $v){
                if($v == '1'){
                    $coupon_type_list[$v] = '免邮券';
                }else if($v == '2'){
                    $coupon_type_list[$v] = '满减券';
                }else if($v == '3'){
                    $coupon_type_list[$v] = '折扣券';
                }else if($v == '4'){
                    $coupon_type_list[$v] = '会员赠券';
                }
            }
        }
        $condition = " store_id = '$store_id' and recycle = 0 ";
        if($name != ''){
            $condition .= " and name like '%$name%'";
        }
        if($activity_type != '' && $activity_type != 0){
            $condition .= " and activity_type = '$activity_type'";
        }
        if($status != '' && $status != 0){
            if($status == 1){
                $condition .= " and status = '3'";
            }else{
                $condition .= " and status != '3'";
            }
        }

        $sql1 = "select * from lkt_coupon_activity where $condition";
        $r1 = $db->select($sql1);
        $total = count($r1);
        $pager = new ShowPager($total,$pagesize,$page);

        $sql = "select * from lkt_coupon_activity where $condition order by add_time desc limit $start,$pagesize";
        $r = $db->select($sql);
        $list = array();
        $time = date('Y-m-d H:i:s'); // 当前时间
        if($r){
            foreach ($r as $k => $v) {
                $id = $v->id; // 活动id
                $activity_type1 = $v->activity_type; // 活动类型
                $type1 = $v->type; // 活动类型
                $v->discount = floatval($v->discount);
                if($activity_type1 == 1){
                    $v->activity_type = '免邮券';
                }else if($activity_type1 == 2){
                    $v->activity_type = '满减券';
                }else if($activity_type1 == 3){
                    $v->activity_type = '折扣券';
                }else if($activity_type1 == 4){
                    $v->activity_type = '会员赠券';
                }
                if($type1 == 1){
                    $v->type = '全部商品';
                }else if($type1 == 2){
                    $v->type = '指定商品';
                }else if($type1 == 3){
                    $v->type = '指定分类';
                }
                if($v->start_time <= $time){ // 当前时间大于活动开始时间
                    // 根据id,修改活动状态
                    $sql2 = "update lkt_coupon_activity set status = 1 where store_id = '$store_id' and id = '$id'";
                    $db->update($sql2);
                    $v->status = 1;
                }
                // 当前时间大于活动结束时间
                if($v->end_time <= $time){
                    // 根据id,修改活动状态
                    $sql3 = "update lkt_coupon_activity set status = 3 where store_id = '$store_id' and id = '$id'";
                    $db->update($sql3);
                    $v->status = 3;
                }

                $sql4 = "select id from lkt_coupon where store_id = '$store_id' and hid = '$id' and type in (0,1)";
                $r4 = $db->select($sql4);
                if($r4){
                    $v->del_status = 1;
                }else{
                    $v->del_status = 2;
                }
            }
            $list = $r;
        }
        $url = "index.php?module=coupon&action=Index&activity_type=".urlencode($activity_type)."&name=".urlencode($name)."&status=".urlencode($status)."&pagesize=".urlencode($pagesize);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute('button', $button);

        $request->setAttribute('coupon_type', isset($coupon_type_list) ? $coupon_type_list : '');
        $request->setAttribute("activity_type",$activity_type);
        $request->setAttribute("name",$name);
        $request->setAttribute("status",$status);
        $request->setAttribute("list",$list);
        $request -> setAttribute('pages_show', $pages_show);
        $request -> setAttribute('pagesize', $pagesize);

        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }
    // 验证身份证格式是否正确
    public function is_idcard( $id )
    {
        $id = strtoupper($id);
        $id = '430181198901287554';
        $regx = "/(^\d{15}$)|(^\d{17}([0-9]|X)$)/";
        $arr_split = array();
        if(!preg_match($regx, $id))
        {
            return false;
        }
        if(15 == strlen($id)) //检查15位
        {
            $regx = "/^(\d{6})+(\d{2})+(\d{2})+(\d{2})+(\d{3})$/";

            @preg_match($regx, $id, $arr_split);
            //检查生日日期是否正确
            $dtm_birth = "19".$arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4];
            if(!strtotime($dtm_birth))
            {
                return FALSE;
            } else {
                return TRUE;
            }
        }
        else      //检查18位
        {
            $regx = "/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/";
            @preg_match($regx, $id, $arr_split);
            $dtm_birth = $arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4];
            if(!strtotime($dtm_birth)) //检查生日日期是否正确
            {
                return FALSE;
            }
            else
            {
                //检验18位身份证的校验码是否正确。
                //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
                $arr_int = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
                $arr_ch = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
                $sign = 0;
                for ( $i = 0; $i < 17; $i++ )
                {
                    $b = (int) $id{$i};
                    $w = $arr_int[$i];
                    $sign += $b * $w;
                }
                $n = $sign % 11;
                $val_num = $arr_ch[$n];
                if ($val_num != substr($id,17, 1))
                {
                    return FALSE;
                } //phpfensi.com
                else
                {
                    return TRUE;
                }
            }
        }

    }
}

?>