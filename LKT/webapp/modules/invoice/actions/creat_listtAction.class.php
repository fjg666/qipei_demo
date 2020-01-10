<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

class creat_listtAction extends Action
{

    /**
     * [getDefaultView description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  周文
     * @version 2.0
     * @date    2019-2-22
     * @return  订单发货
     */
    public function getDefaultView()
    {
        $db = DBAction::getInstance();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');       

        $id = trim($request->getParameter('id')); // 订单id

        // 查询平台店铺id
        $sql = "select shop_id from lkt_admin where store_id='$store_id' and type=1";
        $r = $db->select($sql);
        $shop_id = $r?$r[0]->shop_id:1;

        $goods = array();
        $sql = "select o.courier_num,e.kuaidi_name from lkt_order_details o left join lkt_express e on o.express_id=e.id where o.store_id='$store_id' and o.id in ($id) group by o.courier_num";
        $ex = $db->select($sql);
        foreach ($ex as $key => $value) {
            $expresssn = $value->courier_num;
            $express = $value->kuaidi_name;
            if (!empty($id)) {
                $sql = "select d.user_id,d.id,d.r_sNo,d.p_name,d.size,d.num,o.name,o.mobile,o.sheng,o.shi,o.xian,o.address,o.remark,o.mch_id,p.weight from lkt_order_details as d left join lkt_product_list as p on p.id=d.p_id left join lkt_order as o on d.r_sNo=o.sNo where d.store_id = '$store_id' and d.id in ($id) and d.courier_num='$expresssn'";
                $res = $db->select($sql);
                $ids = '';
                if ($res) {
                    $res[0]->mch_id = ',1,';
                    $mch_id = $res[0]->mch_id;
                    $mch_id = substr($mch_id,1);
                    $mch_id = substr($mch_id,0,strlen($mch_id)-1);
                    if (intval($mch_id) != $shop_id) {
                        $sql = "select realname as sender,tel as s_mobile,sheng as s_sheng,shi as s_shi,xian as s_xian,address as s_address from lkt_mch where id='$mch_id'";
                        $mch = $db->select($sql);
                    }else{
                        $sql = "select name as sender,tel as s_mobile,sheng as s_sheng,shi as s_shi,xian as s_xian,address as s_address from lkt_service_address where store_id='$store_id' order by is_default desc limit 0,1";
                        $mch = $db->select($sql);
                    }
                    $s_id = $mch_id;
                    $sender = $mch[0]->sender;
                    $s_mobile = $mch[0]->s_mobile;
                    $sss = $this->adddd($mch[0]->s_sheng,$mch[0]->s_shi);
                    $s_sheng = $sss['sheng'];
                    $s_shi = $sss['shi'];
                    $s_xian = $mch[0]->s_xian;
                    $s_address = $mch[0]->s_address;
                    $remark = $res[0]->remark;
                    $recipient = $res[0]->name;
                    $r_mobile = $res[0]->mobile;
                    $sss = $this->adddd($res[0]->sheng,$res[0]->shi);
                    $r_sheng = $sss['sheng'];
                    $r_shi = $sss['shi'];
                    $r_xian = $res[0]->xian;
                    $r_address = $res[0]->address;
                    $sNo = $res[0]->r_sNo;
                    $r_userid = $res[0]->user_id;
                    $title = '';
                    $num = 0;
                    $weight = 0;
                    foreach ($res as $k => $v) {
                        $num += $v->num;
                        $weight += $v->weight;
                        $title .= $v->size.' '.$v->p_name.' ';
                        $ids .= $v->id.',';
                    }
                    $ids = substr($ids,0,strlen($ids)-1); 

                    $sql = "select * from lkt_printing where store_id='$store_id' and d_sNo = '$ids' and type=2";
                    $good = $db->select($sql);
                    if (!$good) {
                        $sql = "insert into `lkt_printing` (`store_id`, `title`, `sNo`, `d_sNo`, `num`, `weight`, `sender`, `s_mobile`, `s_sheng`, `s_shi`, `s_xian`, `s_address`, `recipient`, `r_mobile`, `r_sheng`, `r_shi`, `r_xian`, `r_address`, `status`, `create_time`, `type`, `remark`, `express`, `expresssn`,`r_userid`,`s_id`) VALUES ('$store_id', '$title', '$sNo', '$ids', '$num', '$weight', '$sender', '$s_mobile', '$s_sheng', '$s_shi', '$s_xian', '$s_address', '$recipient', '$r_mobile', '$r_sheng', '$r_shi', '$r_xian', '$r_address', '0', CURRENT_TIMESTAMP, '2', '$remark', '$express', '$expresssn', '$r_userid', '$s_id')";
                        $rid = $db->insert($sql,"last_insert_id");

                        $sql = "select * from lkt_printing where store_id='$store_id' and id = '$rid'";
                        $good = $db->select($sql);
                    }
                    foreach ($good as $k => $v) {
                        $goods[] = $v;
                    }
                }
            }
        }

        
        $request->setAttribute("goods", $goods);
        // $request->setAttribute("type", $type);
        return View :: INPUT;

    }

    public function adddd($sheng,$shi){

        if(strpos($sheng,'北京') !== false){ 
            $sheng = '北京';
            $shi = '北京市';
        }
        if(strpos($sheng,'天津') !== false){ 
            $sheng = '天津';
            $shi = '天津市';
        }
        if(strpos($sheng,'上海') !== false){ 
            $sheng = '上海';
            $shi = '上海市';
        }
        if(strpos($sheng,'重庆') !== false){ 
            $sheng = '重庆';
            $shi = '重庆市';
        }

        return array('sheng' => $sheng, 'shi' => $shi);
    }


    /**
     * [execute description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2018-12-25T10:57:43+0800
     * @return  操作订单详情
     */
    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        //m指向具体操作方法
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $id = trim($request->getParameter('id'));
        $type = intval($request->getParameter('type'));


        echo json_encode(array('status' => 0,'msg'=>'输入值有误！'));exit;
        exit;
    }

    public function getRequestMethods()
    {

        return Request :: POST;

    }


}


?>