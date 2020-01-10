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
class DeliveryAction extends Action
{

    /**
     * [getDefaultView description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  周文
     * @return  订单发货
     * @version 2.0
     * @date    2019-2-22
     */
    public function getDefaultView()
    {
        $db = DBAction::getInstance();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $id = $request->getParameter('id'); // 订单id

        $sql = "select o.p_sNo,o.otype,d.id,d.r_sNo,d.user_id,d.p_id,d.p_name,d.p_price,d.num,d.r_status,d.sid,d.size,p.imgurl,o.otype from lkt_order_details as d left join lkt_product_list as p on p.id=d.p_id left join lkt_order as o on d.r_sNo=o.sNo where d.store_id = '$store_id' and d.r_sNo='$id' and d.r_status=1";
        $res = $db->select($sql);
        $put = 1;
        foreach ($res as $k => $v) {
            $v->imgurl = ServerPath::getimgpath($v->imgurl, $store_id);

            if ($v->otype == 'integral') {
                $integralid = $v->p_sNo;
                $sql = "select g.integral,g.money,c.img from lkt_integral_goods as g left join lkt_configure as c on g.attr_id = c.id where g.id='$integralid'";
                $inr = $db->select($sql);
                if ($inr) {
                    $v->p_integral = $inr[0]->integral;
                    $v->p_price = $inr[0]->money;
                    $v->imgurl = ServerPath::getimgpath($inr[0]->img);
                }
            }

            $res[$k] = $v;
            if ($v->r_status == 1) {
                $put = 0;
            }
        }
        $sql02 = "select * from lkt_express ";
        $express = $db->select($sql02);
        $request->setAttribute("express", $express);
        $request->setAttribute("put", $put);
        $request->setAttribute("goods", $res);
        return View :: INPUT;

    }


    /**
     * [execute description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @return  操作订单详情
     * @version 2.0
     * @date    2018-12-25T10:57:43+0800
     */
    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        //m指向具体操作方法
        $m = trim($request->getParameter('m')) ? addslashes(trim($request->getParameter('m'))) : 'getDefaultView';
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $this->store_id = $store_id;
        $this->db = $db;
        //m指向具体操作方法
        $this->$m();
        exit;
    }

    /**
     * [updata description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @return  修改订单操作
     * @version 2.0
     * @date    2018-12-25T10:58:54+0800
     */
    public function updata()
    {
        $store_id = $this->store_id;
        $this->db->begin();

        $request = $this->getContext()->getRequest();
        $where = $request->getParameter('where');
        $updata = $request->getParameter('updata');

        $sNo = $where['sNo'];
        $status = $where['status'];

        foreach ($updata as $key => $value) {
            if (empty($value)) {
                $this->db->rollback();
                echo json_encode(array('status' => 0, 'msg' => '输入值有误！'));
                exit;
            }
            if ($key == 'z_price') {
                if ($value < 0) {
                    $this->db->rollback();
                    echo json_encode(array('status' => 0, 'msg' => '订单金额有误！'));
                    exit;
                }
            }

            if ($key == 'mobile') {
                if (!preg_match("/^1[34578]\d{9}$/", $value) || strlen($value) != 11) {
                    $this->db->rollback();
                    echo json_encode(array('status' => 0, 'msg' => '手机号格式不正确！'));
                    exit;
                }
            }
            $updata[$key] = addslashes($value);
        }

        //列出数据
        if ($status < 2) {
            $table = 'lkt_order';
            $ww = 'sNo';
        } elseif ($status == 2) {
            $table = 'lkt_order_details';
            $ww = 'r_sNo';
        } else {
            $this->db->rollback();
            echo json_encode(array('status' => 0, 'msg' => '操作失败！'));
            exit;
        }

        $res = $this->db->modify($updata, $table, "`$ww` ='$sNo' and `store_id` = '$store_id'");
        if ($res < 1) {
            $this->db->rollback();
            echo json_encode(array('status' => 0, 'msg' => '操作失败！'));
            exit;
        }

        $this->db->commit();
        echo json_encode(array('status' => 1, 'msg' => '操作成功！'));
        exit;
    }

  
    //快递公司搜索
    public function searchExpress(){
        $db = DBAction::getInstance();
        $store_id = $this->store_id;
        $request = $this->getContext()->getRequest();
        $express = $request->getParameter('express');//快递公司名称

        $sql = "select * from lkt_express where kuaidi_name like '%$express%' ";
        $res = $db->select($sql);
        if($res){
            echo json_encode(array('code'=>200,'data'=>$res));
            exit;
        }else{
            echo json_encode(array('code'=>109,'msg'=>'暂无该快递公司'));
            exit;
        }
    }
   

    public function getRequestMethods()
    {

        return Request :: POST;

    }


}


?>