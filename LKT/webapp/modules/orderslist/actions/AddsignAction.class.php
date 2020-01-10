<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/GETUI/LaikePushTools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/SF.class.php');

class AddsignAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $id = $request->getParameter('id');
        //运费
        $sql02 = "select * from lkt_express ";
        $r02 = $db->select($sql02);
        if (isset($_GET['otype'])) {
            $request->setAttribute("otype", $_GET['otype']);
        } else {
            $request->setAttribute("otype", 'yb');
        }
        $request->setAttribute("express", $r02);
        $request->setAttribute("id", $id);
        return View::INPUT;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $lktlog = new LaiKeLogUtils("common/orderslist.log");

        //开启事务
        $db->begin();
        $sNo = trim($request->getParameter('sNo')); // 订单详情表id

        $trade = intval($request->getParameter('trade')) - 1;
        $express_id = $request->getParameter('express'); // 快递公司id

        $courier_num = $request->getParameter('courier_num'); // 快递单号

        $express_type = intval($request->getParameter('express_type')); // 发货类型 1.手动发货 2.自动发货

        $otype = addslashes(trim($request->getParameter('otype'))); // 类型
        $express_name = $request->getParameter('express_name'); // 快递公司名称
        $detaildIdArrs = explode(",", $sNo);
        $len = count($detaildIdArrs);//前端选择的订单记录数
        $con = " ";

        if ($express_type == 2) {
            $mini_sno = '';
            $send_res = array();
            if (!empty($sNo)) {
                $res = $this->put_sf($sNo);
                if ($res['head'] == 'OK') {
                    $courier_num = $res['mailno'];
                    $send_res = $res;
                } else {
                    $db->rollback();
                    echo json_encode(array('err' => '获取快递单号失败，' . $res['message'] . '！', 'status' => 0));
                    exit;
                    exit();
                }
            }
        }

        if (!empty($express_id)) {
            $con = ",express_id='$express_id'";
        } else {
            $db->rollback();
            echo json_encode(array('err' => '请选择快递公司', 'status' => 0));
            exit;
            exit();
        }
        if (!empty($courier_num)) {
            $sql = "select id from lkt_order_details where express_id = '$express_id' and courier_num = '$courier_num'";
            $rr = $db->select($sql);
            if ($rr) {
                $db->rollback();
                echo json_encode(array('err' => '快递单号已存在', 'status' => 0));
                exit;
                exit();
            } else {
                $con .= ",courier_num ='$courier_num'";
            }
        } else {
            $db->rollback();
            echo json_encode(array('err' => '请输入快递单号', 'status' => 0));
            exit;
            exit();
        }

        $time = date('Y-m-d H:i:s', time());
        $con .= ",deliver_time= ' $time '";

        LaiKeLogUtils::lktLog("otype=" . $otype);
        if ($otype == 'yb' || $otype == 'JP' || $otype == "integral" || $otype == 'vipzs' || $otype == 'MS' || $otype == 'VIP') {
            //退货情况多个商品，某一个退货的时候
            $sql = "select express_id,r_sNo from lkt_order_details where id in($sNo) and r_status = '4' ";
            $rrup = $db->selectrow($sql);
            if ($rrup) {
                $sql_o = "select r_sNo from lkt_order_details where store_id = '$store_id' and id = '$sNo' and r_status = '4'";
                $res_o = $db->select($sql_o);
                if ($rrup <= 1) {
                    $ssooid = $res_o[0]->r_sNo;
                    $sqll = "update lkt_order set status='$trade' where store_id = '$store_id' and sNo='$ssooid'";
                    $rl = $db->update($sqll);
                    //判断是否修改成功
                    if ($rl > 0) {
                        $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单状态成功！");
                    } else {
                        $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单状态失败！sql:" . $sqll);
                    }
                }

                $sqld = "update lkt_order_details set r_status='$trade' $con where id in($sNo)  and r_status = '4'";
                $rd = $db->update($sqld);
                if ($rd < 1) {
                    $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单详情状态失败！sql:" . $sqld);
                    $db->rollback();
                    exit();
                }
                // 自动发货 生成发货单快递单
                if ($express_type == 2) {
                    $send_ = $this->send_ok($sNo, $courier_num, $express_name, $send_res);
                    if ($send_ > 0) {
                        $db->rollback();
                        echo json_encode(array('err' => '发货失败啦！' . $send_, 'status' => 0));
                        exit;
                    }
                }
                $JurisdictionAction->admin_record($store_id, $admin_name, ' 修改单号为 ' . $sNo . ' 的订单 ', 7);
                $db->commit();
                echo json_encode(array('succ' => '操作成功！', 'status' => 1));
                exit;
                exit();
            }

            $sqld = "update lkt_order_details set r_status='$trade' $con where id in($sNo) and r_status = '1'";
            LaiKeLogUtils::lktLog($sqld . "=trade=" . __LINE__);
            $rd = $db->update($sqld);
            if ($rd < 1) {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单详情状态失败！sql:" . $sqld);
                $db->rollback();
                echo json_encode(array('err' => '网络故障,发货失败！！', 'status' => 0));
                exit;
                exit();
            }

            //查询订单信息
            $sql_p = "select o.id,o.user_id,o.sNo,d.p_name,d.p_id,d.sid,d.num,o.name,o.address from lkt_order as o left join lkt_order_details as d on o.sNo=d.r_sNo where o.store_id = '$store_id' and d.id in($sNo) ";
            LaiKeLogUtils::lktLog($sql_p . "=查询订单信息=" . __LINE__);
            $res_p = $db->select($sql_p);
            $count = 0;//统计详细订单记录数
            $batchSend = false;//是否批量发货
            $curSendPos = 0; //统计当前发货次数
            foreach ($res_p as $key => $value) {
                LaiKeLogUtils::lktLog("=商品ID=" . $value->p_id . __LINE__);
                $p_name = $value->p_name;
                $user_id = $value->user_id;
                $address = $value->address;
                $name = $value->name;
                $order_id = $value->id;
                $oid = $value->sNo;
                $p_id = $value->p_id;
                $sid = $value->sid;
                $num = $value->num;
                $curSendPos = $curSendPos + 1;
                if ($count == 0) {
                    $sql = "select id from lkt_order_details where r_status in (1,2) and r_sNo='$oid'";
                    //所有为已发货状态的订单详情跟所选订单一样多的情况下为批量发货
                    $count = $db->selectrow($sql);
                    LaiKeLogUtils::lktLog(__LINE__ . "===Finish '$len' FHUO===" . $count);
                    LaiKeLogUtils::lktLog(__LINE__ . "(==)" . $sql);
                    if ($count == $len) {
                        //批量发货
                        $batchSend = true;
                    }
                }

                //发货结束修改订单状态
                $upod = $db->selectrow("select id from lkt_order_details where r_status = 1 and r_sNo='$oid'");
                LaiKeLogUtils::lktLog("=商品ID=" . "select id from lkt_order_details where r_status = 1 and r_sNo='$oid'");
                $sendFinish = (!$upod && !$batchSend) || ($batchSend && $curSendPos == $len);
                LaiKeLogUtils::lktLog(__LINE__ . $batchSend . "===Finish FHUO===" . $curSendPos);
                if ($sendFinish) {
                    $sqll = "update lkt_order set status='$trade' where sNo='$oid'";
                    $rl = $db->update($sqll);
                    LaiKeLogUtils::lktLog($rl . "===" . __LINE__ . "===Finish FHUO===" . $sqll);
                    if ($rl < 0) {
                        $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "发货失败！sql:" . $sqll);
                        $db->rollback();
                        echo json_encode(array('err' => '发货失败！', 'status' => 0));
                        exit;
                        exit();
                    } else {
                        $msg_title = "【" . $oid . "】订单发货啦！";
                        $msg_content = "您购买的商品已经在赶去见您的路上啦~";

                        $JurisdictionAction->admin_record($store_id, $admin_name, ' 使订单号为 ' . $sNo . ' 的订单发货 ', 7);
                        LaiKeLogUtils::lktLog($msg_title);
                        /**发货成功通知*/
                        $pusher = new LaikePushTools();
                        $pusher->pushMessage($user_id, $db, $msg_title, $msg_content, $store_id, $admin_name);
                    }
                }
                $sql0 = "select num from lkt_product_list where store_id = '$store_id' and id = '$p_id'";
                $r0 = $db->select($sql0);
                $total_num = $r0[0]->num;

                $sql = "insert into lkt_stock(store_id,product_id,attribute_id,total_num,flowing_num,type,user_id,add_date) values('$store_id','$p_id','$sid','$total_num','$num',1,'$user_id',CURRENT_TIMESTAMP)";
                $r_11 = $db->insert($sql);
            }
            // 自动发货 生成发货单快递单
            if ($express_type == 2) {
                $send_ = $this->send_ok($sNo, $courier_num, $express_name, $send_res);
                if ($send_ > 0) {
                    $db->rollback();
                    echo json_encode(array('err' => '发货失败啦！' . $send_, 'status' => 0));
                    exit;
                }
            }
            $db->commit();
            echo json_encode(array('succ' => '发货成功！！', 'status' => 1));
            exit;
            exit();

        } else if ($otype == 'pt' || $otype == 'KJ') {

            $sqld = 'update lkt_order_details set ' . substr($con, 1) . ' where id="' . $sNo . '"';
            $rd = $db->update($sqld);
            $msgsql = "select o.id,o.user_id,o.sNo,d.p_name,o.name,o.address from lkt_order as o left join lkt_order_details as d on o.sNo=d.r_sNo where o.store_id = '$store_id' and d.id='$sNo'";
            $msgres = $db->select($msgsql);

            if (!empty($msgres))
                $msgres = $msgres[0];
            $uid = $msgres->user_id;

            $oid = $msgres->sNo;
            $sqll = 'update lkt_order set status=2 where sNo="' . $oid . '"';
            LaiKeLogUtils::lktLog("===Finish FHUO===" . __LINE__);
            $rl = $db->update($sqll);
            if ($rl < 1) {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单状态失败！sql:" . $sqll);
            }
            $sqld = "update lkt_order_details set r_status='$trade' $con where id in($sNo) and r_status = '1'";
            $rd = $db->update($sqld);
            if ($rd < 1) {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "网络故障,发货失败！sql:" . $sqld);
                $db->rollback();
                echo json_encode(array('err' => '网络故障,发货失败！', 'status' => 0));
                exit;
                exit();
            }

            $openid = $db->select("select wx_id from lkt_user where store_id = '$store_id' and user_id='$uid'");
            $msgres->uid = $openid[0]->wx_id;
            $compa = "select kuaidi_name from lkt_express where id=$express_id";
            $compres = $db->select($compa);
            if (!empty($compres))
                $msgres->company = $compres[0]->kuaidi_name;
            $fromidsql = "select fromid from lkt_user_fromid where store_id = '$store_id' and open_id='$msgres->uid' and id=(select max(id) from lkt_user_fromid where open_id='$msgres->uid')";
            $fromid = $db->select($fromidsql);
            if (!empty($fromid)) {
                $msgres->fromid = $fromid[0]->fromid;
            } else {
                $msgres->fromid = '';
            }

            $msgres->courier_num = $courier_num;
            if ($rl > 0 && $rd > 0) {
                $sql = "select * from lkt_notice where store_id = '$store_id' ";
                $r = $db->select($sql);
                if ($r) {
                    $template_id = $r[0]->order_delivery;
                } else {
                    $template_id = '';
                }

                $msg_title = "【" . $sNo . "】订单发货啦！";
                $msg_content = "您购买的商品【" . $msgres->p_name . "】已经在赶去见您的路上啦~";
                //给用户发送消息
                $pusher = new LaikePushTools();
                $pusher->pushMessage($msgres->user_id, $db, $msg_title, $msg_content, $store_id, $admin_name);
                // 自动发货 生成发货单快递单
                if ($express_type == 2) {
                    $send_ = $this->send_ok($sNo, $courier_num, $express_name, $send_res);
                    if ($send_ > 0) {
                        $db->rollback();
                        echo json_encode(array('err' => '发货失败啦！' . $send_, 'status' => 0));
                        exit;
                    }
                }
                $JurisdictionAction->admin_record($store_id, $admin_name, ' 使订单号为 ' . $oid . ' 的订单发货 ', 7);
                $db->commit();
                echo json_encode(array('succ' => '发货成功！！！', 'status' => 1));
                exit;
                exit();
            } else {
                $db->rollback();
                echo json_encode(array('err' => '发货失败！', 'status' => 0));
                exit;
                exit();
            }
        } else {
            echo 'otype is null';
        }
    }


    /**
     * [getDefaultView description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  熊孔钰
     * @return  发货成功生成发货单 快递单
     * @version 2.0
     * @date    2019-09-03
     */
    public function send_ok($id, $expresssn, $express, $send_res)
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $lktlog = new LaiKeLogUtils("common/orderslist.log");

        // 查询平台店铺id
        $sql = "select shop_id from lkt_admin where store_id='$store_id' and type=1";
        $r = $db->select($sql);
        $shop_id = $r ? $r[0]->shop_id : 1;

        $mini_sno = $send_res['orderid'];
        $destcode = array_key_exists('destcode', $send_res) ? $send_res['destcode'] : '';
        $origincode = array_key_exists('origincode', $send_res) ? $send_res['origincode'] : '';

        $result_code = 0;
        if (!empty($id)) {
            $sql = "select d.user_id,d.id,d.r_sNo,d.p_name,d.size,d.num,o.name,o.mobile,o.sheng,o.shi,o.xian,o.address,o.remarks,o.mch_id,p.weight from lkt_order_details as d left join lkt_product_list as p on p.id=d.p_id left join lkt_order as o on d.r_sNo=o.sNo where d.store_id = '$store_id' and d.id in ($id) and d.courier_num='$expresssn'";
            $res = $db->select($sql);
            $ids = '';
            if ($res) {
                $res[0]->mch_id = ',1,';
                $mch_id = $res[0]->mch_id;
                $mch_id = substr($mch_id, 1);
                $mch_id = substr($mch_id, 0, strlen($mch_id) - 1);
                if (intval($mch_id) != $shop_id) {
                    $sql = "select realname as sender,tel as s_mobile,sheng as s_sheng,shi as s_shi,xian as s_xian,address as s_address from lkt_mch where id='$mch_id'";
                    $mch = $db->select($sql);
                } else {
                    $sql = "select name as sender,tel as s_mobile,sheng as s_sheng,shi as s_shi,xian as s_xian,address as s_address from lkt_service_address where store_id='$store_id' order by is_default desc limit 0,1";
                    $mch = $db->select($sql);
                }
                $s_id = $mch_id;
                $sender = $mch[0]->sender;
                $s_mobile = $mch[0]->s_mobile;
                $sss = $this->adddd($mch[0]->s_sheng, $mch[0]->s_shi);
                $s_sheng = $sss['sheng'];
                $s_shi = $sss['shi'];
                $s_xian = $mch[0]->s_xian;
                $s_address = $mch[0]->s_address;
                $remark = $res[0]->remarks;
                $recipient = $res[0]->name;
                $r_mobile = $res[0]->mobile;
                $sss = $this->adddd($res[0]->sheng, $res[0]->shi);
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
                    $title .= $v->size . ' ' . $v->p_name . ' ';
                    $ids .= $v->id . ',';
                }
                $ids = substr($ids, 0, strlen($ids) - 1);

                $sql = "select * from lkt_printing where store_id='$store_id' and d_sNo = '$ids' and type=2";
                $good = $db->select($sql);
                if (!$good) {
                    // 生成快递单
                    $sql = "insert into `lkt_printing` (`store_id`, `title`, `sNo`, `d_sNo`, `num`, `weight`, `sender`, `s_mobile`, `s_sheng`, `s_shi`, `s_xian`, `s_address`, `recipient`, `r_mobile`, `r_sheng`, `r_shi`, `r_xian`, `r_address`, `status`, `create_time`, `type`, `remark`, `express`, `expresssn`,`r_userid`,`s_id`,`mini_sno`,`destcode`,`origincode`,`isopen`) VALUES ('$store_id', '$title', '$sNo', '$ids', '$num', '$weight', '$sender', '$s_mobile', '$s_sheng', '$s_shi', '$s_xian', '$s_address', '$recipient', '$r_mobile', '$r_sheng', '$r_shi', '$r_xian', '$r_address', '0', CURRENT_TIMESTAMP, '2', '$remark', '$express', '$expresssn', '$r_userid', '$s_id','$mini_sno','$destcode','$origincode','1')";
                    $rid = $db->insert($sql, "last_insert_id");
                    if ($rid <= 0) {
                        $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "生成快递单失败！sql:" . $sql);
                        $result_code = 1;
                    }
                    // 生成发货单
                    $sql = "insert into `lkt_printing` (`store_id`, `title`, `sNo`, `d_sNo`, `num`, `weight`, `sender`, `s_mobile`, `s_sheng`, `s_shi`, `s_xian`, `s_address`, `recipient`, `r_mobile`, `r_sheng`, `r_shi`, `r_xian`, `r_address`, `status`, `create_time`, `type`, `remark`,`r_userid`,`s_id`,`isopen`) VALUES ('$store_id', '$title', '$sNo', '$id', '$num', '$weight', '$sender', '$s_mobile', '$s_sheng', '$s_shi', '$s_xian', '$s_address', '$recipient', '$r_mobile', '$r_sheng', '$r_shi', '$r_xian', '$r_address', '0', CURRENT_TIMESTAMP, '1', '$remark', '$r_userid', '$s_id','1')";
                    $rid = $db->insert($sql, "last_insert_id");
                    if ($rid <= 0) {
                        $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "生成发货单失败！sql:" . $sql);
                        $result_code = 2;
                    }
                }
            }
        }

        return $result_code;
    }

    /**
     * 配合快递地址
     * @param $sheng
     * @param $shi
     * @return array
     */
    public function adddd($sheng, $shi)
    {

        if (strpos($sheng, '北京') !== false) {
            $sheng = '北京';
            $shi = '北京市';
        }
        if (strpos($sheng, '天津') !== false) {
            $sheng = '天津';
            $shi = '天津市';
        }
        if (strpos($sheng, '上海') !== false) {
            $sheng = '上海';
            $shi = '上海市';
        }
        if (strpos($sheng, '重庆') !== false) {
            $sheng = '重庆';
            $shi = '重庆市';
        }

        return array('sheng' => $sheng, 'shi' => $shi);
    }

    /**
     * 发送成功后处理
     * @param $arr
     * @param $template_id
     */
    public function Send_success($arr, $template_id)
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $appid = $r[0]->appid;
            // 小程序唯一标识
            $appsecret = $r[0]->appsecret;
            // 小程序的 app secret
            $AccessToken = $this->getAccessToken($appid, $appsecret);
            $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $AccessToken;

        }

        $data = array();
        $data['access_token'] = $AccessToken;
        $data['touser'] = $arr->uid;
        $data['template_id'] = $template_id;
        $data['form_id'] = $arr->fromid;
        $data['page'] = "pages/order/detail?orderId=$arr->id";
        $minidata = array('keyword1' => array('value' => $arr->company, 'color' => "#173177"), 'keyword2' => array('value' => date('Y-m-d H:i:s', time()), 'color' => "#173177"), 'keyword3' => array('value' => $arr->p_name, 'color' => "#173177"), 'keyword4' => array('value' => $arr->sNo, 'color' => "#FF4500"), 'keyword5' => array('value' => $arr->address, 'color' => "#FF4500"), 'keyword6' => array('value' => $arr->courier_num, 'color' => "#173177"), 'keyword7' => array('value' => $arr->name, 'color' => "#173177"));
        $data['data'] = $minidata;
        $data = json_encode($data);

        $da = $this->httpsRequest($url, $data);
        $delsql = "delete from lkt_user_fromid where store_id = '$store_id' and open_id='$arr->uid' and fromid='$arr->fromid'";
        $db->delete($delsql);

    }

    /**
     * http网络请求
     * @param $url
     * @param null $data
     * @return bool|string
     */
    function httpsRequest($url, $data = null)
    {
        // 1.初始化会话
        $ch = curl_init();
        // 2.设置参数: url + header + 选项
        // 设置请求的url
        curl_setopt($ch, CURLOPT_URL, $url);
        // 保证返回成功的结果是服务器的结果
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //这个是重点。
        if (!empty($data)) {
            // 发送post请求
            curl_setopt($ch, CURLOPT_POST, 1);
            // 设置发送post请求参数数据
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        // 3.执行会话; $result是微信服务器返回的JSON字符串
        $result = curl_exec($ch);
        // 4.关闭会话
        curl_close($ch);
        return $result;
    }

    /**
     * 发货提醒
     * @param $appid
     * @param $appsecret
     * @param $form_id
     * @param $openid
     * @param $page
     * @param $send_id
     * @param $o_data
     * @param $store_id
     * @return bool|int|string
     */
    public function Send_Prompt($appid, $appsecret, $form_id, $openid, $page, $send_id, $o_data, $store_id)
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $Tools = new Tools($db, $store_id, '');
        $AccessToken = $Tools->getAccessToken($appid, $appsecret);
        if ($AccessToken == '') {
            $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $AccessToken;
            $data = json_encode(array('access_token' => $AccessToken, 'touser' => $openid, 'template_id' => $send_id, 'form_id' => $form_id, 'page' => $page, 'data' => $o_data));
            $da = $this->httpsRequest($url, $data);
            return $da;
        }
        return 1;
    }


    public function get_fromid($openid, $type = '')
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        if (empty($type)) {
            $fromidsql = "select fromid,open_id from lkt_user_fromid where store_id = '$store_id' and open_id='$openid' and id=(select max(id) from lkt_user_fromid where open_id='$openid')";
            $fromidres = $db->select($fromidsql);
            if ($fromidres) {
                $fromid = $fromidres[0]->fromid;
                $arrayName = array('openid' => $openid, 'fromid' => $fromid);
                return $arrayName;
            } else {
                return array('openid' => $openid, 'fromid' => '123456');
            }
        } else {
            $delsql = "delete from lkt_user_fromid where store_id = '$store_id' and open_id='$openid' and fromid='$type'";
            $re2 = $db->delete($delsql);
            return $re2;
        }

    }

    /**
     *
     * @param $id
     * @return string
     */
    public function put_sf($id)
    {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $sql = "select * from lkt_order_config where store_id = '$store_id'";
        $config = $db->select($sql);
        $custid = $config ? $config[0]->custid : '';
        $accesscode = $config ? $config[0]->accesscode : '';
        $checkword = $config ? $config[0]->checkword : '';

        $sql = "select shop_id from lkt_admin where store_id='$store_id' and type=1";
        $r = $db->select($sql);
        $shop_id = $r ? $r[0]->shop_id : 1;
        // 默认平台代发
        $sql = "select name as sender,tel as s_mobile,sheng as s_sheng,shi as s_shi,xian as s_xian,address as s_address from lkt_service_address where store_id='$store_id' order by is_default desc limit 0,1";
        $mch = $db->select($sql);
        if (!$mch) {
            $db->rollback();
            echo json_encode(array('err' => '平台暂无发货地址！', 'status' => 0));
            exit;
            exit();
        }
        $sss = $this->adddd($mch[0]->s_sheng, $mch[0]->s_shi);

        $sql = "select d.user_id,d.id,d.r_sNo,d.p_name,d.size,d.num,o.name,o.mobile,o.sheng,o.shi,o.xian,o.address,o.remark,o.mch_id,p.weight from lkt_order_details as d left join lkt_product_list as p on p.id=d.p_id left join lkt_order as o on d.r_sNo=o.sNo where d.store_id = '$store_id' and d.id in ($id)";
        $r_xx = $db->select($sql);
        $rrr = $this->adddd($r_xx[0]->sheng, $r_xx[0]->shi);
        $num = $r_xx[0]->num;
        $title = $r_xx[0]->size . ' ' . $r_xx[0]->p_name . ' ';
        foreach ($r_xx as $k => $v) {
            if (!empty($v) && $k != 0) {
                $num += intval($v->num);
                $title .= $v->size . ' ' . $v->p_name . ' ';
            }
        }
        $title = str_replace("+",'',$title);

        $post = array();
        $post['count'] = $num;
        $post['custid'] = $custid;
        $post['orderid'] = 'SF' . date("ymdhis") . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);

        // $post['j_company'] = '来客电商';
        $post['j_contact'] = $mch[0]->sender;
        $post['j_tel'] = $mch[0]->s_mobile;
        $post['j_province'] = $sss['sheng'];
        $post['j_city'] = $sss['shi'];
        $post['j_county'] = $mch[0]->s_xian;
        $post['j_address'] = $mch[0]->s_address;

        // $post['j_company'] = '来客推';
        $post['d_contact'] = $r_xx[0]->name;
        $post['d_tel'] = $r_xx[0]->mobile;
        $post['d_province'] = $rrr['sheng'];
        $post['d_city'] = $rrr['shi'];
        $post['d_county'] = $r_xx[0]->xian;
        $post['d_address'] = $r_xx[0]->address;

        $post['remark'] = $r_xx[0]->remark;
        $cargoes = array(
            'name' => $title
        );

        $config = array(
            'accesscode' => $accesscode,                               //商户号码
            'checkword' => $checkword,                                 //商户密匙
            'ssl' => false,                                      //是否ssl
            'server' => "http://bsp-oisp.sf-express.com/",          //http
            'uri' => 'bsp-oisp/sfexpressService',                //接口地址
        );
        $shunfeng = new SF($config);
        $getPayload_test = $shunfeng->Order($post, $cargoes);

        return $getPayload_test;
    }

    public function getRequestMethods()
    {
        return Request::POST;
    }
}

?>